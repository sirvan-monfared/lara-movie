@extends('front.layouts.main',[
    'title' => "{$person->name} | فیلم های {$person->name}",
    'show_search' => false
])

@section('styles')
    <link type="text/css" rel="stylesheet" href="/bower_components/lightgallery/dist/css/lightgallery.css">
@endsection

@section('content')

    <div class="row">
        <div class="col-xl-3 col-lg-3">
            <div class="bg-white p-3 widget shadow rounded mb-4">
                <img src="{{ $person->cover() }}" class="img-fluid rounded" alt="...">
                <h1 class="h6 mb-3 mt-3 font-weight-bold text-gray-900">Personal Info</h1>
                <p class="mb-2"><i class="fas fa-user-circle fa-fw"></i> Known For - Acting</p>
                <p class="mb-2"><i class="fas fa-venus-mars fa-fw"></i> Gender - Male</p>
                <p class="mb-2"><i class="fas fa-list-alt fa-fw"></i> Known Credits - 227</p>
                <p class="mb-2"><i class="fas fa-calendar-alt fa-fw"></i> Date of Birth - {{ $person->birth }}</p>
                <p class="mb-2"><i class="fas fa-map-marker-alt fa-fw"></i> {{ $person->nationality }}</p>
            </div>
        </div>
        <div class="col-xl-9 col-lg-9">
            <div class="bg-white info-header shadow rounded mb-4">
                <div class="row d-flex align-items-center justify-content-between p-3 border-bottom">
                    <div class="col-lg-7 m-b-4">
                        <h3 class="text-gray-900 mb-0 mt-0 font-weight-bold">{{ $person->name }}</h3>
                        <p class="mb-0 text-gray-800"><small class="text-muted"><i
                                    class="fas fa-user-circle fa-fw fa-sm mr-1"></i>{{ implode(',', $person->roles) }}</small></p>
                    </div>
                    <div class="col-lg-5 text-right">
                        <a href="#" class="btn btn-primary btn-circle">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="btn btn-danger btn-circle">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" class="btn btn-warning btn-circle">
                            <i class="fab fa-snapchat-ghost"></i>
                        </a>
                        <a href="#" class="btn btn-info btn-circle">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                </div>
                <div class="p-3 mb-4">
                    <h1 class="h6 mb-3 mt-0 font-weight-bold text-gray-900">Biography</h1>
                    <div>
                        <p class="mb-0 text-gray-600">An American and Canadian actor, producer and
                            semi-retired professional wrestler, signed with WWE. Johnson is half-Black and
                            half-Samoan. His father, Rocky Johnson, is a Black Canadian, from Nova Scotia,
                            and part of the first Black tag team champions in WWE history back when it was
                            known as the WWF along with Tony Atlas. His mother is Samoan and the daughter of
                            Peter Maivia, who was also a pro wrestler. Maivia's wife, Lia Maivia, was one of
                            wrestling's few female promoters, taking over Polynesian Pacific Pro Wrestling
                            after her husband's death in 1982, until 1988. Through his mother, he is ...
                        </p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-3 widget shadow rounded mb-4">
                <h1 class="h6 mb-3 mt-0 font-weight-bold text-gray-900">Movies</h1>
                <div class="row">
                    @foreach($person->movies as $movie)
                        <div class="col-xl-3 col-md-6">
                            <div class="card m-card shadow border-0">
                                <a href="{{ $movie->viewLink() }}">
                                    <div class="m-card-cover">
                                        <div class="position-absolute bg-white shadow-sm rounded text-center p-2 m-2 love-box">
                                            <h6 class="text-gray-900 mb-0 font-weight-bold"><i
                                                    class="fas fa-star text-warning"></i> {{ $movie->metas['imdb_rating'] }}</h6>
                                        </div>
                                        <img src="{{ $movie->cover() }}" class="card-img-top" alt="...">
                                    </div>
                                    <div class="card-body p-3">
                                        <h5 class="card-title text-gray-900 mb-1">{{ $movie->title }}</h5>
                                        <p class="card-text">
                                            <small class="text-muted">{{ optional($movie->genres)->first()->name }}</small>
                                            <small class="text-danger"><i class="fas fa-calendar-alt fa-sm text-gray-400"></i>
                                                {{ $movie->year }}</small>
                                        </p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white p-3 widget shadow rounded mb-4">
                <h1 class="h6 mb-3 mt-0 font-weight-bold text-gray-900">Media</h1>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="movies-part">
                            @if(count($person->videos) > 0)
                                <div class="divided-title">
                                    <span class="title">Videos</span>
                                </div>
                            @endif

                            @foreach($person->videos as $media)
                                <div style="display:none;" id="video{{ $media->id }}">
                                    <video class="lg-video-object lg-html5" controls preload="none">
                                        <source src="{{ $media->url() }}">
                                        Your browser does not support HTML5 video.
                                    </video>
                                </div>
                            @endforeach

                            <ul id="video-gallery" class="row">
                                @foreach($person->videos as $media)
                                    <li class="col-sm-3" data-poster="{{ optional($media->poster)->url('poster') }}" data-sub-html="{{ $media->title }}" data-html="#video{{ $media->id }}" >
                                        <img src="{{ optional($media->poster)->url('thumb') }}">
                                        <i class="fa fa-play"></i>
                                    </li>
                                @endforeach
                            </ul>

                        </div>

                        <div class="images-part">
                            <div class="divided-title">
                                <span class="title">Images</span> <span class="divider"></span>
                            </div>
                            <ul id="images-gallery" class="row">
                                @foreach($person->images as $media)
                                    <li class="col-sm-2" data-src="{{ $media->url() }}" data-sub-html="{{ $media->title }}">
                                        <a href="">
                                            <img class="img-responsive" src="{{ $media->url('thumb') }}">
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="/bower_components/lightgallery/dist/js/lightgallery-all.js"></script>
@endsection

@section('javascript')
    <script>
        $('#video-gallery').lightGallery({
            autoplayFirstVideo: false
        });
        $('#images-gallery').lightGallery({
            thumbnail:true
        });
    </script>
@endsection
