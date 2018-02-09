<template>
    <div>
        <div class="box box-widget" v-for="post in posts" :id="post.id">
            <div class="box-header with-border" :id="'post' + post.id">
                <div class="user-block">
                    <img :src="post.user.avatar" alt="" width="50px" height="50px" class="avatar-feed">
                    <span class="username">
                        <a :href="'/profile/' + post.user.username">{{ post.user.name }}</a> 
                        <span style="font-size:12px;color:#aaa">@</span>
                        <span style="font-size:12px;color:#aaa">{{ post.user.username }}</span>
                    </span>
                    <span class="description">
                        Posted {{ moment_format(post.created_at) }} {{ post.location }}.
                    </span>
                </div>
            </div>
            <div class="box-body" style="display:block;word-wrap:break-word;">
                <span v-if="post.photos">
                    <span>
                        <span v-if="post.content">{{ post.content }}</span>
                        <p></p>
                        <span v-for="photo in post.photos">
                            <img class="img-responsive show-in-modal" :src="photo.photo" alt="Photo">
                        </span>
                    </span>
                </span>
                <div v-else>
                    <span id="">{{ post.content }}</span>
                </div>
                <p></p>
                
                <like :id="post.id"></like>
                
            </div>
            <div class="box-footer box-comments" style="display: block;">
                <span v-if="post.comments.length > 0">
                    <div class="box-comment" v-for="comment in post.comments">
                        <img class="img-circle img-sm" :src="comment.user.avatar" :alt="comment.user.name">
                        <div class="comment-text" style="word-wrap: break-word">
                            <span class="username">
                                {{ comment.user.name }}
                                <span class="text-muted pull-right">
                                    {{ moment_format(comment.created_at) }}
                                </span>
                            </span>
                            {{ comment.comments }}
                        </div>
                    </div>
                    
                </span>
                <post-comment :id="post.id"></post-comment>
            <div>
        </div>
    </div>
        </div>
        </div>
</template>

<script>
    import Like from './Like.vue'

    import PostComment from './PostComponent.vue'
    export default {
        props: [
            'id'
        ],
        mounted() {
            this.get_feed()
            this.get_auth_user_data()
        }, 
        data() {
            return {
                image: '',
                name: '',
                username: '',
                total_likes: 0,
                total_comments: 0,
            }
        },
        components: {
            Like,
            PostComment
        },
        methods: {
            get_feed() {
                axios.get('/feed/' + this.id)
                    .then( (resp) => {
                        resp.data.forEach( (post) => {
                            this.$store.commit("add_post", post)
                        })
                    } )
            }, 
            get_auth_user_data() {
                axios.get('/get_auth_user_data')
                     .then( (resp) => {
                            this.image = resp.data.avatar
                            this.name = resp.data.name
                            this.username = resp.data.username
                     } )
            }, 
            moment_format(date) {
                // return Moment().startOf(date).fromNow();
                return Moment(data, 'YYYY-MM-DD HH:mm:ss').startOf('hour').fromNow()
                //return Moment(date).fromNow()
            }
        }, 
        computed: {
            posts() {
                return this.$store.getters.all_posts
            }
        }
    }
</script>

<style>
    .avatar-feed {
        border-radius: 50%;
    }
</style>
