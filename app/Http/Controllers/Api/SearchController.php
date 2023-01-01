<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Person;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function person(){
        $keyword = request('keyword');

        return Person::where('name', 'LIKE', "%{$keyword}%")
                ->get();
    }
}
