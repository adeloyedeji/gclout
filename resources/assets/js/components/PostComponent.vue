<template>
    <div>
        <img class="img-responsive img-circle img-sm" :src="image" alt="name">
        <div class="img-push">
            <input type="text" class="form-control input-sm cmt-input" placeholder="Hit enter to comment" v-model="comment" @keyup="check_comment">
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'id'
    ],
    mounted() {
        this.get_auth_user_data()
    }, 
    data() {
        return {
            image: '',
            name: '',
            username: '',
            image: '',
            comment: '',
        }
    },
    methods: {
        get_auth_user_data() {
            axios.get('/get_auth_user_data')
                .then( (resp) => {
                    this.image = resp.data.avatar
                    this.name = resp.data.name
                    this.username = resp.data.username
                } )
        },
        check_comment(e) {
            if(e.keyCode == 13) {
                if(!this.comment) { 
                    new Noty({
                        type: 'warning',
                        layout: 'bottomLeft',
                        text: 'Type a comment to proceed.'
                    }).show();
                } else {
                    this.post_comment();
                }
            }
        },
        post_comment() {
            axios.post('/post-comment', { id: this.id, comment:this.comment })
                    .then( (resp) => {
                        this.$store.commit('update_post_comments', {
                            post_id: this.id,
                            comments: this.comment,
                        })
                        new Noty({
                            type: 'success',
                            layout: 'bottomLeft',
                            text: 'Comment saved.'
                        }).show();
                        
                    }) 
        },
    }
}
</script>

