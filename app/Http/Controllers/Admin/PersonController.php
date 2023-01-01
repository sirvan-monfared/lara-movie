<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Kodesign\Filters\PersonFilter;
use App\Models\Media;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param PersonFilter $filter
     * @return View
     */
    public function index(PersonFilter $filter)
    {
        $people = Person::filter($filter)->orderBy('id', 'DESC')->paginate(20);

        return view('admin.person.index', compact('people'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $person = new Person();

        return view('admin.person.create', compact('person'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $params = $request->validate([
            'name' => 'required',
            'slug' => '',
            'birth' => '',
            'nationality' => '',
            'bio' => '',
            'description' => '',
            'roles' => ''
        ]);

        $params['roles'] = ! empty(request('roles')) ? implode(',', request('roles')) : null;
        $params['slug'] = ! empty(request('slug')) ? request('slug') : 'nm' . uniqid();

        $person = Person::create($params);

        $person->media()->detach();

        $featured = json_decode(request('featured'));
        if (count($featured) > 0) {
            $featured_media = Media::find($featured[0]);

            $person->media()->attach($featured_media, ['collection' => 'featured']);
        }

        $gallery_ids = json_decode(request('gallery'));

        foreach ($gallery_ids as $media_id) {
            $gallery_media = Media::find($media_id);

            $person->media()->attach($gallery_media, ['collection' => 'gallery']);
        }

        return redirect()->route('person.edit', $person)->with('flash', 'ثبت با موفقیت انجام شد');
    }

    /**
     * Display the specified resource.
     *
     * @param Person $person
     * @return Response
     */
    public function show(Person $person)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Person $person
     * @return View
     */
    public function edit(Person $person)
    {
        return view('admin.person.edit', compact('person'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Person $person
     * @return Response
     */
    public function update(Request $request, Person $person)
    {
        $params = $request->validate([
            'name' => '',
            'slug' => '',
            'birth' => '',
            'nationality' => '',
            'bio' => '',
            'description' => '',
            'roles' => ''
        ]);

        $params['roles'] = ! empty(request('roles')) ? implode(',', request('roles')) : null;
        $params['slug'] = ! empty(request('slug')) ? request('slug') : 'nm' . uniqid();

        $person->update($params);

        $person->media()->detach();

        $featured = json_decode(request('featured'));
        if (count($featured) > 0) {
            $featured_media = Media::find($featured[0]);

            $person->media()->attach($featured_media, ['collection' => 'featured']);
        }

        $gallery_ids = json_decode(request('gallery'));

        foreach ($gallery_ids as $media_id) {
            $gallery_media = Media::find($media_id);

            $person->media()->attach($gallery_media, ['collection' => 'gallery']);
        }
        return redirect()->route('person.edit', $person)->with('flash', 'ویرایش با موفقیت انجام شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Person $person
     * @return Response
     */
    public function destroy(Person $person)
    {
        $person->delete();

        return redirect()->back()->with('flash', 'حذف با موفقیت انجام شد');
    }
}
