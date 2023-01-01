<template>
    <div class="image-picker">
        <div class="selected-items-wrapper" v-show="selected_media.length > 0">
            <div class="selected-item" v-for="media in selected_media">
                <img :src="media.thumb_path" alt="thumb">
                <i class="fa fa-times" @click.prevent="removeSelected(media)"></i>
                <span class="item-name" v-show="media.type !== 'image'">{{ media.base_name }}</span>
            </div>
        </div>
        <div class="placeholder" v-show="! selected_media.length" @click.prevent="openGallery">
            <i class="fa fa-image"></i>
        </div>
        <div class="open-gallery">
            <a href="javascript:" @click.prevent="openGallery">انتخاب رسانه </a>
        </div>
        <input type="hidden" :name="namespace" v-model="input_value">
    </div>
</template>
<script>
    import GalleryModal from "./GalleryModal";
    import EventBus from "../event-bus";

    export default {
        components : {
            GalleryModal
        },
        props: {
            'multiple': {type: Boolean, default: false},
            'no_upload': {type: Boolean, default: false},
            'csrf':     {type: String},
            'media':    {type: String},
            'namespace': {type: String},
            'type': {type: String}
        },
        data() {
            return {
                selected_media: [],
                can_choose_multiple: false,
                input_value: '',
                media_type: null
            }
        },
        watch: {
            selected_media: function() {
                this.input_value = JSON.stringify(this.selected_media.map(item => item.id));
            }
        },
        created () {
            if (this.$props.media) {
                this.selected_media = JSON.parse(this.$props.media);
            }

            if (this.$props.type) {
                this.media_type = this.$props.type;
            }

            if (this.multiple) {
                this.can_choose_multiple = true;
            }

            const component = this;
            EventBus.$on('mediaHasSelected__' + this.namespace, function(media) {
                component.mediaHasSelected(media);
            });
        },
        methods: {
            openGallery() {
                this.$modal.show(
                    GalleryModal,
                    {
                        csrf: this.csrf,
                        multiple: this.can_choose_multiple,
                        namespace: this.namespace,
                        selected: JSON.parse(JSON.stringify(this.selected_media)),
                        media_type: this.media_type,
                        no_upload: this.no_upload
                    },
                    {
                        name: this.namespace,
                        draggable: false,
                        scrollable: true,
                        width: '80%'
                    }
                )
            },
            mediaHasSelected(media) {
                this.selected_media = Array.isArray(media) ? media : [media];
                this.$modal.hide(this.namespace);
            },
            removeSelected(media) {
                let index = this.selected_media.findIndex((item) => item.id === media.id);
                this.selected_media.splice(index, 1);
            }
        }
    }
</script>

<style>
    .open-gallery {
        text-align: center;
    }
    .placeholder {
        height: 100px;
        width: 200px;
        border: 2px dotted#acabab;
        margin: 0 auto 10px;
        position: relative;
        border-radius: 5px;
        cursor: pointer;
    }
    .placeholder i{
        position: absolute;
        right: 85px;
        top: 35px;
        font-size: 25px;
        color: #acabab;
    }
    .selected-items-wrapper {
        text-align: center;
        margin-bottom: 20px;
    }
    .selected-items-wrapper .selected-item {
        display: inline-block;
        position: relative;
        margin-left: 5px;
        margin-top: 5px;
    }
    .selected-items-wrapper .selected-item img{
        background-color: white;
        padding: 5px;
        box-shadow: 0 1px 4px 3px rgb(0 0 0 / 8%);
        max-width: 150px;
    }
    .selected-items-wrapper .selected-item i {
        position: absolute;
        right: 0;
        font-size: 18px;
        background-color: #de3f5a;
        color: white;
        padding: 2px 5px;
        cursor: pointer;
        outline: 1px auto;
    }
    .selected-items-wrapper .selected-item i:hover {
        opacity: 0.6;
    }
</style>
