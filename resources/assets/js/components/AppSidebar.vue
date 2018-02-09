<template>
    <div>
        <div class="profile-nav">
            <div class="widget">
                <div class="widget-body">
                    <div class="user-heading" style="height:230px;">
                        <a v-bind:href="'/profile/' + profile_username" style="color:white">
                            <img :src="profile_avatar" :alt="profile_username">
                        </a>
                        <h4>
                            <a v-bind:href="'/profile/' + profile_username" style="color:white">
                                {{ profile_username }}
                            </a>
                        </h4>
                        <p>
                            <span>
                                <a v-bind:href="'/profile/' + profile_username" style="color:white">
                                    @{{ profile_username }}
                                </a>
                            </span>
                        </p>
                    </div>

                    <ul class="nav nav-pills nav-stacked">

                    <!-- End Attach only if role is 1-->


                        <li :class="isActive('home')">
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
                        <li :class="isActive('messaging')">
                            <a href="/messaging"> 
                            <i class="fa fa-envelope"></i> Messages 
                            <span class="label label-info pull-right r-activity">9</span>
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

                        <!-- Attach only if role is 9
                        <li>
                            <a href="{{url('admin')}}/dashboard">
                            <i class="fa fa-dashboard"></i> Admin
                            </a>
                        </li>
                        End Attach only if role is 9-->

                    </ul>
                </div>
            </div>

            <!-- End Attach only if role is 2
            <div class="widget">
                <div class="widget-body">
                    <ul class="nav nav-pills nav-stacked">
                        <li>
                            <a href="{{url('press/')}}"> 
                                <i class="fa fa-globe"></i> Press release
                            </a>
                        </li>
                        <li>
                            <a href="{{url('speeches/')}}"> 
                                <i class="fa fa-gamepad"></i> Speeches
                            </a>
                        </li>
                        
                        <li>
                            <a href="{{url('interviews/')}}"> 
                                <i class="fa fa-puzzle-piece"></i> Interviews
                            </a>
                        </li>
                        <li>
                            <a href="{{url('budget/')}}"> 
                                <i class="fa fa-home"></i> Budget
                            </a>
                        </li>
                        <li>
                            <a href="{{url('mda/')}}"> 
                                <i class="fa fa-home"></i> MDAs
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            End Attach only if role is 2-->
        </div>
    </div>
</template>


<script>
    export default {
        props: [
            'url', 'profile_username', 'profile_name', 'profile_avatar'
        ],
        mounted() {
            this.clouts_total()
            this.clout_photo_total()
            this.isActive(window.location.href)
        }, 
        data() {
            return {
                clouts: 0,
                photos: 0,
                active: '',
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
                     }) 
            }, 
            clout_photo_total() {
                axios.get('/clout/photo-total')
                     .then( (resp) => {
                         this.photos = resp.data
                     })
            },
            clout_message_total() {
                
            },
            isActive(param) {
                console.log("Called to Check url")
                var url = window.location.href
                var part = url.split("/")
                console.log("Logging part...")
                console.log(part)
            }
        }, 
        computed: {
            
        }
    }
</script>