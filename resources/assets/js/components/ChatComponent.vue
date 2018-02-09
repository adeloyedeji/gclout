<template>
    <div>
        <div class="col-md-4 bg-white">
            <div class="row border-bottom padding-sm" style="height: 40px;">
            </div>
            <ul class="friend-list">
                <li class="active animated bounceInDown" v-for="clout in clouts">
                    <a href="javascript:void(0)" class="clearfix" target="_blank">
                        <img :src="clout.avatar" alt="" class="img-circle msg-frnd" style="margin-right:20px;">
                        <div class="friend-name"> 
                            <strong>{{ clout.name }}</strong>
                        </div>
                        <div class="last-message text-muted msg-frnd">
                            <i class="fa fa-check-circle connected-status text text-success"></i> Online
                        </div>
                    </a>
                </li>
            </ul>
        </div>

        <div class="col-md-8 bg-white ">
	        <div class="chat-message" style="max-height: 600px;overflow-y:auto ">
                <ul class="chat" id="chat-ul">
                               
                    <li class="left clearfix">
                        <span class="chat-img pull-left">
                            <img :src="image" alt="User Avatar">
                        </span>
                        <div class="chat-body clearfix">
                            <div class="header">
                                <strong class="primary-font">{{ name }}</strong>
                                <small class="pull-right text-muted"><i class="fa fa-clock-o"></i> Just now</small>
                            </div>
                            <p>
                                Select a clout to chat with
                            </p>
                        </div>
                    </li>                    
                </ul>
            </div>
            <div class="chat-box_ bg-white">
                <div class="input-group">
            	    <input class="form-control border no-shadow no-rounded" placeholder="Type your message here" id="chat_message">
                    <span class="input-group-btn">
                        <button class="btn btn-success no-rounded" type="button">Send</button>
                    </span>
                </div><!-- /input-group --> 
            </div>            
        </div>
    </div>
</template>

<script>
export default {
    props: ['user_id'],
    data() {
        return {
            clouts: [],
            image: '',
            name: '',
            username: '',
        }
    },
    mounted() {
        this.get_clouts()
        this.get_auth_user_data()
    }, 
    methods: {
        get_clouts() {
            axios.get("/get_clouts/" + this.user_id)
                 .then( (resp) => {
                     this.clouts = resp.data
                 })
        },
        get_auth_user_data() {
            axios.get('/get_auth_user_data')
                .then( (resp) => {
                    this.image = resp.data.avatar
                    this.name = resp.data.name
                    this.username = resp.data.username
                } )
        },
    }
}
</script>
