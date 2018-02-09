<template>
    <div>
        <div class="name">
            <a :href="'/profile/edit/' + username" v-if="user.id === id">{{ name }}</a>
            <a href="javascript::void(0)" v-else>{{ name }}</a><p></p>
            <span v-for="clout in clouts">
                <button class="btn btn-default" v-if="clout.id === id">Send Chat</button>
            </span>
            <span v-for="clout in pending_clouts">
                <button class="btn btn-success" v-if="clout.id === id" @click="accept_friend(clout.id)">Accept request</button>
            </span>
            <span v-for="clout in pending_clouts_sent">
                <button class="btn btn-success" v-if="clout.id === id" @click.prevent="cancel_request(clout.id)">Cancel request</button>
            </span>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'id', 'username', 'name', 'user_id'
    ],
    mounted() {
        this.get_auth_user_data()
        this.get_clouts()
        this.get_pending_clouts()
        this.get_pending_clouts_sent()
    },
    data() {
        return {
            user: {},
            clouts: [],
            pending_clouts: [],
            pending_clouts_sent: [],
        }
    },
    methods: {
        get_auth_user_data() {
            axios.get('/get_auth_user_data/' + this.id)
                    .then( (resp) => {
                        this.user = resp.data
                    } )
        }, 
        get_clouts() {
            axios.get("/get_clouts/" + this.user_id)
                 .then( (resp) => {
                     this.clouts = resp.data
                 })
        },
        get_pending_clouts() {
            axios.get("/get_pending_clouts/" + this.user_id)
                 .then( (resp) => {
                     this.pending_clouts = resp.data
                 })
        }, 
        get_pending_clouts_sent() {
            axios.get("/get_pending_clouts_sent/" + this.user_id)
                 .then( (resp) => {
                     this.pending_clouts_sent = resp.data
                 })
        },
        accept_friend(id) {
            axios.get('/accept_friend/' + id)
                .then( (resp) => {
                    if(resp.data == 1) {
                        new Noty({
                            type: 'success',
                            layout: 'bottomLeft',
                            text: 'You are now friends.'
                        }).show();
                        this.get_clouts()
                        this.get_pending_clouts()
                        this.get_pending_clouts_sent()
                    }
                })
        },
        cancel_request(id) {
            axios.get('/cancel_request/' + id)
                 .then( (resp) => {
                     if(resp.data == 1) {
                         new Noty({
                            type: 'success',
                            layout: 'bottomLeft',
                            text: 'Request declined.'
                        }).show();
                        this.get_clouts()
                        this.get_pending_clouts()
                        this.get_pending_clouts_sent()
                     }
                 })
        }
    }
}
</script>
