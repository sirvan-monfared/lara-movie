@extends('front.layouts.main')

@section('styles')
    <link type="text/css" rel="stylesheet" href="/bower_components/lightgallery/dist/css/lightgallery.css">
@endsection

@section('content')

    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="cover-pic">
                <div class="position-absolute bg-white shadow-sm rounded text-center p-2 m-4 love-box">
                    <h6 class="text-gray-900 mb-0 font-weight-bold">
                        <i class="fas fa-star text-warning"></i>
                        {{ $movie->metas['imdb_rating'] }} / 10
                    </h6>
                    <small class="text-muted">IMDB</small>
                </div>
                <img src="{{ $movie->posterImage() }}" class="img-fluid" alt="{{ $movie->title }}">
            </div>
        </div>
        <div class="col-xl-3 col-lg-3">
            <div class="bg-white p-3 widget shadow rounded mb-4">
                <img src="{{ $movie->cover('cover') }}" class="img-fluid rounded" alt="...">
                <h1 class="h6 mb-0 mt-3 font-weight-bold text-gray-900">Year</h1>
                <p>{{ $movie->year }}</p>
                <h1 class="h6 mb-0 mt-3 font-weight-bold text-gray-900">Duration</h1>
                <p>{{ $movie->duration }}</p>
                <h1 class="h6 mb-0 mt-3 font-weight-bold text-gray-900">IMDB Rating</h1>
                <p>{{ $movie->metas['imdb_rating'] }} / 10</p>
                <h1 class="h6 mb-0 mt-3 font-weight-bold text-gray-900">Plot</h1>
                <p class="mb-0">{{ $movie->plot }}</p>
            </div>
        </div>
        <div class="col-xl-9 col-lg-9">
            <div class="bg-white info-header shadow rounded mb-4">
                <div class="row d-flex align-items-center justify-content-between p-3 border-bottom">
                    <div class="col-lg-7 m-b-4">
                        <h3 class="text-gray-900 mb-0 mt-0 font-weight-bold">{{ $movie->title }} <small>{{ $movie->year }}</small>
                        </h3>
                        <p class="mb-0 text-gray-800">
                            <small class="text-muted"><i class="fas fa-film fa-fw fa-sm mr-1"></i>
                                @foreach($movie->genres as $genre)
                                    <a href="{{ $genre->viewLink() }}">{{ $genre->name }}</a>
                                    @if (! $loop->last) / @endif
                                @endforeach
                            </small>
                        </p>
                    </div>
                    <div class="col-lg-5 text-right">
                        <a href="#" class="d-sm-inline-block btn btn-primary shadow-sm"><i
                                class="fas fa-share-alt"></i></a>
                        <a href="#" class="d-sm-inline-block btn btn-danger shadow-sm"> Add to Watchlist <i
                                class="fas fa-plus fa-sm  ml-1"></i></a>
                    </div>
                </div>
                <div class="row d-flex align-items-center justify-content-between py-3 px-4">
                    <div class="col-lg-6 m-b-4">
                        <p class="mb-0 text-gray-900"><i class="fas fa-clock fa-sm fa-fw mr-1"></i>
                            Duration: <span class="text-white rounded px-2 py-1 bg-info">{{ $movie->duration }}</span>
                        </p>
                    </div>
                    <div class="col-lg-6 text-right">
                        <a href="#" class="btn btn-sm btn-primary btn-circle">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-danger btn-circle">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-warning btn-circle">
                            <i class="fab fa-snapchat-ghost"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-info btn-circle">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="bg-white p-3 widget shadow rounded mb-4">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#media" role="tab"
                           aria-controls="media" aria-selected="true">Media</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                           aria-controls="profile" aria-selected="false">Cast
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="summary-tab" data-toggle="tab" href="#summary" role="tab"
                           aria-controls="summary" aria-selected="false">Summary
                        </a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">

                    <div class="tab-pane fade show active" id="media" role="tabpanel" aria-labelledby="media-tab">

                        <div class="movies-part">
                            <div class="divided-title">
                                <span class="title">Videos</span>
                            </div>

                            @foreach($movie->videos as $media)
                                <div style="display:none;" id="video{{ $media->id }}">
                                    <video class="lg-video-object lg-html5" controls preload="none">
                                        <source src="{{ $media->url() }}">
                                        Your browser does not support HTML5 video.
                                    </video>
                                </div>
                            @endforeach

                            <ul id="video-gallery" class="row">
                                @foreach($movie->videos as $media)
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
                                @foreach($movie->images as $media)
                                    <li class="col-sm-2" data-src="{{ $media->url() }}" data-sub-html="{{ $media->title }}">
                                        <a href="">
                                            <img class="img-responsive" src="{{ $media->url('thumb') }}">
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="row">
                            <div class="col-xl-4 col-lg-4">
                                <h5 class="h6 mt-0 mb-3 font-weight-bold text-gray-900">CAST</h5>
                                @foreach($movie->actors as $actor)
                                    <div class="artist-list mb-3">
                                        <a class="d-flex align-items-center" href="{{ $actor->viewLink() }}">
                                            <div class="dropdown-list-image mr-3">
                                                <img class="rounded-circle" src="{{ $actor->cover('mini') }}" alt="{{ $actor->name }}">
                                                <div class="status-indicator bg-success"></div>
                                            </div>
                                            <div class="font-weight-bold">
                                                <div class="text-truncate">{{ $actor->name }}</div>
                                                <div class="small text-gray-500">{{ $actor->pivot->role_name }}</div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="summary" role="tabpanel" aria-labelledby="summary-tab">
                        <div class="card-body p-0 reviews-card">
                            <div class="media mb-4">
                                <img class="d-flex mr-3 rounded-circle" src="/front/img/s1.png" alt="">
                                <div class="media-body">
                                    <div class="mt-0 mb-1">
                                        <span class="h6 mr-2 font-weight-bold text-gray-900">Stave Martin</span>
                                        <span><i class="fa fa-calendar"></i> Feb 12, 2020</span>
                                        <div class="stars-rating float-right"><i
                                                class="fa fa-star active"></i>
                                            <i class="fa fa-star active"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i> <span
                                                class="rounded bg-warning text-dark pl-1 pr-1">5/3</span>
                                        </div>
                                    </div>
                                    <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus
                                        scelerisque ante sollicitudin. Cras purus odio, vestibulum in
                                        vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi
                                        vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
                                </div>
                            </div>
                            <div class="media">
                                <img class="d-flex mr-3 rounded-circle" src="/front/img/s2.png" alt="">
                                <div class="media-body">
                                    <div class="mt-0 mb-1">
                                        <span class="h6 mr-2 font-weight-bold text-gray-900">Mark Smith</span>
                                        <span><i class="fa fa-calendar"></i> Feb 12, 2020</span>
                                        <div class="stars-rating float-right"><i
                                                class="fa fa-star active"></i>
                                            <i class="fa fa-star active"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i> <span
                                                class="rounded bg-warning text-dark pl-1 pr-1">5/3</span>
                                        </div>
                                    </div>
                                    <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus
                                        scelerisque ante sollicitudin. Cras purus odio, vestibulum in
                                        vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi
                                        vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
                                    <div class="media mt-4">
                                        <img class="d-flex mr-3 rounded-circle" src="/front/img/s3.png" alt="">
                                        <div class="media-body">
                                            <div class="mt-0 mb-1">
                                                <span class="h6 mr-2 font-weight-bold text-gray-900">Ryan Printz</span>
                                                <span><i class="fa fa-calendar"></i> Feb 12, 2020</span>
                                                <div class="stars-rating float-right"><i
                                                        class="fa fa-star active"></i>
                                                    <i class="fa fa-star active"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i> <span
                                                        class="rounded bg-warning text-dark pl-1 pr-1">5/3</span>
                                                </div>
                                            </div>
                                            <p>
                                                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus.
                                                scelerisque ante sollicitudin. Cras purus odio, vestibulum
                                                in vulputate at, tempus viverra turpis. Fusce condimentum
                                                nunc ac nisi vulputate fringilla. Donec lacinia congue felis
                                                in faucibus
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="media mt-4">
                                <img class="d-flex mr-3 rounded-circle" src="/front/img/s4.png" alt="">
                                <div class="media-body">
                                    <div class="mt-0 mb-1">
                                        <span class="h6 mr-2 font-weight-bold text-gray-900">Stave Mark</span>
                                        <span><i class="fa fa-calendar"></i> Feb 12, 2020</span>
                                        <div class="stars-rating float-right"><i
                                                class="fa fa-star active"></i>
                                            <i class="fa fa-star active"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i> <span
                                                class="rounded bg-warning text-dark pl-1 pr-1">5/3</span>
                                        </div>
                                    </div>
                                    <p class="mb-0">Cras sit amet nibh libero, in gravida nulla. Nulla vel
                                        metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in
                                        vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi
                                        vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 bg-light rounded mt-4">
                            <h5 class="card-title mb-4">Leave a Review</h5>
                            <form name="sentMessage">
                                <div class="row">
                                    <div class="control-group form-group col-lg-4 col-md-4">
                                        <div class="controls">
                                            <label>Your Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" required="">
                                        </div>
                                    </div>
                                    <div class="control-group form-group col-lg-4 col-md-4">
                                        <div class="controls">
                                            <label>Your Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" required="">
                                        </div>
                                    </div>
                                    <div class="control-group form-group col-lg-4 col-md-4">
                                        <div class="controls">
                                            <label>Rating <span class="text-danger">*</span></label>
                                            <select class="form-control custom-select">
                                                <option>1 Star</option>
                                                <option>2 Star</option>
                                                <option>3 Star</option>
                                                <option>4 Star</option>
                                                <option>5 Star</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="control-group form-group">
                                    <div class="controls">
                                        <label>Review <span class="text-danger">*</span></label>
                                        <textarea rows="3" cols="100" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Send Message</button>
                                </div>
                            </form>
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
