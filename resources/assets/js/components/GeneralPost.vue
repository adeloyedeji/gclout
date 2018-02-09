<template>
    <div>
        <div class="box profile-info n-border-top" id="cloutPost">
            <form id="postForm">
                <textarea class="form-control input-lg p-text-area not-resize" id="postarea" rows="5" v-model="content" placeholder="What's on your mind today?" style="resize:none;padding:25px;font-size:14px;overflow:hidden;overflow-y:auto"></textarea>
                <div class="dropzone" id="postImgBlock" style="border: 0px;display:none;"></div>
            </form>
            <div class="box-footer box-form">
                <div class="pull-right">
                    <button type="button" class="btn btn-azure" id="postBtn" :disabled="not_working" @click="create_post()">Create Post</button>
                </div>
                <ul class="nav nav-pills">
                    <li>
                        <p>
                            <label :class="is_valid" id="chars">0 / 5000</label>
                        </p>
                    </li>
                    <li :class="location_li">
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
                    <li :class="video_li">
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
                        <select class="form-control" v-model="category">
                            <option v-for="category in post_categories" :value="category.id">{{ category.category }}</option>
                        </select>
                    </li>
                </ul>
                <span class="pull-left">
                    
                </span>
                <br>
            </div>
        </div>

        <!--Petition Modal -->
        <petition-modal :user_id="user_id" :toki="toki" :url="'/general/store'"></petition-modal>
        <!--End Petition Modal -->

        <!--Poll Modal -->
        <div class="modal fade" id="pollModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Create Poll</h4>
                    </div>
                    <div class="modal-body">
                        <div class="widget-body">
                            <div class="collapse in">
                                <form role="form">
                                    <div class="form-group">
                                        <label for="definpu">Poll Title</label>
                                        <input type="text" class="form-control" placeholder="Poll Title" id="poll_title" name="poll_title">
                                    </div>
                                    <div class="form-group">
                                        <label for="definpu">Poll Body</label>
                                        <textarea rows="5" class="form-control" placeholder="Type your content here." id="poll_body" name="poll_body" style="resize:none;font-size:14px;overflow:hidden" v-model="content"></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="category" class="control-label">Category</label>
                                                <select id="category_new" class="form-control" name="category">
                                                    <option value="Political">Political</option>
                                                    <option value="Economy">Economy</option>
                                                    <option value="Education">Education</option>
                                                    <option value="Technology">Technology</option>
                                                    <option value="Power">Power</option>
                                                    <option value="Corruption">Corruption</option>
                                                    <option value="Religion">Religion</option>
                                                    <option value="Sports">Sports</option>
                                                    <option value="Entertainments">Entertainments</option>
                                                    <option value="Security">Security</option>
                                                    <option value="Foreign Relations">Foreign Relations</option>
                                                    <option value="Justice">Justice</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="category" class="control-label">Political Office Holder</label>
                                                <select id="target_arm" class="form-control" name="target_arm">
                                                    <option value="President">President</option>
                                                    <option value="Governor">Governor</option>
                                                    <option value="Senate">Senate</option>
                                                    <option value="House of Reps">House of Reps</option>
                                                    <option value="State Reps">State Reps</option>
                                                    <option value="Local Govt">Local Government Chairman</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label for="" class="control-label text-danger" id="need_number"></label>                        
                                        </div>
                                    </div>
                                
                                    <!-- <div class="form-group">
                                        <span class="input-icon">
                                            <input type="text" class="form-control input-lg" name="timeframe" id="timeframe">
                                            <i class="fa fa-calender info circular"></i>
                                        </span>
                                    </div> -->
                                    <div class="form-group">
                                        <span class="input-icon">
                                            <label>Type of Answer</label>
                                            <select id="answers" class="form-control" name="answers">
                                                <option value="1">Yes/No/Maybe</option>
                                                <option value="1">Agree/Disagree/Undecided</option>
                                            </select>
                                            <!-- <i class="fa fa-calender info circular"></i> -->
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <span class="input-icon">
                                            <label>Attach Image</label>
                                            <input type="file" id="image" class="form-control" name="imagenew">
                                            <!-- <i class="fa fa-calender info circular"></i> -->
                                        </span>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary" id="postData">Create Poll</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End Poll Modal -->
    </div>
</template>

<script>
import PetitionModal from './PetitionModal.vue'
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
        // const petitionElement = document.getElementById("petitionFile")

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
        // this.petitionDropZone = new Dropzone(petitionElement, options)

        const vm = this
        this.dropzone.on('addedfile', function (file) {
            if(vm.dropzone.files.length) {
                vm.not_working = false
            }
        })

        this.dropzone.on('removedfile', function (file) {
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
            formData.append('content', vm.content)
            formData.append('video', vm.video)
            formData.append('location', vm.location)
        })

        this.dropzone.on('uploadprogress', function (file, progress, size) {
        })

        this.dropzone.on('complete', function (file) {
            new Noty({
                type: 'success',
                layout: 'bottomLeft',
                text: 'Post saved.'
            }).show();
        })
        this.get_post_categories()
    },
    data() {
        return {
            content: '',
            location: '',
            video: '',
            not_working: true,
            is_valid: 'btn btn-link show',
            remaining_characters: 200,
            post_categories: [],
            category: 1,
            location_li: 'dropdown',
            video_li: '',
            petitionBody: '',
        }
    },
    methods: {
        get_post_categories() {
            axios.get('/general/get-categories')
                 .then( (resp) => {
                     resp.data.forEach( (c) => {
                         this.post_categories.push(c)
                     })
                 }).catch(error => {
                     window.location.reload()
                 })
        },
        showupload() {
            $("#postImgBlock").slideToggle(200)
        }
    },
    watch: {
        content() {
            if(this.content.length > 0 && this.content.length <= 5000) {
                this.not_working = false
                this.$store.commit("update_content", this.content)
                document.getElementById("chars").innerHTML = this.content.length + " / 5000"
            } else {
                this.not_working = true
                document.getElementById("chars").innerHTML = this.content.length + " / 5000"
            }
        }, 
        category() {
            if(this.category == 1) {
                this.is_valid = 'btn btn-link show'
                this.location_li = 'dropdown show'
                this.video_li = 'show'
            } else {
                this.is_valid = 'btn btn-link hide'
                this.location_li = 'dropdown hide'
                this.video_li = 'hide'
            }

            if(this.category == 2) {
                $("#petitionModal").modal("show")
            } else if(this.category == 3) {
                $("#pollModal").modal("show")
            }
        }
    }, 
    components: {
        PetitionModal
    }
}
</script>

