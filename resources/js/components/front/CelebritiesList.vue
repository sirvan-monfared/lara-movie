<template>
    <div>
        <div class="justify-content-between">
            <a href="#" @click.prevent="resetAllFilters" v-if="filters.start_character || filters.name" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">Reset Filters <i class="fas fa-times fa-sm text-white-50"></i></a>

            <a href="#" v-if="filters.name" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Celebrity Name: {{ filters.name }} </a>
            <a href="#" v-if="filters.start_character" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Celebrity Name Start With: {{ filters.start_character }}</a>
        </div>
        <div class="d-sm-flex align-items-center  mt-4 mb-3 movies-list-header">
            <h1 class="h5 mb-0 text-gray-900 ">Celebrities</h1>
            <div class="justify-content-between flex">
                <div class="filters-search">
                    <div class="form-group">
                        <i class="fas fa-search"></i>
                        <input type="text" class="form-control" @input="debounceInput" v-model="filters.name" placeholder="Find Celebrities ... ">
                    </div>
                </div>
                <div class="filters-characters">
                    <ul class="justify-content-between flex">
                        <li v-for="character in characters" :key="character" @click="characterSelected(character)" :class="{ active: (character === filters.start_character) }">{{ character }}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row" style="position: relative">
            <div id="loading" v-show="isLoading">
                <i class="fa fa-spinner fa-spin"></i>
            </div>

            <div class="col-xl-12">
                <div class="row movie-list">
                    <div v-for="person in celebrities" :key="person.id" class="col-xl-3 col-md-6 mb-4">
                        <div class="card m-card shadow border-0">
                            <a :href="person.view_link">
                                <div class="m-card-cover">
                                    <img :src="person.featured_image.cover_path" class="card-img-top" :alt="person.name">
                                </div>
                                <div class="card-body p-3">
                                    <h5 class="card-title text-gray-900 mb-1">{{ person.name }}</h5>
                                    <p class="card-text">
                                        <small class="text-muted">{{ person.roles_list }}</small>
                                        <small class="text-gray-500"><i class="fas fa-calendar-alt fa-sm text-gray-400"></i> {{ person.birth }}</small>
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-1 mb-4 col-12" v-show="celebrities.length">
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

                        <p>Showing {{ pagination.from }} to {{ pagination.to }} of total {{ pagination.total }} Celebrities</p>
                    </nav>

                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                characters: ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'],
                celebrities: [],
                debounce: null,
                isLoading: false,
                filters: {
                    name: null,
                    start_character: null,
                    page: 1
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
            this.fetchCelebrities();
        },
        methods: {
            fetchCelebrities() {
                this.isLoading = true;

                axios.get('/api/celebrities', {
                    params: this.filters
                }).then(({data}) => {
                    this.celebrities = data.data;
                    this.filters.page = this.pagination.current_page = data.current_page;
                    this.pagination.last_page = data.last_page;
                    this.pagination.next_page = data.next_page_url;
                    this.pagination.prev_page = data.prev_page_url;
                    this.pagination.from = data.from;
                    this.pagination.to = data.to;
                    this.pagination.total = data.total;
                    this.pagination.per_page = data.per_page;

                    this.isLoading = false;
                });
            },
            debounceInput(e) {
                clearTimeout(this.debounce)
                this.debounce = setTimeout(() => {
                    this.filters.start_character = null;
                    this.reload();
                }, 300)
            },
            characterSelected(character) {
                this.filters.start_character = character;
                this.filters.name = null;
                this.reload();
            },
            reload() {
                this.filters.page = 1;
                this.fetchCelebrities();
            },
            loadPage(page_number) {
                this.filters.page = page_number;
                this.fetchCelebrities();
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
                this.filters.name = null;
                this.filters.start_character = null;

                this.reload();
            }
        }
    }
</script>

<style>
    .flex {
        display: flex;
    }
    .filters-search .form-group {
        margin-bottom: 0;
    }
    .filters-characters ul {
        list-style: none;
        margin-bottom: 0;
        margin-top: 8px;
    }
    .filters-characters ul li {
        margin-right: 5px;
        cursor: pointer;
        padding: 0 5px;
    }
    .filters-characters ul li:hover {
        color: rgb(10 154 239 / 97%);
    }
    .filters-characters ul li.active{
        color: white;
        background: rgb(10 154 239 / 97%);
        padding: 0 5px;
        border-radius: 50%;
    }
</style>
