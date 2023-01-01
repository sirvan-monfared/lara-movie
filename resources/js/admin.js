require('./bootstrap');

//require('alpinejs');

import Vue from 'vue';
import VModal from 'vue-js-modal';
import Tabs from 'vue-tabs-component';

Vue.component('image-gallery', require('./components/ImageGallery.vue').default);
Vue.component('media-manager', require('./components/MediaManager.vue').default);

Vue.use(VModal, {
    dynamicDefaults: {
        draggable: true,
        resizable: true,
        height: 'auto',
    }
});

Vue.use(Tabs);

const app = new Vue({
    el: '#app'
});
