<template>
    <div class="media-edit-modal" ref="container">
        <div class="modal-header level">
            <div class="modal-title">جزئیات رسانه</div>
            <div class="modal-actions">
                <div class="close-modal modal-action" v-if="media.type === 'image'" @click.prevent="editImageClicked">
                    <i class="fa fa-edit"></i>
                </div>
                <div class="close-modal modal-action" @click.prevent="closeModal">
                    <i class="fa fa-times"></i>
                </div>
            </div>
        </div>
        <div class="modal-body p-0">
            <div class="row">
                <div class="col-sm-8 col-xs-12">
                    <div class="loading" v-show="isLoading">
                        <i class="fa fa-spinner fa-spin"></i>
                    </div>
                    <div class="media-frame">
                        <img :src="media.original_path" alt="" :style="{ maxHeight: image_height }" v-if="media.type === 'image'">

                        <video-player v-if="media.type === 'video'"
                           class="vjs-custom-skin"
                           ref="videoPlayer"
                           :playsinline="true"
                           :options="{
                                muted: true,
                                autoplay: true,
                                height: image_height,
                                sources: [{
                                    type: media.mime_type,
                                    src: media.original_path
                                }],
                            }"
                        ></video-player>
                    </div>
                </div>
                <div class="col-sm-4 col-xs-12">
                    <div class="media-form" :style="{ height: image_height }">
                        <div class="media-info name">آدرس فایل: <div class="foreign">{{ media.original_url }}</div></div>
                        <div class="media-info mime">نوع فایل: <span class="foreign">{{ media.mime_type }}</span></div>
                        <div class="media-info size">حجم فایل: <span class="foreign">{{ media.size / 1000 }} </span> کیلوبایت</div>
                        <div class="media-info date">تاریخ آپلود: <span>{{ media.shamsi_date }}</span> </div>

                        <div class="form">
                            <div class="form-group form-group--float form-group--icon form-group--active">
                                <input type="text" name="title" id="title" class="form-control" v-model="media.title">
                                <span class="input-icon-addon top-3"> <i class="fa fa-edit"></i> </span>
                                <label for="title">عنوان </label>
                            </div>
                            <div class="form-group form-group--float form-group--icon form-group--active">
                                <textarea name="description" id="description" class="form-control medium" v-model="media.metas.description"></textarea>
                                <span class="input-icon-addon top-3"> <i class="fa fa-edit"></i> </span>
                                <label for="description">توضیحات </label>
                            </div>

                            <div class="image-picker-wrapper" v-if="media.type === 'video'">
                                <h5 class="title">پوستر ویدئو</h5>
                                <image-gallery namespace="poster_form" ref="poster_form" no_upload type="image" :media="videoPoster()"></image-gallery>
                            </div>

                        </div>

                        <div class="divider"></div>

                        <div class="form-footer">
                            <div class="pull-right">
                                <a href="/" class="delete-link" @click.prevent="deleteMedia">حذف فایل چندرسانه ای</a>
                            </div>
                            <div class="pull-left">
                                <button type="button" class="btn btn-accent save-button" @click.prevent="saveMedia">ذخیره</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import EventBus from "../event-bus";
    import EditImage from "./EditImage";

    import 'video.js/dist/video-js.css'
    import { videoPlayer } from 'vue-video-player'

    export default {
        components: {
            videoPlayer
        },
        data() {
            return {
                media: {},
                image_height: '',
                isLoading: false
            }
        },
        created() {
            this.media = this.$attrs.media

            EventBus.$on('editImageModalClosed', function() {
                this.$modal.hide('edit_image');
            });
        },
        mounted() {
            this.image_height = ((window.innerHeight * 0.8) - 32) + 'px';
        },
        methods: {
            saveMedia() {
                this.addLoading();
                axios.patch('/admin/api/media/'+ this.media.id +'/update', {
                    media: this.media,
                    video_poster: (this.media.type === 'video') ? this.$refs.poster_form.input_value : null
                })
                    .then(({data}) => {
                        this.removeLoading();
                        EventBus.$emit('mediaSaved', {
                            media: data.media
                        });
                    })
            },
            deleteMedia() {
                if (! confirm("برای حذف این فایل مطمئن هستید؟")) {
                    return;
                }

                this.addLoading();

                axios.delete('/admin/api/media/'+ this.media.id +'/delete')
                    .then((data) => {
                        this.removeLoading();
                        EventBus.$emit('mediaDeleted', this.media)
                    })
            },
            closeModal() {
                EventBus.$emit('modalClosed', this.media)
            },
            addLoading() {
                this.isLoading = true;
            },
            removeLoading() {
                this.isLoading = false;
            },
            editImageClicked() {
                this.$modal.show(
                    EditImage,
                    {
                        media: this.media,
                        height: this.image_height
                    },
                    {
                        name: 'edit_image',
                        draggable: false,
                        scrollable: true,
                        width: '90%',
                        height: '90%'
                    }
                )
            },
            videoPoster() {
                if (this.media.video_poster) {
                    return JSON.stringify([this.media.video_poster]);
                }

                return JSON.stringify([]);
            }
        }
    }
</script>
<style>
    .media-edit-modal {
        direction: rtl;
    }
    .media-edit-modal .media-frame {
        box-sizing: border-box;
        padding: 16px;
        height: 100%;
    }
    .media-edit-modal .media-frame img{
        display: block;
        margin: 0 auto 16px;
        max-width: 100%;
        max-height: calc(100% - 42px);
        background-image: linear-gradient(-45deg,#c4c4c4 25%,transparent 25%,transparent 75%,#c4c4c4 75%,#c4c4c4),linear-gradient(-45deg,#c4c4c4 25%,transparent 25%,transparent 75%,#c4c4c4 75%,#c4c4c4);
        background-position: 100% 0,10px 10px;
        background-size: 20px 20px;
    }
    .media-form {
        overflow-x: hidden;
        overflow-y: auto;
        border: 1px solid #dbdbdb;
        background-color: #f0f0f0;
        margin: 1px;
        padding: 10px;
        border-radius: 1px;
        color: #666666
    }
    .media-form .media-info {
        margin-bottom: 10px;
    }
    .media-form .media-info.name .foreign {
        word-break: break-all;
        font-size: 12px;
        direction: ltr;
        text-align: left;
    }
    .media-form .form {
        margin-top: 40px;
    }
    .form-group--active > label {
        border-radius: 3px;
    }
    .form-footer {
        padding: 10px 0;
    }
    .save-button {
        margin-bottom: 10px;
    }
    .form-group {
        margin-bottom: 30px;
    }
    .delete-link {
        color: #c75c5c;
        position: relative;
        top: 10px;
    }
    .modal-header {
        padding: 0;
        background-color: #f8f8f8;
        font-size: 22px;
    }
    .modal-title {
        padding: 10px 20px;
    }
    .modal-actions .modal-action {
        padding: 10px 20px;
        border-right: 1px solid #dedede;
        cursor: pointer;
        display: inline-block;
    }
    .modal-actions .modal-action:hover {
        background-color: #dedede;
    }
    .form-group--float textarea.medium {
        height: 130px !important;
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
    .video-js {
        margin: 0 auto;
    }
</style>
