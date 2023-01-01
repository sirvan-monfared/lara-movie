<template>
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card m-card shadow border-0">
            <a :href="movie.view_link">
                <div class="m-card-cover">
                    <div class="position-absolute bg-white shadow-sm rounded text-center p-2 m-2 love-box">
                        <h6 class="text-gray-900 mb-0 font-weight-bold"><i class="fas fa-star text-warning"></i>
                            {{ movie.metas.imdb_rating }}</h6>
                    </div>
                    <img :src="movie.featured_image.cover_path" class="card-img-top" :alt="movie.title">
                </div>
                <div class="card-body p-3">
                    <h5 class="card-title text-gray-900 mb-1">{{ movie.title }}</h5>
                    <p class="card-text">
                        <small class="text-info">{{ movie.year }}</small>
                        <small class="text-muted"><i class="fas fa-folder fa-sm text-gray-400"></i> {{ movie.genres_list }}</small>
                    </p>
                </div>
            </a>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['movie']
    }
</script>
