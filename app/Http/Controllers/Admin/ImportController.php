<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Kodesign\ExcelImport;
use App\Models\Movie;
use App\Models\Person;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Mavinoo\Batch\Batch;

class ImportController extends Controller
{
    public function index()
    {
        ini_set('memory_limit', '-1');

        HeadingRowFormatter::default('none');

        $file = storage_path() . '/app/actors_irani.xlsx';

        $headings = (new HeadingRowImport)->toArray($file)[0][0];

//        $heading_people = array_map(function($person){
//            return [
//                'name' => correctArabicLetters($person),
//                'slug' => 'pr'. uniqid()
//            ];
//        }, $headings);
//
//        Person::insert($heading_people);

        Excel::import(new ExcelImport($headings), $file);

        return redirect(route('admin'))->with('flash', 'Import completed Successfully');
    }

    public function movieImages()
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '-1');
        ini_set('max_input_time', '-1');
        $images_path = storage_path() . '/app/images/movies/';

        $images = scandir($images_path);

        $movies = Movie::select('title', 'id')->get();

        foreach ($images as $image) {

            if ($image == '.' || $image == '..' || $image == 'found' || $image == 'not-found') continue;


            $base_name = removeExtension($image);

            $found = $movies->where('title', correctArabicLetters($base_name))->first();
            if ($found) {
                $found
                    ->addMedia($images_path . $image)
                    ->usingName($base_name)
                    ->usingFileName(uniqid() . time() . '.jpg')
                    ->toMediaCollection('featured');
            } else {
                rename($images_path . $image, $images_path . 'not-found/' . $base_name . '.jpg');
            }
        }

    }

    public function peopleImages()
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '-1');
        ini_set('max_input_time', '-1');

        $images_path = storage_path() . '/app/images/actors/';

        $images = scandir($images_path);

        $actors = Person::select('name', 'id')->get();

        foreach ($images as $image) {
            if ($image == '.' || $image == '..' || $image == 'found' || $image == 'not-found') continue;

            $base_name = removeExtension($image);

            $found = $actors->where('name', correctArabicLetters($base_name))->first();
            if ($found) {
                $found
                    ->addMedia($images_path . $image)
                    ->usingName($base_name)
                    ->usingFileName(uniqid() . time() . '.jpg')
                    ->toMediaCollection('featured');
            } else {
                rename($images_path . $image, $images_path . 'not-found/' . $base_name . '.jpg');
            }
        }
    }
}
