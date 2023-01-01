<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Kodesign\Filters\MovieFilter;
use App\Models\Genre;
use App\Models\Media;
use App\Models\Movie;
use hmerritt\Imdb;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param MovieFilter $filter
     * @return Response
     */
    public function index(MovieFilter $filter)
    {
        $movies = Movie::filter($filter)->orderBy('id', 'DESC')->paginate(20);

        return view('admin.movie.index', compact('movies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $genres = Genre::orderBy('name', 'ASC')->pluck('name', 'id');

        $movie = new Movie();

        return view('admin.movie.create', compact('movie', 'genres'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response|RedirectResponse
     */
    public function store()
    {
        $parameters = request()->validate([
            'title' => '',
            'slug' => '',
            'language' => '',
            'duration' => '',
            'description' => '',
            'plot' => '',
            'year' => '',
            'base' => '',
            'cover_path' => '',
            'metas->imdb_id' => '',
            'metas->imdb_rating' => ''
        ]);

        $parameters['slug'] = ! empty(request('slug')) ? request('slug') : 'mv' . uniqid();

        if (request('update_with_imdb') === 'on' && ! empty(request('metas->imdb_id')) ) {
            $imdb = (new Imdb())->film(request('metas->imdb_id'));

            if (empty($imdb['id']) || empty($imdb['title'])) {
                return redirect()->back()->with('flash', 'Couldn`t Fetch Data from Imdb Site');
            }

            $parameters['duration'] = array_get($imdb, 'length');
            $parameters['year'] = array_get($imdb, 'year');
            $parameters['plot'] = array_get($imdb, 'plot');
            $parameters['metas->imdb_id'] = array_get($imdb, 'id');
            $parameters['metas->imdb_rating'] = array_get($imdb, 'rating');
        }

        $movie = Movie::create($parameters);

        $actors = $directors = [];
        $role_names = request('role_name');

        if (! empty(request('actors')) && count(request('actors')) > 0) {
            $actors = array_map(function ($item, $actor_index) use ($role_names) {

                if (empty($item)) return false;

                return [
                    'person_id' => $item,
                    'role' => 'actor',
                    'role_name' => $role_names[$actor_index]
                ];
            }, array_filter(request('actors')), array_keys(request('actors')));
        }

        if (! empty(request('directors')) && count(request('directors')) > 0) {
            $directors = array_map(function($item) {
                return [
                    'person_id' => $item,
                    'role' => 'director'
                ];
            }, request('directors'));
        }

        $actors = array_filter($actors);

        $movie->cast()->detach();
        $movie->cast()->attach($actors);
        $movie->cast()->attach($directors);
        $movie->genres()->sync(request('genre'));

        $featured = json_decode(request('featured'));
        if (count($featured) > 0) {
            $featured_media = Media::find($featured[0]);

            $movie->media()->attach($featured_media, ['collection' => 'featured']);
        }

        $gallery_ids = json_decode(request('gallery'));

        foreach ($gallery_ids as $media_id) {
            $gallery_media = Media::find($media_id);

            $movie->media()->attach($gallery_media, ['collection' => 'gallery']);
        }

        return redirect()->route('movie.edit', $movie)->with('flash', 'ثبت با موفقیت انجام شد');
    }

    /**
     * Display the specified resource.
     *
     * @param Movie $movie
     * @return Response
     */
    public function show(Movie $movie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Movie $movie
     * @return View
     */
    public function edit(Movie $movie)
    {
        $genres = Genre::orderBy('name', 'ASC')->pluck('name', 'id');

        $movie->load(['directors', 'actors']);

        return view('admin.movie.edit', compact('movie', 'genres'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Movie $movie
     * @return RedirectResponse
     */
    public function update(Request $request, Movie $movie)
    {
        $parameters = $request->validate([
           'title' => '',
           'slug' => '',
           'language' => '',
           'duration' => '',
           'description' => '',
           'plot' => '',
           'year' => '',
           'base' => '',
           'cover_path' => '',
           'metas->imdb_id' => '',
           'metas->imdb_rating' => ''
        ]);

        $parameters['slug'] = ! empty(request('slug')) ? request('slug') : 'mv' . uniqid();


        if ( request('update_with_imdb') === 'on' && ! empty(request('metas->imdb_id')) ) {
            $imdb = (new Imdb())->film(request('metas->imdb_id'));

            if (! empty($imdb['id']) || ! empty($imdb['title'])) {
                return redirect()->back()->with('flash', 'Couldn`t Fetch Data from Imdb Site');
            }

            $parameters['duration'] = array_get($imdb, 'length');
            $parameters['year'] = array_get($imdb, 'year');
            $parameters['plot'] = array_get($imdb, 'plot');
            $parameters['metas->imdb_id'] = array_get($imdb, 'id');
            $parameters['metas->imdb_rating'] = array_get($imdb, 'rating');

        }

        $movie->update($parameters);

        $actors = $directors = [];
        $role_names = request('role_name');

        if (! empty(request('actors')) && count(request('actors')) > 0) {
            $actors = array_map(function ($item, $actor_index) use ($role_names) {

                if (empty($item)) return false;

                return [
                    'person_id' => $item,
                    'role' => 'actor',
                    'role_name' => $role_names[$actor_index]
                ];
            }, array_filter(request('actors')), array_keys(request('actors')));
        }

        if (! empty(request('directors')) && count(request('directors')) > 0) {
            $directors = array_map(function ($item) {
                return [
                    'person_id' => $item,
                    'role' => 'director'
                ];
            }, request('directors'));
        }
        $actors = array_filter($actors);


        $movie->cast()->detach();
        $movie->cast()->attach($actors);
        $movie->cast()->attach($directors);
        $movie->genres()->sync(request('genre'));

        $movie->media()->detach();

        $featured = json_decode(request('featured'));
        if (count($featured) > 0) {
            $featured_media = Media::find($featured[0]);

            $movie->media()->attach($featured_media, ['collection' => 'featured']);
        }

        $poster = json_decode(request('poster'));
        if (count($poster) > 0) {
            $poster_media = Media::find($poster[0]);

            $movie->media()->attach($poster_media, ['collection' => 'poster']);
        }

        $gallery_ids = json_decode(request('gallery'));

        foreach ($gallery_ids as $media_id) {
            $gallery_media = Media::find($media_id);

            $movie->media()->attach($gallery_media, ['collection' => 'gallery']);
        }

        return redirect()->route('movie.edit', $movie)->with('flash', 'ویرایش با موفقیت انجام شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Movie $movie
     * @return Response
     */
    public function destroy(Movie $movie)
    {
        $movie->delete();

        return redirect()->back()->with('flash', 'حذف با موفقیت انجام شد');
    }
}
