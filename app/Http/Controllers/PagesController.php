<?php

namespace App\Http\Controllers;

use App\Kodesign\Filters\MovieFilter;
use App\Kodesign\Filters\PersonFilter;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\Person;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PagesController extends Controller
{
    /**
     * Returns main page view
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('front.index', [
            'movies' => Movie::with('featured')->latest()->take(8)->get(),
            'people' => Person::latest('id')->take(8)->get()
        ]);
    }


    /**
     * Returns list page view
     *
     * @return Application|Factory|View
     */
    public function movies()
    {
        return view('front.movies.list');
    }

    /**
     * Returns single movie view
     *
     * @param Movie $movie
     * @return Application|Factory|View
     */
    public function movie(Movie $movie)
    {
        $movie->increment('views');

        return view('front.movies.single', compact('movie'));
    }

    /**
     * Returns people list page view
     *
     * @return Application|Factory|View
     */
    public function people() {
        return view('front.people.list');
    }

    /**
     * Returns single person view
     *
     * @param Person $person
     * @return Application|Factory|View
     */
    public function person(Person $person){
        return view('front.people.single', compact('person'));
    }

    /**
     * Returns genre page view
     *
     * @param Genre $genre
     * @return Application|Factory|View
     */
    public function genre(Genre $genre){
        $movies = $genre->movies()->paginate(20);

        return view('front.genre.single', compact('genre', 'movies'));
    }
}
