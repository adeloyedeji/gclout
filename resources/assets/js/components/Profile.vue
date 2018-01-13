<template>
    <div>
        <div class="widget">
            <div class="widget-header">
                <h3 class="widget-caption">About</h3>
            </div>
            <div class="widget-body bordered-top bordered-sky">
                <ul class="list-unstyled profile-about margin-none">
                    <li class="padding-v-5">
                        <div class="row">
                            <div class="col-sm-4"><span class="text-muted">Date of Birth</span></div>
                            <div class="col-sm-8">{{  user.profile.date_of_birth }}</div>
                        </div>
                    </li>
                    <li class="padding-v-5">
                        <div class="row">
                            <div class="col-sm-4"><span class="text-muted">Gender</span></div>
                            <div class="col-sm-8" v-if="user.gender">Male</div>
                            <div class="col-sm-8" v-else>Female</div>
                        </div>
                    </li>
                    <li class="padding-v-5">
                        <div class="row">
                            <div class="col-sm-4"><span class="text-muted">Lives in</span></div>
                            <div class="col-sm-8" v-if="user.profile.state_id">{{ user.profile.state.state }}, {{ user.profile.country.country }}</div>
                            <div class="col-sm-8" v-else>{{ user.profile.country.country }}</div>
                        </div>
                    </li>
                    <li class="padding-v-5">
                        <div class="row">
                            <div class="col-sm-4"><span class="text-muted">Followers</span></div>
                            <div class="col-sm-8">0</div>
                        </div>
                    </li>
                    <li class="padding-v-5">
                        <div class="row">
                            <div class="col-sm-4"><span class="text-muted">Following</span></div>
                            <div class="col-sm-8">0</div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="widget widget-friends">
            <div class="widget-header">
                <h3 class="widget-caption">Friends</h3>
            </div>
            <div class="widget-body bordered-top  bordered-sky">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="img-grid" style="margin: 0 auto;">
                            <li v-for="friend in friends">
                                <a :href="'/profile/' + friend.username">
                                    <img :src="friend.avatar" :alt="friend.name">
                                </a>
                            </li>
                            <li v-if="friends.length <= 0">
                                <h4>:-( You currently don't have any friends</h4>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'id'
    ],
    mounted() {
        this.get_clouts()
        this.get_auth_user_data()
    }, 
    data() {
        return {
            user: [],
            friends: [],
        }
    }, 
    methods: {
        get_auth_user_data() {
            axios.get("/get_auth_user_data/" + this.id)
                 .then( (resp) => {
                     this.user = resp.data
                 })
        },
        get_clouts() {
            axios.get("/get_clouts/" + this.id)
                 .then( (resp) => {
                     this.friends = resp.data
                 })
        },
    }, 
}
</script>
