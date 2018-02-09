<template>
    <div>
        <hr v-if="post.likes.length > 0">

        <p>
            <span v-for="like in post.likes">
                <img :src="like.user.avatar" :alt="like.user.name" :title="like.user.name" class="avatar-like" width="30px" height="30px">
            </span>
        </p>

        <a class="noln" href="javascript:void(0)" v-if="!auth_user_likes_post" title="Like" @click="like()"><i class="glyphicon glyphicon-heart-empty"></i>&emsp;</a>
        <a class="noln" href="javascript:void(0)" v-else title="Unlike" @click="unlike()"><i class="glyphicon glyphicon-heart"></i>&emsp;&emsp;</a>

        <a class="noln" href="javascript:void(0);">
            <i class="fa fa-share" style="font-size:15px;"></i>
        </a>&emsp;
        <a class="noln" href="javascript:void(0);">
            <i class="fa fa-trash text-danger" style="font-size:15px;"></i>
        </a>

        <span class="pull-right text-muted">
            <span v-if="post.likes.length > 0 || post.comments.length > 0">
                <span >{{ post.likes.length }}</span> Likes - <span id="totcompst">{{ post.comments.length }}</span> Comments
            </span>
        </span>
    </div>
</template>

<script>
    export default {
        props: [
            'id'
        ],
        computed: {
            likers() {
                var likers = []
                this.post.likes.forEach( (like) => {
                    likers.push(like.user.id)
                })
                return likers
            },
            auth_user_likes_post() {
                var check_index = this.likers.indexOf(
                    this.$store.state.auth_user.id
                )
                if(check_index === -1)
                    return false
                else
                    return true
            },
            post() {
                return this.$store.state.posts.find( (post) => {
                    return post.id === this.id
                })
            }
        },
        mounted() {

        }, 
        methods: {
            like() {
                axios.get('/like/' + this.id)
                     .then( (resp) => {
                         this.$store.commit('update_post_likes', {
                             id: this.id,
                             like: resp.data,
                         })
                         new Noty({
                            type: 'success',
                            layout: 'bottomLeft',
                            text: 'You successfully liked the post.'
                        }).show();
                     }) 
            }, 
            unlike() {
                axios.get('/unlike/' + this.id)
                     .then( (resp) => {
                         this.$store.commit('unlike_post_like', {
                             post_id: this.id, 
                             like_id: resp.data
                         })
                         new Noty({
                            type: 'success',
                            layout: 'bottomLeft',
                            text: 'You unliked the post.'
                        }).show();
                     }) 
            }
        }
    }
</script>

<style>
    .avatar-like {
        border-radius: 50%;
    }
    .full-hr {
        width:100%;
        padding: 0px;
    }
    .noln {
        text-decoration: none;
    }
    .noln:hover {
        text-decoration: none;
    }
</style>
