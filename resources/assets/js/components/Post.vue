<template>
    <div>
        <div class="box profile-info n-border-top" id="cloutPost">
            <form id="postForm">
                <textarea class="form-control input-lg p-text-area not-resize" id="postarea" rows="5" v-model="content" placeholder="What's on your mind today?" style="resize:none;padding:25px;font-size:14px;overflow:hidden"></textarea>
                <div class="dropzone" id="postImgBlock" style="border: 0px;display:none;"></div>
            </form>
            <div class="box-footer box-form">
                <div class="pull-right">
                    <label class="btn btn-link" id="chars">0 / 200</label>
                    <button type="button" class="btn btn-azure" id="postBtn" :disabled="not_working" @click="create_post()">Post</button>
                </div>
                <ul class="nav nav-pills">
                    <li class="dropdown">
                        <a href="#" id="location" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <i class="fa fa-map-marker"></i>
                        </a>
                        <ul class="dropdown-menu" style="padding: 20px;width:300px;">
                            <li>Add Location</li>
                            <li>
                                <input type="text" class="form-control" id="locationBox" name="locationBox" v-model="location">
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" id="camera" @click.prevent="showupload">
                            <i class="fa fa-camera"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#" id="video" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-film"></i>
                        </a>
                        <ul class="dropdown-menu" style="padding: 20px;width:300px;">
                            <li>Video Url</li>
                            <li>
                                <input class="form-control" id="videoBox" name="videoBox" type="url" v-model="video">
                            </li>
                        </ul>
                    </li>
                    <li>
                        <select class="form-control">
                            <option value="">Share my thoughts</option>
                            <option value="">Create a Petition</option>
                            <option value="">Create a Poll</option>
                            <option value="">Post a speech</option>
                            <option value="">Press Release</option>
                            <option value="">Interview</option>
                        </select>
                    </li>
                </ul>
            </div>
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

        // Handle the dropzone events
        const vm = this
        this.dropzone.on('addedfile', function (file) {
            //vm.$emit('droply-file-added', file)
            if(vm.dropzone.files.length) {
                vm.not_working = false
            }
        })

        this.dropzone.on('removedfile', function (file) {
            //vm.$emit('droply-removed-file', file)
            if(vm.dropzone.files.length) {
                vm.not_working = false
            } else {
                vm.not_working = true
            }
        })

        this.dropzone.on('success', function (file, response) {
            console.log(response)
            if(response == "unable to save post") {
                new Noty({
                    type: 'warning',
                    layout: 'bottomLeft',
                    text: 'Unable to save post. Check your internet and try again.'
                }).show();
            } else {
                vm.content = ''
                //this.get_feed()
                window.location.reload()

                //this.dropzone.removeAllFiles(true)
            }
            //vm.$emit('droply-success', file, response)
        })

        this.dropzone.on('error', function (file, error, xhr) {
            //vm.$emit('droply-error', file, error, xhr)
            new Noty({
                type: 'error',
                layout: 'bottomLeft',
                text: error
            }).show();
        })

        this.dropzone.on('sending', function (file, xhr, formData) {
            formData.append('_token', vm.toki)
            formData.append('content', vm.content)
            formData.append('video', vm.video)
            formData.append('location', vm.location)
            //vm.$emit('droply-sending', file, xhr, formData)
        })

        this.dropzone.on('uploadprogress', function (file, progress, size) {
            //vm.$emit('droply-uploadprogress', file, progress, size)
        })

        this.dropzone.on('complete', function (file) {
            //vm.$emit('droply-uploadprogress', file, progress, size)
            new Noty({
                type: 'success',
                layout: 'bottomLeft',
                text: 'Post saved.'
            }).show();
        })
    }, 
    data() {
        return {
            content: '',
            location: '',
            video: '',
            not_working: true,
            remaining_characters: 200,
        }
    }, 
    methods: {
        create_post() {
            if(this.dropzone.files.length) {
                this.dropzone.processQueue()
            } else {
                axios.post('/post/store', { content: this.content, location: this.location, video: this.video  })
                 .then( (resp) => {
                     if(resp == "unable to save post") {
                         new Noty({
                            type: 'success',
                            layout: 'bottomLeft',
                            text: 'Post saved.'
                        }).show();
                     } else {
                         this.content = ''
                        new Noty({
                            type: 'success',
                            layout: 'bottomLeft',
                            text: 'Post saved.'
                        }).show();
                        //console.log(resp)
                        //this.$store.commit("empty_post")
                        //this.get_feed()
                        window.location.reload()
                     }
                 })
            }
        },
        removeAllFiles: function () {
            this.dropzone.removeAllFiles(true)
        },
        processQueue: function () {
            this.dropzone.processQueue()
        },
        showupload() {
            //document.getElementById("postImgBlock").
            $("#postImgBlock").slideToggle(200);
        },
        get_feed() {
            axios.get('/feed/' + this.user_id)
                .then( (resp) => {
                    resp.data.forEach( (post) => {
                        this.$store.commit("add_post", post)
                    })
                } )
        }, 
    },
    watch: {
        content() {
            if(this.content.length > 0 && this.content.length <= 200) {
                this.not_working = false
                document.getElementById("chars").innerHTML = this.content.length + " / 200"
            } else {
                this.not_working = true
                document.getElementById("chars").innerHTML = this.content.length + " / 200"
            }
        }
    }
}
</script>

<style>
    .not-resize {
        resize: none;
    }
</style>