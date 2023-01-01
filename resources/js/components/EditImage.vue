<template>
    <div class="media-edit-modal" ref="container">
        <div class="modal-header level">
            <div class="modal-title">جزئیات رسانه</div>
            <div class="modal-actions">
                <div class="close-modal modal-action" @click.prevent="saveImage">
                    <i class="fa" :class="isLoading ? 'fa-spinner fa-spin' : 'fa-check' "></i>
                </div>
                <div class="close-modal modal-action" @click.prevent="closeModal">
                    <i class="fa fa-times"></i>
                </div>
            </div>
        </div>
        <div class="modal-body p-0">
            <div class="row">
                <div class="current-crop-size">{{ currentCropSize }}</div>

                <div class="col-sm-8 col-xs-12 m-t-20" :style="{ maxHeight: image_height }">
                    <div class="loading" v-show="isLoading">
                        <i class="fa fa-spinner fa-spin"></i>
                    </div>
                    <cropper
                            ref="cropper"
                            class="cropper"
                            :src="media.original_path"
                            image-class="cropper__image"
                            :stencil-props="{
                                movable: true,
                                resizable: true,
                            }"
                            image-restriction="stencil"
                            :resizeImage="true"
                            :debounce="1"
                            @change="change"
                        />
                </div>
                <div class="col-sm-4 col-xs-12">
                    <div class="media-form">

                        <div class="form">
                            <h5>اعمال تغییر بر روی :</h5>
                            <label v-for="size in sizes" class="size-option">
                                <input type="radio" v-model="selected_size.slug" name="size" :value="size.slug" @click="sizeClicked(size)"> {{ size.name }} ({{ size.width }}x{{ size.height }} پیکسل)
                            </label>

                            <div class="divider"></div>

                            <div class="old-image-preview">
                                <h5>تصویر فعلی</h5>
                                <img :src="old_image_preview" alt="preview">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { Cropper } from 'vue-advanced-cropper';
    import 'vue-advanced-cropper/dist/style.css';
    import EventBus from "../event-bus";

    export default {
        components: {
            Cropper,
        },
        data() {
            return {
                media: {},
                image_height: '',
                sizes: [],
                selected_size: {},
                cropper_width: 150,
                cropper_height: 150,
                old_image_preview: '/images/no-user.png',
                currentCropSize: null,
                isLoading: false
            }
        },
        created() {
            this.fetchSizes();
        },
        mounted() {
            this.image_height = this.$attrs.height
        },
        methods: {
            change({ coordinates, canvas }) {
                this.currentCropSize = coordinates.width + 'x' + coordinates.height;
            },
            fetchSizes() {
                this.addLoading();
                axios.get('/admin/api/image-sizes')
                    .then(({data}) => {
                        this.sizes = data;
                        this.media = this.$attrs.media;
                        this.selected_size = data.thumb;
                        this.sizeClicked(this.selected_size);
                        this.removeLoading();
                    })
            },
            sizeClicked(size) {
                this.selected_size = size;
                this.cropper_width = size.width;
                this.cropper_height = size.height;

                this.$refs.cropper.setCoordinates({
                    width: this.cropper_width,
                    height: this.cropper_height,
                });

                this.currentCropSize = this.cropper_width + 'x' + this.cropper_height;

                // this.$refs.cropper.reset();

                this.old_image_preview = this.media[size.slug + '_path'];
            },
            saveImage() {
                this.addLoading();
                axios.patch('/admin/api/media/'+ this.media.id +'/resize', {
                    'size_name': this.selected_size.slug,
                    'cropper': this.$refs.cropper.getResult()
                })
                .then(({data}) => {
                    this.media[this.selected_size.slug+'_path'] = data.image;

                    this.old_image_preview = data.image;

                    EventBus.$emit('mediaSaved', {
                        media: this.media,
                        closeModal: false
                    });

                    this.removeLoading();
                })
            },
            addLoading() {
                this.isLoading = true;
            },
            removeLoading() {
                this.isLoading = false;
            },
            closeModal() {
                EventBus.$emit('editImageModalClosed', this.media)
            }
        },

    }
</script>

<style>
    .size-option {
        display: block;
    }
    .media-form .form {
        margin-top: 0
    }
    h5 {
        color: black;
        margin-bottom: 20px;
    }
    .old-image-preview {
        margin: 20px auto;
        position: relative;
    }
    .old-image-preview img {
        max-height: 300px;
        max-width: 250px;
        background-color: white;
        padding: 5px;
    }
    .vue-advanced-cropper {
        margin-right: 30px;
    }
    .current-crop-size {
        position: absolute;
        left: 0;
        font-size: 20px;
        background-color: #65b3c5;
        color: white;
        padding: 3px 10px;
        border-radius: 5px;
        z-index: 999;
        font-family: Aria;
    }
    .loading {
        position: absolute;
        z-index: 99;
        top: 20%;
        left: 30%;
    }
    .loading i{
        font-size: 250px;
        z-index: 99;
        color: #d7d7d7;
    }
</style>
