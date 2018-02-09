<template>
    <div>
        <div class="profile-nav">
            <div class="widget">
                <div class="widget-header">
                    <h3 class="widget-caption">Extras</h3>
                </div>
                <div class="widget-body bordered-top bordered-sky">
                    <ul class="nav nav-pills nav-stacked" v-if="user.profile.role >= 1">
                        <li>
                            <a href="#" class="button" data-toggle="modal" data-target="#myModal">
                                <i class="fa fa-plus"></i> Create
                                <span v-if="current_loc == 'movements'">Petition</span> 
                                <span v-else>Poll</span>
                            </a>
                        </li>
                        <li><a :href="'/' + current_loc + '/categories?sector=Economy'"><i class="fa fa-envelope"></i> Economy</a></li>
                        <li><a :href="'/' + current_loc + '/categories?sector=Political'"><i class="fa fa-balance-scale"></i> Politcs</a></li>
                        <li><a :href="'/' + current_loc + '/categories?sector=Education'"><i class="fa fa-book"></i> Education</a></li>
                        <li><a :href="'/' + current_loc + '/categories?sector=Technology'"><i class="fa fa-gear"></i> Technology</a></li>
                        <li><a :href="'/' + current_loc + '/categories?sector=Power'"><i class="fa fa-bolt"></i> Power</a></li>
                        <li><a :href="'/' + current_loc + '/categories?sector=Corruption'"><i class="fa fa-frown-o"></i> Corruption</a></li>
                        <li><a :href="'/' + current_loc + '/categories?sector=Religion'"><i class="fa fa-university"></i> Religion</a></li>
                        <li><a :href="'/' + current_loc + '/categories?sector=Sports'"><i class="fa fa-futbol-o"></i> Sports</a></li>
                        <li><a :href="'/' + current_loc + '/categories?sector=Entertainment'"><i class="fa fa-gamepad"></i> Entertainment</a></li>
                        <li><a :href="'/' + current_loc + '/categories?sector=Security'"><i class="fa fa-key"></i> Security</a></li>
                        <li><a :href="'/' + current_loc + '/categories?sector=Foreign Relations'"><i class="fa fa-language"></i> Foreign Relations</a></li>
                        <li><a :href="'/' + current_loc + '/categories?sector=Justice'"><i class="fa fa-legal"></i> Justice</a></li>
                        <li><a :href="'/' + current_loc + '/categories?sector=Agriculture'"><i class="fa fa-building"></i> Agriculture</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'current_loc'
    ],
    data() {
        return {
            user: [],
        }
    },
    mounted() {
        this.get_auth_user_data()
    }, 
    methods: {
        get_auth_user_data() {
            axios.get('/get_auth_user_data')
                .then( (resp) => {
                    this.user = resp.data
                } )
        },
    }
}
</script>
