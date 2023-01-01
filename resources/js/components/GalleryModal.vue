<template>
    <div>
        <button class="btn btn-accent accept-button" v-if="can_choose_multiple" @click="applySelected">
            <i class="fa fa-check"></i> اعمال انتخاب ها
        </button>

        <tabs>
            <tab name="گالری" prefix="<i class='fa fa-images'></i>">
                <div class="media-searching big" v-if="isLoading">
                    <i class="fa fa-spinner fa-spin"></i>
                </div>
                <div class="no-item-found" v-if="! media && ! isLoading">
                    هیچ پرونده رسانه ای یافت نشد
                </div>
                <div class="gallery-wrapper">
                    <div class="gallery-item" v-for="item in media" @click.prevent="mediaClicked(item)">
                        <img :src="item.thumb_path" alt="thumb">
                        <i class="fa fa-check item-selected-badge" v-show="item.has_selected"></i>
                        <span class="item-name" v-show="item.type !== 'image'">{{ item.base_name }}</span>
                    </div>
                </div>
            </tab>
            <tab name="آپلود" prefix="<i class='fa fa-upload'></i>" v-if="this.has_upload">
                <uploader :csrf="csrf" @uploadSuccess="onUploadSuccess"></uploader>
            </tab>
        </tabs>
    </div>
</template>

<script>
    import EventBus from "../event-bus";
    import Uploader from './Uploader';

    export default {
        components: {
            uploader: Uploader
        },
        data() {
            return {
                can_choose_multiple: this.$attrs.multiple,
                media: null,
                selected_items: [],
                csrf: null,
                isLoading: false,
                has_upload: true
            }
        },
        created() {
            if (this.$attrs.selected && this.can_choose_multiple) {
                this.selected_items = this.$attrs.selected;
            }

            this.has_upload = ! this.$attrs.no_upload;
            this.csrf = this.$attrs.csrf;
            this.fetchGallery();
            this.mediaSelectedEventName = 'mediaHasSelected__' + this.$attrs.namespace;
        },
        methods: {
            fetchGallery() {
                this.addLoading();
                axios.get('/admin/api/gallery',{
                    params: {
                        media_type: this.$attrs.media_type
                    }
                })
                .then(({data}) => {
                    if (this.can_choose_multiple) {
                        let ids = this.selected_items.map(item => item.id);

                        $.each(data, (index, media) => {
                            if (ids.indexOf(media.id) !== -1) {
                                media.has_selected = true;
                            }
                        });
                    }

                    this.media = data;
                    this.removeLoading();
                })
            },
            onUploadSuccess(file, response) {
                this.media.unshift(response.media);
            },
            mediaClicked(media) {
                if (! this.can_choose_multiple) {
                    EventBus.$emit(this.mediaSelectedEventName, [media]);
                }

                if (this.can_choose_multiple) {
                    if (! media.has_selected) {
                        this.$set(media, 'has_selected', true);
                        this.selected_items.push(media);
                    } else {
                        this.$set(media, 'has_selected', false);

                        let index = this.selected_items.findIndex((item) => item.id === media.id);
                        this.selected_items.splice(index, 1);
                    }
                }
            },
            applySelected() {
                EventBus.$emit(this.mediaSelectedEventName, this.selected_items);
            },
            addLoading() {
                this.isLoading = true
            },
            removeLoading() {
                this.isLoading = false
            },
        }
    }
</script>

<style>
    .tabs-component {
        direction: rtl;
    }
    .tabs-component-tabs {
        border: solid 1px #ddd;
        border-radius: 6px;
        margin-bottom: 5px;
        padding-right: 0;
        padding-top: 20px;
    }

    @media (min-width: 700px) {
        .tabs-component-tabs {
            border: 0;
            align-items: stretch;
            display: flex;
            justify-content: flex-start;
            margin-bottom: -1px;
        }
    }

    .tabs-component-tab {
        color: #999;
        font-size: 14px;
        font-weight: 600;
        margin-right: 0;
        list-style: none;
        width: 100px;
        text-align: center;
    }

    .tabs-component-tab:not(:last-child) {
        border-bottom: dotted 1px #ddd;
    }

    .tabs-component-tab:hover {
        color: #666;
    }

    .tabs-component-tab.is-active {
        background-color: #ffffff;
        color: #000;
    }

    .tabs-component-tab.is-disabled * {
        color: #cdcdcd;
        cursor: not-allowed !important;
    }

    @media (min-width: 700px) {
        .tabs-component-tab {
            background-color: #e4e4e4;
            border: solid 1px #ddd;
            border-radius: 3px 3px 0 0;
            margin-right: .5em;
            transition: transform .3s ease;
        }

        .tabs-component-tab.is-active {
            border-bottom: solid 1px #fff;
            z-index: 2;
        }
    }

    .tabs-component-tab-a {
        align-items: center;
        color: inherit;
        display: flex;
        padding: .75em 1em;
        text-decoration: none;
    }
    .tabs-component-tab-a i {
        padding-left: 10px;
    }

    .tabs-component-panels {
        padding: 4em 0;
    }

    @media (min-width: 700px) {
        .tabs-component-panels {
            border-top-left-radius: 0;
            background-color: #fff;
            border: solid 1px #ddd;
            border-radius: 0 6px 6px 6px;
            box-shadow: 0 0 10px rgba(0, 0, 0, .05);
            padding: 4em 2em;
        }
    }

    .accept-button {
        position: absolute;
        left: 3px;
        top: 20px;
        border-radius: 5px;
        direction: rtl;
    }
    .item-selected-badge {
        position: absolute;
        top: 5px;
        right: 5px;
        font-size: 13px;
        background-color: #36a3f7;
        color: white;
        padding: 3px;
        outline: 1px auto;
    }
</style>
