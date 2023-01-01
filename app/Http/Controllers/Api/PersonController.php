<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Kodesign\Filters\PersonFilter;
use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function index(PersonFilter $filter){
        $per_page = in_array(request('per-page'), [10, 20, 30, 40, 50, 100]) ? request('per-page') : 20;

        return Person::latest('id')->with(['featured'])->filter($filter)->paginate($per_page);
    }
}
