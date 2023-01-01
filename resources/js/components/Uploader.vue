<template>
    <div class="uploader">
        <vue-dropzone ref="myVueDropzone" id="dropzone" :options="dropzoneOptions" :useCustomSlot="true" @vdropzone-success="uploadSuccess">
            <div class="dropzone-custom-content">
                <i class="fa fa-upload"></i>
                <h3 class="dropzone-custom-title">فایل را بکشید و در این قسمت رها کنید!</h3>
                <div class="subtitle">و یا برای انتخاب فایل از کامپیوتر خود اینجا کلیک کنید ...</div>
            </div>
        </vue-dropzone>
    </div>
</template>

<script>
    import vue2Dropzone from 'vue2-dropzone'
    import 'vue2-dropzone/dist/vue2Dropzone.min.css';
    export default {
        components: {
            vueDropzone: vue2Dropzone
        },
        props: {
            'csrf': {type: String},
        },
        data() {
            return {
                dropzoneOptions: {
                    url: '/admin/api/upload',
                    // maxFilesize: 2,
                    headers: {
                        "X-CSRF-TOKEN": this.csrf,
                    },
                    addRemoveLinks: true,
                    resizeMethod: 'crop',
                    maxFiles: 20,
                    dictCancelUpload: 'انصراف',
                    dictRemoveFile: 'حذف فایل',
                },
            }
        },
        methods: {
            uploadSuccess(file, response) {
                this.$emit('uploadSuccess', file, response)
            }
        }
    }
</script>
