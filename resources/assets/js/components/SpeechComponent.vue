<template>
    <div>
        <div class="box profile-info n-border-top" id="press_block">
            <form id="postForm">
                <textarea class="form-control input-lg p-text-area not-resize" id="postarea" rows="5" v-model="content" placeholder="What's on your mind today?" style="resize:none;padding:25px;font-size:14px;overflow:hidden"></textarea>
                <div class="dropzone" id="postImgBlock" style="border: 0px;display:none;"></div>
            </form>
            <div class="box-footer box-form">
                <div class="pull-right">
                    <button type="button" class="btn btn-azure" id="postBtn" :disabled="has_content" @click="create_post()">Post Speech</button>
                </div>
                <ul class="nav nav-pills">
                    <li>
                        <a href="#" id="camera" @click.prevent="showupload">
                            <i class="fa fa-camera"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div id="speech_block_content">

        </div>
    </div>
</template>

<script>
import Dropzone from 'dropzone'

Dropzone.autoDiscover = false
export default {
    props: {
        user_id: {
            required: true
        },
        toki: {
            type: String,
            required: true,
        },
        id: {
            type: String,
            required: true
        },
        url: {
            type: String,
            required: true
        },
        clickable: {
            type: Boolean,
            default: true
        },
        acceptedFileTypes: {
            type: String
        },
        thumbnailHeight: {
            type: Number,
            default: 100
        },
        thumbnailWidth: {
            type: Number,
            default: 100
        },
        showRemoveLink: {
            type: Boolean,
            default: true
        },
        maxFileSizeInMB: {
            type: Number,
            default: 5
        },
        maxNumberOfFiles: {
            type: Number,
            default: 5
        },
        autoProcessQueue: {
            type: Boolean,
            default: false
        },
        useFontAwesome: {
            type: Boolean,
            default: false
        },
        useCustomDropzoneOptions: {
            type: Boolean,
            default: false
        },
        dropzoneOptions: {
            type: Object
        },
        icons: {
            type: Object,
            default () {
                return {
                    cloud: 'fa fa-cloud-upload',
                    done: 'fa fa-check',
                    error: 'fa fa-close'
                }
            }
        },
        uploadMessageText: {
            type: String,
            default: 'Drop file(s) to upload <br><strong>or click</strong>'
        },
        removeImageText: {
            type: String,
            default: 'Remove'
        },
        headers: {
            type: Object
        }
    },
    mounted() {
        // this.get_auth_user()
        const element = document.getElementById("postImgBlock")

        const defaultSettings = {
            clickable: this.clickable,
            thumbnailWidth: this.thumbnailWidth,
            thumbnailHeight: this.thumbnailHeight,
            maxFiles: this.maxNumberOfFiles,
            maxFilesize: this.maxFileSizeInMB,
            dictRemoveFile: this.removeImageText,
            addRemoveLinks: this.showRemoveLink,
            acceptedFiles: this.acceptedFileTypes,
            autoProcessQueue: this.autoProcessQueue,
            headers: this.headers,
            url: this.url,
            parallelUploads:5,
            uploadMultiple: true,
            dictDefaultMessage: `<i class="${this.icons.cloud}" aria-hidden="true"></i>
                                <br>${this.uploadMessageText}`,
            previewTemplate: `
                        <div class="dz-preview dz-file-preview">
                            <div class="dz-image" style="width: ${this.thumbnailWidth}px; height: ${this.thumbnailHeight}px">
                                <img data-dz-thumbnail />
                            </div>
                            <div class="dz-details">
                                <div class="dz-size">
                                    <span data-dz-size></span>
                                </div>
                                <div class="dz-filename">
                                    <span data-dz-name></span>
                                </div>
                            </div>
                            <div class="dz-progress">
                                <span class="dz-upload" data-dz-uploadprogress></span>
                            </div>
                            <div class="dz-error-message">
                                <span data-dz-errormessage></span>
                            </div>
                            <div class="dz-success-mark">
                                <i class="${this.icons.done}" aria-hidden="true"></i>
                            </div>
                            <div class="dz-error-mark">
                                <i class="${this.icons.error}" aria-hidden="true"></i>
                            </div>
                        </div>`
        }
        const options = Object.assign({}, defaultSettings, this.dropzoneOptions)
        this.dropzone = new Dropzone(element, options)

        const vm = this
        this.dropzone.on('addedfile', function (file) {
            if(vm.dropzone.files.length) {
                vm.has_content = false
            }
        })

        this.dropzone.on('removedfile', function (file) {
            if(vm.dropzone.files.length) {
                vm.has_content = false
            } else {
                vm.has_content = true
            }
        })

        this.dropzone.on('success', function (file, response) {
            if(response == "unable to save post") {
                new Noty({
                    type: 'warning',
                    layout: 'bottomLeft',
                    text: 'Unable to save post. Check your internet and try again.'
                }).show();
            } else if(response == "body") {
                new Noty({
                    type: 'warning',
                    layout: 'bottomLeft',
                    text: 'Please type a press release to continue.'
                }).show();
            } else {
                vm.content = ''
                vm.$store.commit("update_speech", response)
                vm.removeAllFiles()
            }
        })

        this.dropzone.on('error', function (file, error, xhr) {
            new Noty({
                type: 'error',
                layout: 'bottomLeft',
                text: error
            }).show();
        })

        this.dropzone.on('sending', function (file, xhr, formData) {
            formData.append('_token', vm.toki)
            formData.append('body', vm.content)
        })

        this.dropzone.on('uploadprogress', function (file, progress, size) {
        })

        this.dropzone.on('complete', function (file) {
            // new Noty({
            //     type: 'success',
            //     layout: 'bottomLeft',
            //     text: 'Post saved.'
            // }).show();
        })
    },
    data() {
        return {
            has_content: true,
            content: '',
        }
    }, 
    methods: {
        create_post() {
            var speech = this.content
            if(this.dropzone.files.length) {
                if(this.content.length <= 0) {
                    new Noty({
                        type: 'error',
                        layout: 'bottomLeft',
                        text: 'Please type your speech to continue.'
                    }).show()
                    return false
                } else {
                    this.dropzone.processQueue()
                }
            } else {
                var auth_user = this.get_auth_user
                axios.post('/speeches/store', {body:this.content})
                     .then( (resp) => {
                         console.log(resp.data)
                         if(resp.data === -1) {
                            new Noty({
                                type: 'error',
                                layout: 'bottomLeft',
                                text: 'Unable to save. Check your connection and try again'
                            }).show();
                         } else if(resp.data == "invalid method") {
                            new Noty({
                                type: 'error',
                                layout: 'bottomLeft',
                                text: 'Direct access to this page not allowed!'
                            }).show();
                         } else {
                            this.$store.commit("update_speech", resp.data)
                            this.content = ''
                         }
                     }).catch(error => {
                        new Noty({
                            type: 'error',
                            layout: 'bottomLeft',
                            text: error.message
                        }).show();
                     })
            }
        }, 
        showupload() {
            $("#postImgBlock").slideToggle(200);
        },
        removeAllFiles: function () {
            this.dropzone.removeAllFiles(true)
        },
        processQueue: function () {
            this.dropzone.processQueue()
        },
    }, 
    watch: {
        content() {
            if(this.content.length > 0) {
                this.has_content = false
            } else {
                this.has_content = true
            }
        }
    }, 
    computed: {
        get_auth_user() {
            this.auth_user = this.$store.getters.get_auth_user_data
            return this.auth_user
        },
    }
}
</script>

<style>
    .not-resize {
        resize: none;
    }
</style>
