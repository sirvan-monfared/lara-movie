<template>
    <div>
        <div class="filters mobile-filters shadow rounded bg-white mb-4 d-none d-block d-md-none">
            <div class="border-bottom">
                <a class="h6 font-weight-bold text-dark d-block m-0 p-3" data-toggle="collapse"
                   href="#mobile-filters" role="button" aria-expanded="false"
                   aria-controls="mobile-filters">Filter By <i
                    class="fas fa-angle-down float-right mt-1"></i></a>
            </div>
            <div id="mobile-filters" class="filters-body collapse multi-collapse">
                <div id="accordion">
                    <div class="filters-card border-bottom p-3">
                        <div class="filters-card-header" id="headingOffer">
                            <h6 class="mb-0">
                                <a href="#" class="btn-link" data-toggle="collapse"
                                   data-target="#collapseSort" aria-expanded="true"
                                   aria-controls="collapseSort">
                                    Sort by Products <i class="fas fa-angle-down float-right"></i>
                                </a>
                            </h6>
                        </div>
                        <div id="collapseSort" class="collapse" aria-labelledby="headingOffer"
                             data-parent="#accordion">
                            <div class="filters-card-body card-shop-filters">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="osahan111">
                                    <label class="custom-control-label"
                                           for="osahan111">Relevance </label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="osahan112">
                                    <label class="custom-control-label" for="osahan112">Price (Low to
                                        High)
                                    </label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="osahan113">
                                    <label class="custom-control-label" for="osahan113">Price (High to
                                        Low)
                                    </label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="osahan114">
                                    <label class="custom-control-label" for="osahan114">Discount (High
                                        to Low)
                                    </label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="osahan115">
                                    <label class="custom-control-label" for="osahan115">Name (A to Z)
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="filters-card border-bottom p-3">
                        <div class="filters-card-header" id="headingTwo">
                            <h6 class="mb-0">
                                <a href="#" class="btn-link" data-toggle="collapse"
                                   data-target="#collapsetwo" aria-expanded="true"
                                   aria-controls="collapsetwo">
                                    Genre
                                    <i class="fas fa-angle-down float-right"></i>
                                </a>
                            </h6>
                        </div>
                        <div id="collapsetwo" class="collapse" aria-labelledby="headingTwo"
                             data-parent="#accordion">
                            <div class="filters-card-body card-shop-filters">
                                <form class="filters-search mb-3">
                                    <div class="form-group">
                                        <i class="fas fa-search"></i>
                                        <input type="text" class="form-control" placeholder="Start typing to search...">
                                    </div>
                                </form>
                                <div v-for="genre in genres" class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="genre[]" :id="'genre_m_'+genre.slug" :value="genre.id" @change="genreClicked(genre)">
                                    <label class="custom-control-label" :for="'genre_m_'+genre.slug">{{ genre.name }}
                                        <small class="text-black-50">156</small>
                                    </label>
                                </div>
                                <div class="mt-2"><a href="#" class="link">See all</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="filters-card border-bottom p-3">
                        <div class="filters-card-header" id="headingOne">
                            <h6 class="mb-0">
                                <a href="#" class="btn-link" data-toggle="collapse"
                                   data-target="#collapseOne" aria-expanded="true"
                                   aria-controls="collapseOne">
                                    Select Language <i class="fas fa-angle-down float-right"></i>
                                </a>
                            </h6>
                        </div>
                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                             data-parent="#accordion">
                            <div class="filters-card-body card-shop-filters">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="osahan1155">
                                    <label class="custom-control-label" for="osahan1155">Punjabi <small
                                        class="text-black-50">230</small>
                                    </label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="osahan1166">
                                    <label class="custom-control-label" for="osahan1166">English <small
                                        class="text-black-50">95</small>
                                    </label>
                                </div>
                                <div class="mt-2"><a href="#" class="link">See all</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="filters-card border-bottom p-3">
                        <div class="filters-card-header" id="headingOffer">
                            <h6 class="mb-0">
                                <a href="#" class="btn-link" data-toggle="collapse"
                                   data-target="#collapseOffer" aria-expanded="true"
                                   aria-controls="collapseOffer">
                                    Format <i class="fas fa-angle-down float-right"></i>
                                </a>
                            </h6>
                        </div>
                        <div id="collapseOffer" class="collapse" aria-labelledby="headingOffer"
                             data-parent="#accordion">
                            <div class="filters-card-body card-shop-filters">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="osahan1100">
                                    <label class="custom-control-label" for="osahan1100"> 2D </label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input"
                                           id="osahan11111">
                                    <label class="custom-control-label" for="osahan11111"> 3D
                                    </label>
                                </div>
                                <div class="mt-2"><a href="#" class="link">See all</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="filters shadow rounded bg-white mb-3 d-none d-sm-none d-md-block">
            <div class="filters-header border-bottom p-3">
                <h6 class="m-0 text-dark">Filter By</h6>
            </div>
            <div class="filters-body">
                <div id="accordion">
                    <div class="filters-card border-bottom p-3">
                        <div class="filters-card-header" id="headingTwo">
                            <h6 class="mb-0">
                                <a href="#" class="btn-link" data-toggle="collapse"
                                   data-target="#collapsetwo" aria-expanded="true"
                                   aria-controls="collapsetwo">
                                    Genre
                                    <i class="fas fa-angle-down float-right"></i>
                                </a>
                            </h6>
                        </div>
                        <div id="collapsetwo" class="collapse show" aria-labelledby="headingTwo"
                             data-parent="#accordion">
                            <div class="filters-card-body card-shop-filters">
                                <form class="filters-search mb-3">
                                    <div class="form-group">
                                        <i class="fas fa-search"></i>
                                        <input type="text" class="form-control" @input="debounceInput" placeholder="Start typing to search...">
                                    </div>
                                </form>

                                <div v-for="genre in genres" class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="genre[]" :id="'genre_'+genre.slug" :value="genre.id" @change="genreClicked(genre)">
                                    <label class="custom-control-label" :for="'genre_'+genre.slug">{{ genre.name }}
                                        <small class="text-black-50">156</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="filters-card border-bottom p-3">
                        <div class="filters-card-header" id="headingOne">
                            <h6 class="mb-0">
                                <a href="#" class="btn-link" data-toggle="collapse"
                                   data-target="#collapseOne" aria-expanded="true"
                                   aria-controls="collapseOne">
                                    Select Year <i class="fas fa-angle-down float-right"></i>
                                </a>
                            </h6>
                        </div>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                             data-parent="#accordion">
                            <div class="filters-card-body card-shop-filters">
                                <div v-for="year in years" class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="year[]" :id="'year_'+year" :value="year" @change="yearClicked(year)">
                                    <label class="custom-control-label" :for="'year_'+year">{{ year }}
                                        <small class="text-black-50">156</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        emits: ['genreClicked', 'keywordChanged', 'yearClicked'],
        props: ['genres', 'years'],
        data() {
            return {
                debounce: null,
            }
        },
        methods: {
            genreClicked(genre) {
                this.$emit('genreClicked', genre.id)
            },
            yearClicked(year) {
                this.$emit('yearClicked', year)
            },
            debounceInput(e) {
                clearTimeout(this.debounce)
                this.debounce = setTimeout(() => {
                    this.$emit('keywordChanged', e.target.value)
                }, 300)
            },
        }
    }
</script>
