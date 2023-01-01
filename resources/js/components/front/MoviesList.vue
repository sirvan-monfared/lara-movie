<template>
    <div>
        <div class="d-sm-flex align-items-center  mt-4 mb-3 movies-list-header">
            <h1 class="h5 mb-0 text-gray-900 ">Movies</h1>
            <div class="justify-content-between">
                <a href="#" @click.prevent="resetAllFilters" v-if="filters.title || filters.genre.length || filters.year.length" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">Reset Filters <i class="fas fa-times fa-sm text-white-50"></i></a>
                <a href="#" @click.prevrnt="keywordChanged('')" v-if="filters.title" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">title: {{ filters.title }} <i class="fas fa-times fa-sm text-white-50"></i></a>
                <a href="#" @click.prevent="genreClicked(selected_genre)" v-for="(selected_genre) in filters.genre" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm filtered-item"> {{ genreName(selected_genre) }} <i class="fas fa-times fa-sm text-white-50"></i> </a>
                <a href="#" @click.prevent="yearClicked(selected_year)" v-for="(selected_year) in filters.year" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm filtered-item"> {{ selected_year }} <i class="fas fa-times fa-sm text-white-50"></i> </a>
            </div>
        </div>
        <div class="row" style="position: relative">
            <div id="loading" v-show="isLoading">
                <i class="fa fa-spinner fa-spin"></i>
            </div>

            <div class="col-xl-3 col-lg-4">
                <movies-filter @genreClicked="genreClicked" @keywordChanged="keywordChanged" @yearClicked="yearClicked" :genres="genres" :years="years"></movies-filter>
            </div>
            <div class="col-xl-9 col-lg-8">
                <div class="row movie-list">
                    <movie-list-item v-for="movie in movies" :key="movie.id" :movie="movie"></movie-list-item>
                </div>

                <div class="text-center mt-1 mb-4 col-12" v-show="movies.length">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            <li class="page-item" v-if="pagination.current_page !== 1" @click.prevent="loadPage(1)"><a class="page-link" href="#">First</a></li>
                            <li class="page-item" v-if="pagination.prev_page" @click.prevent="loadPrevPage">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            <li class="page-item" v-if="(pagination.current_page - 2) >= 1"><a class="page-link">...</a></li>
                            <li class="page-item" v-if="pagination.prev_page" @click.prevent="loadPrevPage"><a class="page-link" href="#">{{ pagination.current_page - 1 }}</a></li>
                            <li class="page-item active"><a class="page-link">{{ pagination.current_page }}</a></li>
                            <li class="page-item" v-if="pagination.next_page" @click.prevent="loadNextPage"><a class="page-link" href="#">{{ pagination.current_page + 1 }}</a></li>
                            <li class="page-item" v-if="(pagination.current_page + 2) <= pagination.last_page"><a class="page-link">...</a></li>
                            <li class="page-item" v-if="pagination.next_page" @click.prevent="loadNextPage">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                            <li class="page-item" v-if="pagination.last_page && pagination.current_page !== pagination.last_page" @click.prevent="loadPage(pagination.last_page)"><a class="page-link" href="#">Last</a></li>
                        </ul>

                        <p>Showing {{ pagination.from }} to {{ pagination.to }} of total {{ pagination.total }} Movies</p>
                    </nav>

                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import MovieListItem from "./MovieListItem";
    import MoviesFilter from "./MoviesFilter";

    export default {
        components: {
            MovieListItem,
            MoviesFilter
        },
        data() {
            return {
                movies: [],
                genres: [],
                years: [],
                isLoading: false,
                filters: {
                    title: null,
                    page: 1,
                    genre: [],
                    year: []
                },
                pagination: {
                    current_page: 1,
                    first_page: null,
                    last_page: null,
                    next_page: null,
                    prev_page: null,
                    links: [],
                    from: null,
                    to: null,
                    total: null,
                    per_page: null
                }
            }
        },
        created() {
            this.fetchMovies();
            this.fetchGenres();

            for (let i = new Date().getFullYear(); i >= 1980; i--) {
                this.years.push(i);
            }
        },
        methods: {
            fetchMovies() {
                this.isLoading = true;

                axios.get('/api/movies', {
                    params: this.filters
                })
                .then(({data}) => {
                    this.movies = data.data;
                    this.filters.page = this.pagination.current_page = data.current_page;
                    this.pagination.last_page = data.last_page;
                    this.pagination.next_page = data.next_page_url;
                    this.pagination.prev_page = data.prev_page_url;
                    this.pagination.from = data.from;
                    this.pagination.to = data.to;
                    this.pagination.total = data.total;
                    this.pagination.per_page = data.per_page;

                    this.isLoading = false;
                })
            },
            reload() {
                this.filters.page = 1;
                this.fetchMovies();
            },
            fetchGenres() {
                axios.get('/api/movies/genres')
                    .then(({data}) => this.genres = data)
            },
            genreClicked(genre_id) {
                var index = this.filters.genre.findIndex((id) => id === genre_id);

                if (index === -1) {
                    this.filters.genre.push(genre_id);
                } else {
                    this.filters.genre.splice(index, 1);
                }

                this.reload();
            },
            yearClicked(year) {
                var index = this.filters.year.findIndex((id) => id === year);

                if (index === -1) {
                    this.filters.year.push(year);
                } else {
                    this.filters.year.splice(index, 1);
                }

                this.reload();
            },
            keywordChanged(value) {
                this.filters.title = value;

                this.reload()
            },
            genreName(genre_id) {
                var genre = this.genres.find((genre) => genre.id === genre_id);

                if (genre) {
                    return genre.name;
                }
            },
            loadPage(page_number) {
                this.filters.page = page_number;
                this.fetchMovies();
            },
            loadNextPage() {
                this.loadPage(++this.filters.page);
            },
            loadPrevPage() {
                this.loadPage(--this.filters.page);
            },
            paginationHasPrevDots() {
                return (this.pagination.current_page - 2 > 1)
            },
            paginationHasNextDots() {
                return (this.pagination.current_page + 2 < this.pagination.last_page)
            },
            resetAllFilters() {
                this.filters.title = null;
                this.filters.genre = [];
                this.filters.year = [];

                this.reload();
            }
        }
    }
</script>

<style>
    #loading {
        position: absolute;
        top: 200px;
        right: 0;
        width: 100%;
        height: 100%;
        margin-left: -250px;
        margin-top: -250px;
        background-color: #ececec;
        opacity: 0.5;
        z-index: 9999;
        text-align: center;
    }
    #loading i{
        font-size: 200px;
        margin-top: 150px;
        text-align: center;
    }
</style>
