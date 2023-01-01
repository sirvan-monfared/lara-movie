@extends('front.layouts.main')

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mt-4 mb-3">
        <h1 class="h5 mb-0 text-gray-900">Movies</h1>
        <a href="{{ route('movies') }}" class="d-none d-sm-inline-block text-xs"> View All <i class="fas fa-eye fa-sm"></i></a>
    </div>

    <div class="row">
        @foreach($movies as $movie)
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card m-card shadow border-0">
                    <a href="{{ $movie->viewLink() }}">
                        <div class="m-card-cover">
                            <div class="position-absolute bg-white shadow-sm rounded text-center p-2 m-2 love-box">
                                <h6 class="text-gray-900 mb-0 font-weight-bold"><i class="fas fa-star text-warning"></i>
                                    {{ $movie->metas['imdb_rating'] }}</h6>
                            </div>
                            <img src="{{ $movie->cover() }}" class="card-img-top" alt="{{ $movie->title }}">
                        </div>
                        <div class="card-body p-3">
                            <h5 class="card-title text-gray-900 mb-1">{{ $movie->title }}</h5>
                            <p class="card-text">
                                <small class="text-info">{{ $movie->year }}</small>
                                <small class="text-muted"><i class="fas fa-folder fa-sm text-gray-400"></i> {{ optional($movie->genres)->take(2)->pluck('name')->implode(', ') }}</small>
                            </p>
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-sm-flex align-items-center justify-content-between mt-1 mb-3">
        <h1 class="h5 mb-0 text-gray-900">Celebrities</h1>
        <a href="{{ route('people') }}" class="d-none d-sm-inline-block text-xs"> View All <i class="fas fa-eye fa-sm"></i></a>
    </div>

    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="collections-slider">
                @foreach($people as $person)
                <div class="card c-card shadow border-0 overflow-hidden people-slider-item">
                    <a href="{{ $person->viewLink() }}">
                        <img src="{{ $person->cover('thumb') }}" class="img-fluid" alt="{{ $person->name }}">
                        <span class="name"> {{ $person->name }} </span>
                    </a>
                </div>
                @endforeach

            </div>
        </div>
    </div>


    <div class="text-center mt-1 mb-4">
        <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

@endsection

