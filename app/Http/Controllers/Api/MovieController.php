<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Kodesign\Filters\MovieFilter;
use App\Models\Genre;
use App\Models\Movie;

class MovieController extends Controller
{
    public function index(MovieFilter $filter){
        $per_page = in_array(request('per-page'), [10, 20, 30, 40, 50, 100]) ? request('per-page') : 20;

        return Movie::latest()->with(['genres', 'featured'])->filter($filter)->paginate($per_page);
    }

    public function genres(){
        return Genre::orderBy('name', 'ASC')->get();
    }
}
