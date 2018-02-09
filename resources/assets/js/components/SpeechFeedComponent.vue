<template>
    <div>
        <div class="box box-widget" v-for="speech in speeches" :id="speech.id">
            <div class="box-header with-border" :id="'speech' + speech.id">
                <div class="user-block">
                    <img :src="speech.user.avatar" alt="" width="50px" height="50px" class="avatar-feed">
                    <span class="username">
                        <a :href="'/profile/' + speech.user.username">{{ speech.user.name }}</a> 
                        <span style="font-size:12px;color:#aaa">@</span>
                        <span style="font-size:12px;color:#aaa">{{ speech.user.username }}</span>
                    </span>
                    <span class="description">
                        Posted {{ moment_format(speech.created_at) }}.
                    </span>
                </div>
            </div>
            <div class="box-body" style="display:block;word-wrap:break-word;">
                <span v-if="speech.photos">
                    <span>
                        <span v-if="speech.body">{{ speech.body }}</span>
                        <p></p>
                        <span v-for="photo in speech.photos">
                            <center><img class="img-responsive show-in-modal" :src="photo.photo" alt="Photo"></center>
                            <p></p>
                        </span>
                    </span>
                </span>
                <div v-else>
                    <span>{{ speech.body }}</span>
                </div>
                <p></p>
                <speech-like :id="speech.id"></speech-like>
            </div>
        </div>
    </div>
</template>

<script>
import SpeechLike from './SpeechLikeComponent.vue'

export default {
    props: [
        'id'
    ],
    mounted() {
        this.get_speech_feed()
    }, 
    data() {
        return {

        }
    },
    components: {
        SpeechLike,
    },
    methods: {
        get_speech_feed() {
            axios.get('/speeches/feed/' + this.id)
                .then( (resp) => {
                    resp.data.forEach( (speech) => {
                        this.$store.commit("add_speech", speech)
                    })
                } ).catch(error => {
                    console.log("Error: ")
                    console.log(error)
                    new Noty({
                        type: 'success',
                        layout: 'bottomLeft',
                        text: error.message
                    }).show();
                })
        }, 
        moment_format(date) {
            return Moment(date, 'YYYY-MM-DD HH:mm:ss').startOf('hour').fromNow()
        }
    },
    computed: {
        get_auth_user() {
            this.auth_user = this.$store.getters.get_auth_user_data
            return this.auth_user
        },
        speeches() {
            return this.$store.getters.all_speech
        }
    }
}
</script>

<style>
    .avatar-feed {
        border-radius: 50%;
    }
</style>
