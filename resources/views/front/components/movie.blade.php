<div class="movie-item-style-2 movie-item-style-1">
    <img src="{{ $movie->featured_image_thumb }}" alt="">
    <div class="hvr-inner">
        <a  href="{{ $movie->viewLink() }}"> مشاهده <i class="ion-android-arrow-dropleft"></i> </a>
    </div>
    <div class="mv-item-infor">
        <h6><a href="#">{{ $movie->title }}</a></h6>
        <p class="rate">{{ $movie->year }}</p>
    </div>
</div>
