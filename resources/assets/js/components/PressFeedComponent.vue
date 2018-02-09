<template>
    <div>
        <div class="box box-widget" v-for="press in presses" :id="press.id">
            <div class="box-header with-border" :id="'press' + press.id">
                <div class="user-block">
                    <img :src="press.user.avatar" alt="" width="50px" height="50px" class="avatar-feed">
                    <span class="username">
                        <a :href="'/profile/' + press.user.username">{{ press.user.name }}</a> 
                        <span style="font-size:12px;color:#aaa">@</span>
                        <span style="font-size:12px;color:#aaa">{{ press.user.username }}</span>
                    </span>
                    <span class="description">
                        Posted {{ moment_format(press.created_at) }}.
                    </span>
                </div>
            </div>
            <div class="box-body" style="display:block;word-wrap:break-word;">
                <span v-if="press.photos">
                    <span>
                        <span v-if="press.body">{{ press.body }}</span>
                        <p></p>
                        <span v-for="photo in press.photos">
                            <center><img class="img-responsive show-in-modal" :src="photo.photo" alt="Photo"></center>
                            <p></p>
                        </span>
                    </span>
                </span>
                <div v-else>
                    <span>{{ press.body }}</span>
                </div>
                <p></p>
                <press-like :id="press.id"></press-like>
            </div>
        </div>
    </div>
</template>

<script>
import PressLike from './PressLikeComponent.vue'

export default {
    props: [
        'id'
    ],
    mounted() {
        this.get_press_feed()
    }, 
    data() {
        return {

        }
    },
    components: {
        PressLike,
    },
    methods: {
        get_press_feed() {
            axios.get('/press/feed/' + this.id)
                .then( (resp) => {
                    resp.data.forEach( (press) => {
                        this.$store.commit("add_press", press)
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
        presses() {
            return this.$store.getters.all_press
        }
    }
}
</script>

<style>
    .avatar-feed {
        border-radius: 50%;
    }
</style>
