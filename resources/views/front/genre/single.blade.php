@extends('front.layouts.main', [
    'title' => "لیست فیلم های {$genre->name}"
])

@section('content')

    <div class="hero common-hero">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="hero-ct">
                        <h1>لیست فیلم های {{ $genre->name }}</h1>
                        <ul class="breadcumb">
                            <li class="active"><a href="{{ url('/') }}">خانه</a></li>
                            <li> <span class="ion-ios-arrow-left"></span>ژانرها</li>
                            <li class="active"> <span class="ion-ios-arrow-left"></span> <a href="{{ $genre->viewLink() }}">{{ $genre->name }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="page-single">
        <div class="container">
            <div class="row ipad-width">
                <div class="col-sm-12 col-xs-12">

                    @include('front.components.pagination-header', ['filterClass' => 'big'])

                    <div class="flex-wrap-movielist">
                        @foreach($movies as $movie)
                            @include('front.components.movie')
                        @endforeach
                    </div>

                    @include('front.components.pagination-footer')
                </div>
            </div>
        </div>
    </div>

@endsection
