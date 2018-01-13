<template>
    <div>
        <div class="col-md-3 fl" style="max-height:200px;margin-bottom:150px;" v-for="friend in clouts">
            <div class="contact-box center-version">
                <a :href="'/profile/'+friend.username">
                    <img alt="image" class="img-circle" :src="friend.avatar">
                    <h3 class="m-b-xs" style="font-size:14px;"><strong>{{ friend.name }}</strong></h3>
                    <div class="font-bold">{{  friend.email }}</div>
                </a>
                <div class="contact-box-footer">
                    <div class="m-t-xs btn-group">
                        <a :href="'/messaging/'+friend.username" class="btn btn-xs btn-white">
                            <i class="fa fa-envelope"></i>Send Message
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 fl" style="max-height:200px;margin-bottom:150px;" v-for="friend in pending_clouts">
            <div class="contact-box center-version">
                <a :href="'/profile/'+friend.username">
                    <img alt="image" class="img-circle" :src="friend.avatar">
                    <h3 class="m-b-xs" style="font-size:14px;"><strong>{{ friend.name }}</strong></h3>
                    <div class="font-bold">{{  friend.email }}</div>
                </a>
                <div class="contact-box-footer">
                    <div class="m-t-xs btn-group">
                        <a :href="'/messaging/'+friend.username" class="btn btn-xs btn-white" @click.prevent="accept_friend(friend.id)">
                            <i class="fa fa-user-plus"></i>Accept
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 fl" style="max-height:200px;margin-bottom:150px;" v-for="friend in pending_clouts_sent">
            <div class="contact-box center-version">
                <a :href="'/profile/'+friend.username">
                    <img alt="image" class="img-circle" :src="friend.avatar">
                    <h3 class="m-b-xs" style="font-size:14px;"><strong>{{ friend.name }}</strong></h3>
                    <div class="font-bold">{{  friend.email }}</div>
                </a>
                <div class="contact-box-footer">
                    <div class="m-t-xs btn-group">
                        <a href="javascript:void(0)" class="btn btn-xs btn-white">
                            <i class="fa fa-check"></i>Request sent
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'user_id'
    ],
    data() {
        return {
            clouts: [],
            pending_clouts: [],
            pending_clouts_sent: [],
        }
    },
    mounted() {
        this.get_clouts()
        this.get_pending_clouts()
        this.get_pending_clouts_sent()
    }, 
    methods:  {
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
        }
    }
}
</script>

<style>
.fl {
    max-height: 200px !important;
}
</style>
