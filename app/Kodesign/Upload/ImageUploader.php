<?php
namespace App\Kodesign\Upload;

use App\Kodesign\Exception\UploaderException;
use Intervention\Image\Constraint;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;

class ImageUploader extends Uploader{

    protected $image_info;

    /**
     * @throws UploaderException
     */
    public function finalUpload(){

        $this->image_info = getimagesize($this->file->getRealPath());

        $copy_sizes = $this->getOption('copy_sizes') ?: $this->defaultSizes();

        foreach ($copy_sizes as $size_name => $size_options) {

            list ($width, $height) = explode('x', array_get($size_options, 'size'));

            $image = (new ImageManager())->make($this->file);

            $this->mime_type = $image->mime();
            $this->file_size = $image->filesize();

            if (! $this->checkMimeTypes($this->mime_type)) {
                throw new UploaderException($this->imageTypeError());
            }

            $image = $this->resize(array_get($size_options, 'resize_type'), $image, $width, $height);

            if ($this->getOption('add_watermark') && array_get($size_options, 'add_watermark')) {
                $image = $this->applyWatermark($image, $size_options);
            }

            $final_name = "{$this->base_root}{$this->base_name}-{$size_name}.{$this->base_extension}";

            $this->uploaded_files[$size_name] = $final_name;

            $image->save($final_name);
        }

        move_uploaded_file($this->file, $this->final_path);

        $this->uploaded_files['raw'] = $this->final_path;

        return $this->uploaded_files;
    }

    /**
     * Returns the path for uploaded image previews
     *
     * @return mixed
     */
    public function previewName()
    {
        if (!empty($this->uploaded_files['thumb'])) {
            return $this->uploaded_files['thumb'];
        }

        if (!empty($this->uploaded_files['main'])) {
            return $this->uploaded_files['main'];
        }

        return $this->uploaded_files['raw'];
    }

    /**
     * Returns the error for mime type
     *
     * @return bool|mixed
     */
    protected function typeError()
    {
        if ($this->getOption('only_jpg')) {
            return 'تنها تصاویر با فرمت jpg قابل آپلود هستند';
        }

        if ($this->getOption('only_png')) {
            return 'تنها تصاویر با فرمت png قابل آپلود هستند';
        }

        return 'فرمت تصویر ارائه شده پشتیبانی نمی شود';
    }

    /**
     * applies watermark on image
     *
     * @param Image $image
     * @param $size_options
     * @return Image
     */
    protected function applyWatermark(Image $image, $size_options)
    {
        $watermark_image = $this->getOption('watermark_image');

        $watermark = (new ImageManager())->make($watermark_image)->opacity(setting('WATERMARK_OPACITY') * 100);

        $image->insert($watermark, $this->watermarkPosition($size_options), 0, 0);

        return $image;
    }

    /**
     * Resize the given image object based on condition
     *
     * @param $resize_type
     * @param Image $imageObject
     * @param String $width
     * @param String $height
     * @return Image $imageObject
     */
    protected function resize($resize_type, $imageObject, $width, $height)
    {
        if ($resize_type === 'FIT') {
            $imageObject->fit($width, $height);
        }

        if ($resize_type === 'EXACT') {
            $imageObject = $this->exactResize($imageObject, $width, $height);
        }

        if ($resize_type === 'LARGE') {
            $imageObject = $this->largeResize($imageObject, $width, $height);
        }

        if ($resize_type === 'DYNAMIC') {

            if ($this->isLandscape()) {
                $imageObject->fit($width, $height);
            } else {
                $imageObject = $this->exactResize($imageObject, $width, $height);
            }
        }

        if ($resize_type === 'MAX-WIDTH') {
            $imageObject->resize($width, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }

        if ($resize_type === 'MAX-HEIGHT') {
            $imageObject->resize(null, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }

        return $imageObject;
    }

    /**
     * Resize the given image exactly with the given width and height
     *
     * @param Image $imageObject
     * @param $width
     * @param $height
     * @return Image
     */
    protected function exactResize($imageObject, $width, $height)
    {
        $imageObject->resize($width, $height, function ($constraint) {
            /** @var Constraint $constraint */
            $constraint->aspectRatio();
            $constraint->upsize();
        })->resizeCanvas($width, $height, 'center', false);

        return $imageObject;
    }

    /**
     * Resize the given image with large method
     *
     * @param Image $imageObject
     * @param $width
     * @param $height
     * @return Image
     */
    protected function largeResize($imageObject, $width, $height)
    {
        $imageObject->resize($width, $height, function ($constraint) {
            /** @var Constraint $constraint */
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        return $imageObject;
    }



    /**
     * Returns the position of watermark for current image
     *
     * @param array $size_options
     * @return string
     */
    protected function watermarkPosition(array $size_options)
    {
        $watermark_position = array_get($size_options, 'watermark_position');
        $resize_type = array_get($size_options, 'resize_type');

        if (!empty($watermark_position)) {
            return $watermark_position;
        }

        if ($resize_type === 'EXACT') {
            return 'bottom-center';
        }

        if ($resize_type === 'DYNAMIC' && !$this->isLandscape()) {
            return 'bottom-center';
        }

        return 'bottom-right';
    }

    /**
     * Checks if the image is landscape or not
     *
     * @return boolean
     */
    protected function isLandscape()
    {
        return $this->getAspectRatio() > 0.8;
    }

    /**
     * Returns the aspect ration of current image
     *
     * @return int
     */
    protected function getAspectRatio()
    {

        if (!empty($this->aspect_ratio)) {
            return $this->aspect_ratio;
        }

        $original_width = array_get($this->image_info, 0);
        $original_height = array_get($this->image_info, 1);

        $this->aspect_ratio = ($original_width / $original_height);
        return $this->aspect_ratio;
    }

    /**
     * Returns the default sizes for thumbnail generation
     *
     * @return array
     */
    protected function defaultSizes() {
        return defaultImageSizes();
    }

}
