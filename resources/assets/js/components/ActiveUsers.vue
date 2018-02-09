<template>
    <div>
        <div class="chat-sidebar">
            <div class="list-group text-left">
                <p class="text-center visible-xs"><a href="#" class="hide-chat btn btn-success">Hide</a></p> 
                <p class="text-center chat-title">Active clouts</p> 
                <span v-for="user in users">
                    <a :href="'/profile' + users.username" class="list-group-item">
                        <i class="fa fa-check-circle connected-status" v-if="user.profile.online_status"></i>
                        <i class="fa fa-times-circle absent-status" v-else></i>
                        <img :src="user.avatar" class="img-chat img-thumbnail">
                        <span class="chat-user-name">{{ user.name }}</span>
                    </a>
                </span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'user_id'
    ],
    mounted() {
        this.get_active_users()
    }, 
    methods: {
        get_active_users() {
            axios.get('/users/active/' + this.user_id)
                 .then( (resp) => {
                     resp.data.forEach( (u) => {
                         this.$store.commit("add_active_user", u)
                     })
                 })
        }
    },
    computed: {
        users() {
            return this.$store.getters.all_active_users
        }
    }
}
</script>
