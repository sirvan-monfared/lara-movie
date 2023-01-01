<template>
    <div>
        <uploader :csrf="csrf" v-show="showUpload" @uploadSuccess="onUploadSuccess"></uploader>

        <div class="card">
            <div class="card-body media-filter">

                <span v-show="! selectMode">
                    <select name="media_type" id="media_type" title="همه موارد رسانه ای" v-model="filters.media_type" @change="reload">
                        <option value="0">همه موارد رسانه ای</option>
                        <option value="image">تصاویر</option>
                        <option value="video">ویدئوها</option>
                    </select>

                    <select name="created_at" id="created_at" title="همه تاریخ ها" v-model="filters.created_at" @change="reload">
                        <option value="0">همه تاریخ ها</option>
                        <option value="7">یک هفته قبل</option>
                        <option value="30">یک ماه قبل</option>
                        <option value="180">شش ماه قبل</option>
                        <option value="365">یک سال قبل</option>
                    </select>

                    <input type="text" name="keyword" id="keyword" title="جستجو" v-model="filters.keyword" @input="debounceInput" placeholder="جستجو در پرونده های چندرسانه ای ...">

                    <span class="media-searching" v-show="isLoading">
                        <i class="fa fa-spinner fa-spin"></i>
                    </span>
                </span>

                <span v-show="selectMode">
                    <button class="btn btn-default btn-sm" @click.prevent="cancelSelectMode"> لغو انتخاب  </button>
                    <button class="btn btn-danger btn-sm" @click.prevent="deleteSelected" :disabled="!selectedMedias.length"><i class="fa fa-trash"></i>  پاک کردن انتخاب شده ها</button>
                </span>

                <span v-show="! selectMode">
                    <button class="btn btn-info btn-sm add-media-button"  @click.prevent="showUpload = !showUpload"><i class="fa fa-upload"></i> افزودن </button>
                    <button class="btn btn-accent btn-sm select-mode-button" @click.prevent="selectMode = true"> انتخاب دسته جمعی </button>
                </span>
            </div>
        </div>
        <div class="media-wrapper">
            <div class="media-manager">
                <div class="gallery-wrapper">
                    <div class="gallery-item" v-for="item in media" @click.prevent="imageClicked(item)">
                        <img :src="item.thumb_path" alt="thumb">
                        <i class="fa fa-check item-selected-badge" v-show="item.has_selected"></i>
                        <span class="item-name" v-show="item.type !== 'image'">{{ item.base_name }}</span>
                    </div>

                    <div class="no-item-found" v-if="! media.length && ! isLoading">
                        هیچ پرونده رسانه ای یافت نشد
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import Uploader from "./Uploader"
    import EditMedia from "./EditMedia";
    import EventBus from "../event-bus";

    export default {
        components: {
            uploader: Uploader
        },
        props: {
            'csrf': {type: String},
        },
        data() {
            return {
                media: [],
                filters: {
                    media_type: 0,
                    created_at: 0,
                    keyword: null
                },
                debounce: null,
                isLoading: false,
                showUpload: false,
                selectMode: false,
                selectedMedias: []
            }
        },
        created() {
            this.fetchMedias();
            EventBus.$on('mediaSaved', (data) => {
                console.log(data.media);
                // replace old media with saved one reactively
                this.media.splice(this.media.findIndex(item => {
                    return item.id === data.media.id
                }), 1, data.media);

                if (data.closeModal) {
                    this.$modal.hide('edit_media');
                }
            })

            EventBus.$on('mediaDeleted', (media) => {
                this.removeMediaFromList(media);

                this.$modal.hide('edit_media');
            })
            EventBus.$on('modalClosed', () => {
                this.$modal.hide('edit_media');
            })
        },
        methods: {
            fetchMedias() {
                this.addLoading();

                axios.get('/admin/api/media-manager', {
                    params: this.filters
                })
                .then(({data}) => {
                    this.media = data;
                    this.removeLoading();
                })
            },
            reload() {
                console.log(this.filters);
                this.fetchMedias()
            },
            imageClicked(media) {
                if (this.selectMode) {
                    this.select(media);
                } else {
                    this.showModal(media);
                }
            },
            select(media) {
                if (! media.has_selected) {
                    this.$set(media, 'has_selected', true);
                    this.selectedMedias.push(media);
                } else {
                    this.$set(media, 'has_selected', false);

                    let index = this.selectedMedias.findIndex((item) => item.id === media.id);
                    this.selectedMedias.splice(index, 1);
                }
            },
            showModal(media) {
                this.$modal.show(
                    EditMedia,
                    {
                        csrf: this.csrf,
                        media: JSON.parse(JSON.stringify(media))
                    },
                    {
                        name: 'edit_media',
                        draggable: false,
                        scrollable: true,
                        width: '90%',
                        height: '90%'
                    }
                )
            },
            addLoading() {
                this.isLoading = true
            },
            removeLoading() {
                this.isLoading = false
            },
            debounceInput(e) {
                clearTimeout(this.debounce)
                this.debounce = setTimeout(() => {
                    this.filters.keyword = e.target.value
                    this.reload()
                }, 300)
            },
            onUploadSuccess(file, response) {
                this.media.unshift(response.media);
            },
            cancelSelectMode() {
                $.each(this.selectedMedias, (index, media) => {
                    this.$set(media, 'has_selected', false)
                });
                this.selectedMedias = [];

                this.selectMode = false;
            },
            deleteSelected() {
                if (! confirm("آیا از پاک کردن موارد انتخاب شده مطمئن هستید؟ این عمل غیرقابل بازگشت است")) {
                    return;
                }

                $.each(this.selectedMedias, (index, media) => {
                    axios.delete('/admin/api/media/'+ media.id +'/delete')
                        .then((data) => {
                            this.removeMediaFromList(media)
                        })
                })

                this.cancelSelectMode();
            },
            removeMediaFromList(media) {
                this.media.splice(this.media.findIndex(item => {
                    return item.id === media.id
                }), 1);
            }
        }
    }
</script>

<style>
    .media-manager {
        margin-top: 20px
    }
    .media-searching {
        margin-right: 10px;
    }
    .media-searching i{
        font-size: 20px;
        color: #999999;
        position: relative;
        top: 5px;
    }
    .no-item-found {
        width: 100%;
        text-align: center;
        font-size: 20px;
        margin-top: 40px;
    }
    .add-media-button, .select-mode-button {
        float: left;
        margin-right: 10px;
    }
    .uploader {
        margin-bottom: 20px;
    }
    .item-name {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 100%;
        text-align: center;
        font-size: 13px;
        padding: 5px;
        box-shadow: inset 0 0 15px rgb(0 0 0 / 10%), inset 0 0 0 1px rgb(0 0 0 / 5%);
        background: #eee;
        font-family: Tahoma;
        max-height: 65px;
        overflow-y: hidden;
    }
</style>
