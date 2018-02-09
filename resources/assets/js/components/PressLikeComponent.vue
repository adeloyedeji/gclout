<template>
    <div>
        <hr v-if="press.likes.length > 0">

        <p>
            <span v-for="like in press.likes">
                <img :src="like.user.avatar" :alt="like.user.name" :title="like.user.name" class="avatar-like" width="30px" height="30px">
            </span>
        </p>

        <span v-if="!auth_user_likes_press">
            <a class="noln" href="javascript:void(0)"  title="Like" @click="like()">
                <i class="glyphicon glyphicon-heart-empty"></i>
            </a>&emsp;
        </span>
        <span v-else>
            <a class="noln" href="javascript:void(0)" title="Unlike" @click="unlike()">
                <i class="glyphicon glyphicon-heart"></i>
            </a>&emsp;&emsp;
        </span>

        <a class="noln" href="javascript:void(0);">
            <i class="fa fa-share" style="font-size:15px;"></i>
        </a>&emsp;

        <span class="pull-right text-muted">
            <span v-if="press.likes.length > 0">
                <span >{{ press.likes.length }}</span> Likes - <span id="totcompst">0</span> Shares
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
                this.press.likes.forEach( (like) => {
                    likers.push(like.user.id)
                })
                return likers
            },
            auth_user_likes_press() {
                var check_index = this.likers.indexOf(
                    this.$store.state.auth_user.id
                )
                if(check_index === -1)
                    return false
                else
                    return true
            },
            press() {
                return this.$store.state.press.find( (press) => {
                    return press.id === this.id
                })
            }
        },
        mounted() {

        }, 
        methods: {
            like() {
                axios.get('/press/like/' + this.id)
                     .then( (resp) => {
                         this.$store.commit('update_press_likes', {
                             id: this.id,
                             like: resp.data,
                         })
                         new Noty({
                            type: 'success',
                            layout: 'bottomLeft',
                            text: 'You liked this press release.'
                        }).show();
                     }) 
            }, 
            unlike() {
                axios.get('/press/unlike/' + this.id)
                     .then( (resp) => {
                         this.$store.commit('unlike_press_like', {
                             id: this.id, 
                             like_id: resp.data
                         })
                         new Noty({
                            type: 'success',
                            layout: 'bottomLeft',
                            text: 'You unliked this press released.'
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
