require('./bootstrap');

import Vue from 'vue';

import MoviesList from "./components/front/MoviesList";
import CelebritiesList from "./components/front/CelebritiesList";

Vue.component('movies-list', MoviesList);
Vue.component('celebrities-list', CelebritiesList)

const app = new Vue({
    el: '#app'
});
