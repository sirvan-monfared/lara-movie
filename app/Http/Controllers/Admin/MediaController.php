<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\RedirectResponse;
use Mhor\MediaInfo\MediaInfo;

class MediaController extends Controller
{
    public function index() {
        return view('admin.media.index');
    }

    public function create(){
        return view('admin.media.create');
    }

    /**
     * sore media in database
     *
     * @return RedirectResponse
     */
    public function store(){
        $file_path = request('path');

        if (! file_exists($file_path)) {
            redirect()->back()->with('flash', 'فایل مورد نظر یافت نشد');
        }

        $file_info = pathinfo($file_path);

        if (! $file_info) {
            redirect()->back()->with('flash', 'فایل مورد نظر معتبر نمی باشد یا خراب است');
        }

        $mime_type = mime_content_type($file_path);

        $poster = json_decode(request('poster'));

        if ($poster && count($poster) > 0) {
            $poster_media = Media::find($poster[0]);
        }

        Media::create([
           'path' => array_get($file_info, 'dirname') . '/',
           'name' => array_get($file_info, 'filename'),
           'extension' => array_get($file_info, 'extension'),
           'title' => request('name') ?: array_get($file_info, 'filename'),
           'mime_type' => $mime_type,
           'type' => typeOfFile($mime_type),
           'size' => filesize($file_path),
           'metas->description' => '',
           'metas->video_poster' => isset($poster_media) ? $poster_media->id : null
        ]);

        return redirect()->back()->with('flash', 'عملیات با موفقیت انجام شد');
    }
}
