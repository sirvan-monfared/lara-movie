@extends('front.layouts.main', [
    'show_search' => false,
])

@section('content')

    <div class="hero common-hero no-hero">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
{{--                    <div class="hero-ct">--}}
{{--                        <h1>Movie Listing - Grid Fullwidth</h1>--}}
{{--                        <ul class="breadcumb">--}}
{{--                            <li class="active"><a href="#">Home</a></li>--}}
{{--                            <li> <span class="ion-ios-arrow-right"></span> movie listing</li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>


<div class="page-single">
    <div class="container">
        <div class="row ipad-width">
            <div class="col-md-8 col-sm-12 col-xs-12">

                @include('front.components.pagination-header')

                <div class="flex-wrap-movielist">
                    @foreach($movies as $movie)
                        @include('front.components.movie')
                    @endforeach
                </div>

                @include('front.components.pagination-footer')

            </div>
            <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="sidebar">
                    <div class="searh-form">
                        <h4 class="sb-title">جستجو در فیلم ها</h4>
                        <form class="form-style-1" action="{{ route('list') }}">
                            <div class="row">
                                <div class="col-md-12 form-it">
                                    <label for="title">نام فیلم</label>
                                    <input name="title" id="title" type="text" placeholder="نام فیلم" value="{{ request('title') }}">
                                </div>
                                <div class="col-md-12 form-it">
                                    <label for="genre">ژانر</label>
                                    <div class="group-ip">
                                        <select
                                            name="genre[]" id="genre" multiple="" class="ui fluid dropdown">
                                            <option value="">همه ژانرها</option>
                                            @foreach($genres as $genre_id => $genre_name)
                                                <option value="{{ $genre_id }}" {{ activeState($genre_id, request('genre')) }}>{{ $genre_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 form-it">
                                    <label>سال ساخت</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select name="year_from" id="year_from">
                                                <option value="range">از</option>
                                                <option value="number">10</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <select name="year_to" id="year_to">
                                                <option value="range">تا</option>
                                                <option value="number">20</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 ">
                                    <input class="submit" type="submit" value="جستجو">
                                </div>
                            </div>
                        </form>
                    </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

