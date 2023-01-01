<?php
namespace App\Kodesign\Upload;

use App\Kodesign\Exception\UploaderException;
use Illuminate\Http\UploadedFile;

class Uploader {
    protected $options;

    /* @var ImageUploader|VideoUploader */
    protected $uploader;

    /**
     * @var UploadedFile|UploadedFile[]|array|null $file
     */
    protected $file;

    protected $error;

    protected $extension;

    protected $aspect_ratio;

    protected $uploaded_files = [];

    protected $base_root;

    protected $base_extension;

    protected $base_name;

    protected $final_path;

    protected $mime_type;

    protected $file_size;

    /**
     * Uploads Image
     *
     * @param null $fixed_extension
     *
     * @return $this;
     * @throws UploaderException
     */
    public function upload($fixed_extension = null)
    {
        $this->file = request()->file($this->getOption('input_name'));

        if ($this->isImage()) {
            $this->uploader = (new ImageUploader())->setOptions($this->options)->setFile($this->file);
        }

        if ($this->isVideo()) {
            $this->uploader = (new VideoUploader())->setOptions($this->options)->setFile($this->file);
        }

        if (! $this->uploader) {
            throw new UploaderException('فرمت فایل ارسال شده معتبر نمی باشد');
        }

        $this->uploader->prepare();

        if (! empty($this->uploader->error)) {
            throw new UploaderException($this->uploader->error);
        }

        $this->uploader->base_root = $this->getOption('root') ?: $this->baseDirectory();

        $this->uploader->base_extension = ($fixed_extension) ?: $this->uploader->extension;

        $this->uploader->base_name = removeExtension($this->file->getClientOriginalName());

        $file_name = "{$this->uploader->base_name}.{$this->uploader->base_extension}";
        if (file_exists($this->uploader->base_root . $file_name)) {
            $this->uploader->base_name = "{$this->uploader->base_name}". uniqid();
            $file_name = "{$this->uploader->base_name}.{$this->uploader->base_extension}";
        }

        $this->uploader->final_path = $this->uploader->base_root . $file_name;

        $this->uploader->finalUpload();

        return $this->uploader;
    }

    /**
     * Returns path of all uploaded images
     *
     * @return mixed
     */
    public function all()
    {
        return $this->uploaded_files;
    }

    /**
     * Returns relative path to uploaded image (raw)
     *
     * @return mixed
     */
    public function path()
    {
        return $this->final_path;
    }

    /**
     * Returns the base directory for uploaded image (raw)
     *
     * @return mixed
     */
    public function root(){
        return $this->base_root;
    }

    /**
     * Returns the base name of all uploaded raw image (without extension)
     *
     * @return string
     */
    public function baseName()
    {
        return $this->base_name;
    }

    /**
     * Returns the full name of uploaded image (raw)
     *
     * @return string
     */
    public function fullName(){
        return "{$this->base_name}.{$this->base_extension}";
    }

    /**
     * Returns mime type of uploaded image
     *
     * @return string
     */
    public function mime(){
        return $this->mime_type;
    }

    /**
     * Returns file size (kb) of uploaded image (raw)
     *
     * @return string
     */
    public function size(){
        return $this->file_size;
    }

    /**
     * Returns the base extension of uploaded images
     *
     * @return string
     */
    public function extension(){
        return $this->base_extension;
    }

    /**
     * Returns upload error
     *
     * @return mixed
     */
    public function errors()
    {
        return $this->error;
    }

    /**
     * Handles primary validations and preparations
     *
     * @return bool
     */
    protected function prepare()
    {
        if (! $this->file) {
            $this->error = 'هیچ فایلی برای آپلود انتخاب نشده است';
            return false;
        }

        if (! $this->passesPrimaryValidation()) {
            return false;
        }

        if (! $this->checkMimeTypes($this->file->getMimeType())) {
            $this->error = $this->typeError();
            return false;
        }

        $this->extension = $this->file->extension();
        if (! $this->passesExtensionValidation($this->extension)) {
            $this->error = $this->typeError();
            return false;
        }

        if (! $this->passesSizeValidation($this->file->getSize())) {
            $this->error = 'حجم فایل انتخاب شده بیش از مقدار مجاز است';
            return false;
        }

        return true;
    }

    /**
     * Check if the uploaded image passes the primary validations
     *
     * @return bool
     */
    protected function passesPrimaryValidation()
    {
        if (empty($this->file->getError())) return true;

        switch ($this->file->getError()) {
            case 1:
            case 2:
                $this->error = 'حجم فایل انتخاب شده بیش از مقدار مجاز است';
                break;
            case 3:
                $this->error = 'فایل به درستی آپلود نشده است. لطفا مجددا تلاش نمایید';
                break;
            case 8:
                $this->error = 'فایل انتخاب شده تصویر نمی باشد';
                break;
            case 4:
            case 6:
            case 7:
            case 999:
            default:
                $this->error = 'خطا! آپلود انجام نشد ... لطفا مجددا تلاش نمایید';
                break;
        }

        return false;
    }

    /**
     * check and validates mime type
     *
     * @param $mimeType
     * @return bool
     */
    protected function checkMimeTypes($mimeType)
    {
        if (! $this->getOption('valid_mime_types')) return true;

        $valid_mimes = $this->getOption('valid_mime_types');

        if (count($valid_mimes) == 0 || (count($valid_mimes) > 0 && in_array($mimeType, $valid_mimes))) {
            return true;
        }

        return false;
    }

    /**
     * Check if the extension is valid
     *
     * @param $extension
     * @return bool
     */
    protected function passesExtensionValidation($extension)
    {
        if (! $this->getOption('valid_formats')) return true;

        $valid_extensions = $this->getOption('valid_formats');
        if (count($valid_extensions) == 0 || (count($valid_extensions) > 0 && in_array($extension, $valid_extensions))) {
            return true;
        }

        return false;
    }

    /**
     * Check if the file size is valid
     *
     * @param $size
     * @return bool
     */
    protected function passesSizeValidation($size)
    {
        $max_size = $this->getOption('max_size');

        if (empty($max_size) || (!empty($max_size) && $size <= ($max_size * 1024))) {
            return true;
        }

        return false;
    }

    /**
     * Generates a random name
     *
     * @return string
     */
    protected function generateName()
    {
        return time() . uniqid();
    }

    /**
     * Returns the requested option value
     *
     * @param $option_name
     * @return mixed
     */
    protected function getOption($option_name)
    {
        return array_get($this->options, $option_name);
    }

    protected function baseDirectory(){
        $base_dir = 'images/media/' . date('Y');

        if (! is_dir($base_dir)) {
            mkdir($base_dir);
        }

        $final_directory = $base_dir .'/'. date('m') . '/';

        if (! is_dir($final_directory)) {
            mkdir($final_directory);
        }

        return $final_directory;
    }

    /**
     * Check if uploaded file is video or not
     *
     * @return bool
     */
    public function isVideo() {
        return (isVideo($this->file->getMimeType()));
    }

    /**
     * Check if uploaded file is image or not
     *
     * @return bool
     */
    public function isImage(){
        return isImage($this->file->getMimeType());
    }

    /**
     * Sets the upload options
     *
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options){
        $this->options = $options;

        return $this;
    }

    /**
     * sets the file property
     *
     * @param $file
     * @return $this
     */
    public function setFile($file){
        $this->file = $file;
        return $this;
    }
}
