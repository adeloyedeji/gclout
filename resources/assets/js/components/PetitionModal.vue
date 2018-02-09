<template>
  <div>
      <div class="modal fade" id="petitionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Create Petition</h4>
                    </div>
                    <div class="modal-body">
                        <div class="widget-body">
                            <div class="collapse in">
                                <form role="form">
                                    <div class="form-group">
                                        <label for="definpu">Petition Title</label>
                                        <input type="text" class="form-control" placeholder="Petition Title" id="movement_title" name="movement_title" v-model="petitionTitle">
                                    </div>
                                    <div class="form-group">
                                        <label for="definpu">Petition Body</label>
                                        <textarea rows="5" class="form-control" placeholder="Petition Body" id="movement_body" name="movement_body" style="resize:none;font-size:14px;overflow:hidden" v-model="petitionBody"></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="category" class="control-label">Category</label>
                                                <select id="category_new" class="form-control" name="category" v-model="petitionCategory">
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
                                                <select id="target_arm" class="form-control" name="target_arm" v-model="petitionTarget">
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
                                            <input type="text" class="form-control input-lg" name="timeframe" id="timeframe" v-model="petitionTime">
                                            <i class="fa fa-calender info circular"></i>
                                        </span>
                                    </div> -->
                                    <div class="dropzone" id="petitionFile" style="border: 0px;"></div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-primary" id="postData" @click.prevent="create_post()" :disabled="has_petition">Create Petition</button>
                                    </div>
                                </form>
                            </div>
                        </div>
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
        user_id: {
            required: true
        },
        toki: {
            type: String,
            required: true,
        },
        url: {
            type: String,
            required:true,
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
        this.setBody()
        const element = document.getElementById("petitionFile")

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
                vm.has_petition = false
            }
        })

        this.dropzone.on('removedfile', function (file) {
            if(vm.dropzone.files.length) {
                vm.has_petition = false
            } else {
                vm.has_petition = true
            }
        })

        this.dropzone.on('success', function (file, response) {
            console.log(response)
            if(response === -1) {
                new Noty({
                    type: 'warning',
                    layout: 'bottomLeft',
                    text: 'Unable to save post. Check your internet and try again.'
                }).show();
            } else {
                vm.petitionTitle = ''
                vm.petitionTitle = ''
                vm.petitionBody = ''
                vm.petitionCategory = 0
                vm.petitionTarget = 0
                vm.petitionTime = ''
                new Noty({
                    type: 'success',
                    layout: 'bottomLeft',
                    text: 'Petition succesfully created!.'
                }).show();
                vm.$store.commit("add_petition", response)
                $("#petitionModal").modal("hide")
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
            formData.append('title', vm.petitionTitle)
            formData.append('body', vm.petitionBody)
            formData.append('category', vm.petitionCategory)
            formData.append('target', vm.petitionTarget)
            formData.append('time', vm.petitionTime)
            formData.append('type', 2)
        })

        this.dropzone.on('complete', function (file) {
            new Noty({
                type: 'success',
                layout: 'bottomLeft',
                text: 'Post saved.'
            }).show();
        })
    },
    data() {
        return {
            petitionTitle: '',
            petitionBody: '',
            petitionCategory: '',
            petitionTarget: '',
            petitionTime: '',
            has_petition: true,
        }
    }, 
    methods: {
        create_post() {
            if(this.dropzone.files.length) {
                this.dropzone.processQueue()
            } else {
                console.log("Using axios")
                axios.post('/general/store', {
                    title: this.petitionTitle,
                    body: this.petitionBody,
                    category: this.petitionCategory,
                    target: this.petitionTarget,
                    time: this.petitionTime,
                    type:2
                }).then( (resp) => {
                    console.log(resp.data)
                    if(resp.data === -1) {
                        new Noty({
                            type: 'error',
                            layout: 'bottomLeft',
                            text: 'Unable to save petition. Check your connection and try again.'
                        }).show();
                    } else {
                        this.$store.commit("add_petition", resp.data)
                        this.petitionTitle = ''
                        this.petitionTitle = ''
                        this.petitionBody = ''
                        this.petitionCategory = 0
                        this.petitionTarget = 0
                        this.petitionTime = ''
                        new Noty({
                            type: 'success',
                            layout: 'bottomLeft',
                            text: 'Petition succesfully created!.'
                        }).show();
                        $("#petitionModal").modal("hide")
                    }
                }).catch(error => {
                    new Noty({
                        type: 'error',
                        layout: 'bottomLeft',
                        text: 'Unable to process this request'
                    }).show();
                    console.log("From PetitionModal")
                    console.log(error.message)
                })
            }
        },
        removeAllFiles: function () {
            this.dropzone.removeAllFiles(true)
        },
        processQueue: function () {
            this.dropzone.processQueue()
        },
        setBody() {
            this.petitionBody = this.content
        }
    },
    watch: {
        petitionTarget() {
            if(this.petitionTarget == "President") {
                document.getElementById("need_number").innerHTML = "You need 5000 People to Sign this Petition";
            } else if(this.petitionTarget == "Governor") {
                document.getElementById("need_number").innerHTML = "You need 3000 People to Sign this Petition";
            } else if(this.petitionTarget == "Senate") {
                document.getElementById("need_number").innerHTML = "You need 1000 People to Sign this Petition";
            } else if(this.petitionTarget == "House of Reps") {
                document.getElementById("need_number").innerHTML = "You need 1500 People to Sign this Petition";
            } else if(this.petitionTarget == "State Reps") {
                document.getElementById("need_number").innerHTML = "You need 750 People to Sign this Petition";
            } else if(this.petitionTarget == "Local Govt") {
                document.getElementById("need_number").innerHTML = "You need 500 People to Sign this Petition";
            }
        }, 
        // petitionBody() {
        //     this.$store.commit("update_content", this.petitionBody)
        // }
        petitionBody() {
            if(this.petitionBody.length > 0 && this.petitionTitle.length > 0) {
                this.has_petition = false
            } else {
                this.has_petition = true
            }
        }, 
        petitionTitle() {
            if(this.petitionBody.length > 0 && this.petitionTitle.length > 0) {
                this.has_petition = false
            } else {
                this.has_petition = true
            }
        }
    }, 
    computed: {
        content() {
            return this.$store.getters.get_content
        }, 
    }
}
</script>

