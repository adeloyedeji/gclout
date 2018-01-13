<template>
    <div>
        <div class="superbox">
            <div class="superbox-list">
                <img :src="user.avatar" class="img-responsive superbox-img show-in-modal" alt="workimg"  style="height: 110px;">
            </div>
            <div class="superbox-list" v-for="photo in photos">
                <img :src="photo" class="img-responsive superbox-img show-in-modal" alt="workimg" style="height: 110px;">
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'id', 'username'
    ],
    mounted() {
        this.get_auth_user_data()
        this.get_photos()
    }, 
    data() {
        return {
            user: [],
            photos: [],
        }
    }, 
    methods: {
        get_auth_user_data() {
            axios.get("/get_auth_user_data/" + this.id)
                 .then( (resp) => {
                     this.user = resp.data
                 })
        },
        get_photos() {
            axios.get('/photos/get_photo/' + this.id)
                 .then( (resp) => {
                     console.log(resp.data)
                     this.photos = resp.data
                 })
        }
    }
}
</script>
