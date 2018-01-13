<template>
    <div class="row">
        <p class="text-center" v-if="loading">
            Loading...
        </p>
        <p class="text-center" v-if="!loading">
            <button class="btn btn-sm btn-info" v-if="status == 0" @click="add_friend">Add Friend</button>
            <button class="btn btn-sm btn-info" v-if="status == 'pending'" @click="accept_friend">Accept Friend</button>
            <span class="text-success" v-if="status == 'waiting'">Waiting for response</span>
            <span class="text-success" v-if="status == 'friends'">Friends</span>
        </p>
    </div>
</template>

<script>
    export default {
        props: [
            'profile_user_id',
        ],
        mounted() {
            //console.log('Component mounted.')
            axios.get('/check_relationship_status/' + this.profile_user_id)
                 .then( (response) => {
                     this.status = response.data.status
                     this.loading = false
                 } );
        },  
        data() {
            return {
                status: '',
                loading: true,
            }
        }, 
        methods: {
            add_friend() {
                this.loading = true;
                axios.get('/add_friend/' + this.profile_user_id)
                     .then( (response) => {
                         if(response.data == 1) {
                             this.status = 'waiting'
                             new Noty({
                                type: 'success',
                                layout: 'bottomLeft',
                                text: 'Friend request sent.'
                            }).show();
                             this.loading = false
                         }
                     } );
            }, 
            accept_friend() {
                this.loading = true;
                axios.get('/accept_friend/' + this.profile_user_id)
                     .then( (response) => {
                         console.log(response)
                         if(response.data == 1) {
                             this.status = 'friends'
                             new Noty({
                                type: 'success',
                                layout: 'bottomLeft',
                                text: 'You are now friends.'
                             }).show();
                             this.loading = false
                         }
                     });
            }
        }
    }
</script>
