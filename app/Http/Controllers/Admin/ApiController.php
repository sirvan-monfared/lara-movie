<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Kodesign\Exception\UploaderException;
use App\Kodesign\Filters\MediaFilter;
use App\Kodesign\Upload\Uploader;
use App\Models\Media;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Intervention\Image\Facades\Image;

class ApiController extends Controller
{
    /**
     * Upload images
     *
     * @return Response
     */
    public function upload()
    {
        try {
            $uploaded = (new Uploader())->setOptions([
                'input_name' => 'file',
                'max_size' => 2000,
                'valid_formats' => ['jpg','jpeg', 'JPG', "JPEG", 'png', 'PNG', 'mp4', 'MP4'],
                'valid_mime_types' => ['image/jpeg', 'image/png', 'video/mp4']
            ])->upload();

            $media = Media::create([
                'path' => $uploaded->root(),
                'name' => $uploaded->baseName(),
                'extension' => $uploaded->extension(),
                'title' => $uploaded->baseName(),
                'mime_type' => $uploaded->mime(),
                'type' => typeOfFile($uploaded->mime()),
                'size' => $uploaded->size(),
                'metas->description' => '',
            ]);

            return response([
                'message' => 'success',
                'media' => $media
            ], 200);

        } catch (UploaderException $e) {
            return response([
                'error' => $e->errors(),
            ], 406);
        }
    }

    /**
     * Returns all medias
     *
     * @param MediaFilter $filter
     * @return mixed
     */
    public function gallery(MediaFilter $filter){
        return Media::latest()->filter($filter)->get();
    }

    /**
     * Returns all medias for media manager
     *
     * @param MediaFilter $filter
     * @return mixed
     */
    public function mediaManager(MediaFilter $filter){
        return Media::with('poster')->latest()->filter($filter)->get();
    }

    /**
     * Returns a specific media
     *
     * @param Media $media
     * @return Media
     */
    public function media(Media $media){
        return $media->setAppends(['original_path', 'shamsi_date']);
    }

    /**
     * Update Media Details
     *
     * @param Media $media
     * @return Application|ResponseFactory|Response
     */
    public function updateMedia(Media $media){
        $sent_media = request('media');

        $media->update([
            'title' => $sent_media['title'],
            'metas->description' => $sent_media['metas']['description'],
        ]);

        if ($media->isVideo()) {
            $poster = json_decode(request('video_poster'));
            $poster_media_id = null;
            if (count($poster) > 0) {
                $poster_media_id = optional(Media::find($poster[0]))->id;
            }

            $media->update([
                'metas->video_poster' => $poster_media_id
            ]);
        }

        return response([
            'media' => $media->fresh()
        ], 200);
    }

    /**
     * Delete Media
     *
     * @param Media $media
     * @return Application|ResponseFactory|Response
     * @throws \Exception
     */
    public function deleteMedia(Media $media){

        foreach (defaultImageSizes() as $size_name => $size_options) {
            if (file_exists($media->path($size_name))) {
                unlink($media->path($size_name));
            }
        }
        if (file_exists($media->path())) {
            unlink($media->path());
        }

        $media->people()->detach();
        $media->movies()->detach();

        $media->delete();

        return response([
            'message' => 'delete successful'
        ], 200);
    }

    public function resizeImage(Media $media){
        $image = Image::make($media->path());
        $main_size = defaultImageSizes()[request('size_name')];

        $coordinates = request('cropper')['coordinates'];

        $image->crop($coordinates['width'], $coordinates['height'], $coordinates['left'], $coordinates['top']);

        $image->fit($main_size['width'], $main_size['height']);
        $image->save($media->path(request('size_name')));

        return response([
            'message' => 'suucess',
            'image' => $media->path(request('size_name'), true) . '?rand='. uniqid()
        ], 200);
    }

    /**
     * Returns array of all images sizes available
     *
     * @return array[]
     */
    public function imageSizes(){
        return defaultImageSizes();
    }
}
