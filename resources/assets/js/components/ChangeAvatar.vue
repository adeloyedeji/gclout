<template>
    <div>
        <div class="modal fade" id="uploadAvatarBox" tabindex="-1" role="dialog" aria-labelledby="uploadAvatarBox" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="uploadAvatarBox">Change Avatar</h4>
                    </div>
                    <div class="modal-body">
                        <div class="dropzone" id="picbox">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" id="changeAvatar" class="btn btn-primary" @click.prevent="saveavatar">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Dropzone from 'dropzone'

Dropzone.autoDiscover = false
export default {
    props: {
        toki: {
            type: String,
            required: true,
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
            default: 1
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
            default: 'Drop picture here to upload <br><strong>or click</strong>'
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
        const element = document.getElementById("picbox")

        const defaultSettings = {
            clickable: this.clickable,
            thumbnailWidth: this.thumbnailWidth,
            thumbnailHeight: this.thumbnailHeight,
            maxFiles: this.maxNumberOfFiles,
            maxFilesize: this.maxFileSizeInMB,
            dictRemoveFile: this.removeImageText,
            addRemoveLinks: this.showRemoveLink,
            acceptedFiles: 'image/*',
            autoProcessQueue: this.autoProcessQueue,
            headers: this.headers,
            url: this.url,
            uploadMultiple: false,
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

        // Handle the dropzone events
        const vm = this
        this.dropzone.on('addedfile', function (file) {
            //vm.$emit('droply-file-added', file)
        })

        this.dropzone.on('removedfile', function (file) {
            //vm.$emit('droply-removed-file', file)
        })

        this.dropzone.on('success', function (file, response) {
            if(response == 1) {
                new Noty({
                    type: 'success',
                    layout: 'bottomLeft',
                    text: 'Profile picture saved.'
                }).show();
                window.location.reload()
            } else if(response == 2) {
                new Noty({
                    type: 'warning',
                    layout: 'bottomLeft',
                    text: 'Unable to update picture at this time!'
                }).show();
            } else {
                new Noty({
                    type: 'warning',
                    layout: 'bottomLeft',
                    text: response.file
                }).show();
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
        })

        this.dropzone.on('uploadprogress', function (file, progress, size) {
            //vm.$emit('droply-uploadprogress', file, progress, size)
        })

        this.dropzone.on('complete', function (file) {
            
        })
    },
    data() {
        return {
            hasImage: true
        }
    },
    methods: {
        saveavatar() {
            if(this.dropzone.files.length) {
                this.dropzone.processQueue()
            } else {
                new Noty({
                    type: 'error',
                    layout: 'bottomLeft',
                    text: 'You need to upload an image to continue.'
                }).show();
            }
        },
        removeAllFiles: function () {
            this.dropzone.removeAllFiles(true)
        },
        processQueue: function () {
            this.dropzone.processQueue()
        },
    },
    watch: {
        
    }
}
</script>
