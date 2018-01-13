<template>
    <nav class="navbar navbar-white navbar-fixed-top" style="height:50px;">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#" @click.prevent="goto('home')">
                    <img class="img-circle app-logo" :src="logo">
                </a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right" style="margin-top:-10px;">
                    <li>
                        <a href="#" title="Profile" @click.prevent="goto('profile/' + profile)">
                            Profile
                        </a>
                    </li>
                    <li>
                        <a href="#" title="Notifications">
                            <i class="fa fa-bell"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#" title="Clout Requests" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-user-plus"></i>
                            <span class="label label-info pull-right r-activity">
                                5
                            </span>
                        </a>
                        <ul class="dropdown-menu" style="width: 320px;background-color:whitesmoke">
                            
                        </ul>
                    </li>
                    <li>
                        <a href="#" @click.prevent="logout" title="Sign out">
                            <i class="fa fa-sign-out"></i>
                        </a>
                        <form id="logout-form" action="goto('logout')" method="POST" style="display: none;">
                            
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    props: [
        'url', 'logo'
    ],
    mounted() {
        console.log(this.url)
    }, 
    data() {
        return {
            profile: this.$store.state.auth_user.username ? this.$store.state.auth_user.username : ''
        }
    }, 
    methods: {
        goto(param) {
            return this.url +  param
        }, 
        logout() {
            document.getElementById('logout-form').submit();
        }
    }
}
</script>

<style>
    .app-logo {
        width:40px;
        height:40px;
        margin-top:-20px;
    }
</style>
