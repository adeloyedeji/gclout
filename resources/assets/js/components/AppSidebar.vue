<template>
    <div>
        <div class="profile-nav">
            <div class="widget">
                <div class="widget-body">
                    <div class="user-heading round" style="height:250px;">
                        <a v-bind:href="'/profile/' + profile_username" style="color:white">
                            <img :src="profile_avatar" :alt="profile_username">
                        </a>
                        <h4 class="no-round">
                            <a v-bind:href="'/profile/' + profile_username" style="color:white" id="no-round">
                                {{ profile_username }}
                            </a>
                        </h4>
                        <p class="no-round">
                            <span>
                                <a v-bind:href="'/profile/' + profile_username" style="color:white" id="no-round">
                                    @{{ profile_username }}
                                </a>
                            </span>
                        </p>
                    </div>

                    <ul class="nav nav-pills nav-stacked">

                    <!-- End Attach only if role is 1-->


                        <li>
                            <a href="/home">
                                <i class="fa fa-user"></i> News feed
                            </a>
                        </li>
                        <li>
                            <a v-bind:href="'/clouts/list/'+profile_username">
                                <i class="fa fa-users"></i> Clouts
                                <span class="label label-info pull-right r-activity">{{ clouts }}</span>
                            </a>
                        </li>
                        <li>
                            <a v-bind:href="'/photos/'+profile_username">
                                <i class="fa fa-camera"></i> Photos
                                <span class="label label-info pull-right r-activity">{{ photos }}</span>
                            </a>
                        </li>
                        <li >
                            <a href="/messaging"> 
                            <i class="fa fa-envelope"></i> Messages 
                            <!-- <span class="label label-info pull-right r-activity">9</span> -->
                            </a>
                        </li>
                        <li>
                            <a href="/movements">
                            <i class="fa fa-balance-scale"></i> Petitions
                            </a>
                        </li>
                        <li>
                            <a href="/polls">
                            <i class="fa fa-bar-chart"></i> Polls
                            </a>
                        </li>
                        <!-- End Attach only if role is 1-->

                        <!-- Attach only if role is 9 -->
                        <li v-if="role == 9">
                            <a href="/admin/dashboard">
                            <i class="fa fa-dashboard"></i> Admin
                            </a>
                        </li>
                        <!--End Attach only if role is 9-->

                    </ul>
                </div>
            </div>

            <!-- End Attach only if role is 2 -->
            <div class="widget" v-if="role >= 2">
                <div class="widget-body">
                    <ul class="nav nav-pills nav-stacked">
                        <li>
                            <a :href="'/press/' + profile_username"> 
                                <i class="fa fa-globe"></i> Press release
                            </a>
                        </li>
                        <li>
                            <a :href="'/speeches/' + profile_username"> 
                                <i class="fa fa-gamepad"></i> Speeches
                            </a>
                        </li>
                        
                        <li>
                            <a :href="'/interviews/' + profile_username"> 
                                <i class="fa fa-puzzle-piece"></i> Interviews
                            </a>
                        </li>
                        <!-- <li>
                            <a :href="'/budget/' + profile_username"> 
                                <i class="fa fa-home"></i> Budget
                            </a>
                        </li> -->
                        <li>
                            <a :href="'/mda/' + profile_username"> 
                                <i class="fa fa-home"></i> MDAs
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- End Attach only if role is 2-->
        </div>
    </div>
</template>


<script>
    export default {
        props: [
            'url', 'profile_username', 'profile_name', 'profile_avatar', 'role'
        ],
        mounted() {
            this.get_auth_user_data
            this.clouts_total()
            this.clout_photo_total()
            this.isActive(window.location.href)
        }, 
        data() {
            return {
                clouts: 0,
                photos: 0,
                active: '',
                user: [],
            }
        }, 
        methods: {
            goto(param) {
                return this.url +  param
            }, 
            clouts_total() {
                axios.get('/clouts/total')
                     .then( (resp) => {
                         this.clouts = resp.data
                     }).catch(error => {
                         window.location.reload()
                     })
            }, 
            clout_photo_total() {
                axios.get('/clout/photo-total')
                     .then( (resp) => {
                         this.photos = resp.data
                     }).catch(error => {
                         window.location.reload()
                     })
            },
            clout_message_total() {
                return 5
            },
            isActive(param) {
                var url = window.location.href
                var part = url.split("/")
            },
        }, 
        computed: {
            get_auth_user_data() {
                // axios.get('/get_auth_user_data')
                //     .then( (resp) => {
                //         this.user = resp.data
                //     } ).catch(error => {
                //         window.location.reload()
                //     });
                this.user = this.$store.getters.get_auth_user_data
                return this.$store.getters.get_auth_user_data
            },
        }
    }
</script>

<style>
/* .profile-nav .user-heading.round a {
    border-radius: 0%;
    -webkit-border-radius: 0%;
    border: 10px solid rgba(255, 255, 255, 0.3);
    display: inline-block;
} */
.round h4  {
    border-radius: 0%;
    -webkit-border-radius: 0%;
    display: inline-block; 
}
.round h4 > a {
    border-radius: 0%;
    -webkit-border-radius: 0%;
    display: inline-block; 
}
.no-round #no-round {
    border-radius: 0%;
    -webkit-border-radius: 0%;
    border: 1px solid #2dc3e8;
    display: inline-block; 
    background-color: #2dc3e8;
}
</style>
