<template>
    <div>
        
    </div>
</template>

<script>
export default {
    props: [
        'id'
    ],
    data() {
        return {
            clouts: [],
            pending_clouts: [],
            pending_clouts_sent: [],
        }
    },
    mounted() {
        this.listen()
        this.get_clouts()
        this.listen_to_friends()
        this.get_auth_user()
    }, 
    methods: {
        get_auth_user() {
            axios.get('/get_auth_user_data')
                 .then( (resp) => {
                     this.$store.commit("auth_user_data", resp.data)
                 }).catch(error => {
                    new Noty({
                        type: 'success',
                        layout: 'bottomLeft',
                        text: error.message
                    }).show();
                 })
        },
        listen() {
            Echo.private('App.User.' + this.id)
                .notification( (data) => {
                    new Noty({
                        type: 'success',
                        layout: 'bottomLeft',
                        text: data.name + data.message
                    }).show();
                    this.$store.commit("add_notification", data)
                    document.getElementById("noty_audio").play()
                })
        }, 
        listen_to_friends() {
            var user_clouts;
            axios.get("/get_clouts/" + this.id)
                 .then( (resp) => {
                     user_clouts = resp.data
                    if(user_clouts.length > 0) {
                        user_clouts.forEach( (u) => {
                            Echo.private('App.User.' + u.id)
                                .notification( (data) => {
                                    if(data.type == 'App\\Notifications\\ShareFriendActivity') {
                                        if(data.id === this.id) {
                                            new Noty({
                                                type: 'success',
                                                layout: 'bottomLeft',
                                                text: "You are now friends with " + data.friend_name
                                            }).show();
                                        } else {
                                            new Noty({
                                                type: 'success',
                                                layout: 'bottomLeft',
                                                text: data.name + data.message + data.friend_name
                                            }).show();
                                        }
                                    } else if(data.type == 'App\\Notifications\\CloutLoginNotitification') {
                                        new Noty({
                                            type: 'success',
                                            layout: 'bottomLeft',
                                            text: data.name + data.message
                                        }).show();
                                        this.$store.commit("add_active_user", data)
                                    } else {
                                        new Noty({
                                            type: 'success',
                                            layout: 'bottomLeft',
                                            text: data.name + data.message
                                        }).show();
                                    }
                                    this.$store.commit("add_notification", data)
                                })
                        })
                    }
                 })
        },
        get_clouts() {
            axios.get("/get_clouts/" + this.id)
                 .then( (resp) => {
                     this.clouts = resp.data
                 })
        },
        get_pending_clouts() {
            axios.get("/get_pending_clouts/" + this.id)
                 .then( (resp) => {
                     this.pending_clouts = resp.data
                 })
        }, 
        get_pending_clouts_sent() {
            axios.get("/get_pending_clouts_sent/" + this.id)
                 .then( (resp) => {
                     this.pending_clouts_sent = resp.data
                 })
        },
    }
}
</script>
