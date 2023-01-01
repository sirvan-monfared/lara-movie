<?php
namespace App\Kodesign\Upload;

class VideoUploader extends Uploader{
    public function finalUpload() {
        $this->mime_type = $this->file->getMimeType();
        $this->file_size = $this->file->getSize();

        move_uploaded_file($this->file, $this->final_path);

        $this->uploaded_files['raw'] = $this->final_path;

        return $this->uploaded_files;
    }
}
