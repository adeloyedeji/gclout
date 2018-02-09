<template>
    <div>
        <div class="widget">
            <div class="widget-header">
                <h3 class="widget-caption">People You May Know</h3>
                <!-- <a style="margin-top:1.5em;margin-right:1.5em;padding-top:20px" title="Refresh list" @click="get_people_you_may_know"><i class="fa fa-refresh"></i></a> -->
            </div>
            <div class="widget-body bordered-top bordered-sky">
                <div class="card">
                    <div class="content">
                        <ul class="list-unstyled team-members" id="people-suggestion">
                            <div class="lds-css ng-scope" v-if="clouts_suggestions.length <= 0">
                                <div style="width:200px;height:200px;" class="lds-facebook">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </div>
                            <li v-for="clout in clouts_suggestions">
                                <div class='row'>
                                    <div class='col-xs-3'>
                                        <div class='activity'>
                                            <img class='img-circle img-no-padding img-responsive' :alt="clout.name" :src="clout.avatar">
                                        </div>
                                    </div>
                                    <div class='col-xs-6'>{{ clout.name }}</div>
                                    <div class='col-xs-3 text-right' id='add_friend_id'>
                                        <button class='btn btn-sm btn-azure btn-icon' title='Add Clout' :disabled="btn_disabled" @click="add_friend(clout.id)">
                                            <i class='fa fa-user-plus'></i>
                                        </button>		
                                    </div>					
                                </div>
                            </li>
                            <!--
                            <li v-if="clouts_suggestions.length <= 0">
                                <div class='row'>
                                    <div class='col-xs-12'>
                                        <div class='activity'>
                                            You're quite popular! We couldn't any friend suggestions for you. 
                                            <p>
                                                Seems like you've exhausted our friends list :-)
                                            </p>
                                        </div>
                                    </div>					
                                </div>
                            </li>
                            -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            clouts_suggestions: [],
            btn_disabled: false,
            suggestions_loading: true,
        }
    }, 
    mounted() {
        this.get_people_you_may_know()
    }, 
    methods: {
        get_people_you_may_know() {
            this.suggestions_loading = true;
            axios.get('/get_friend_suggestions')
                 .then( (resp) => {
                     this.clouts_suggestions = resp.data
                 } )
            this.suggestions_loading = false;
        },
        add_friend(id) {
            this.btn_disabled = true
            axios.get('/add_friend/' + id)
                    .then( (response) => {
                        if(response.data == 1) {
                            //this.status = 'waiting'
                            new Noty({
                                type: 'success',
                                layout: 'bottomLeft',
                                text: 'Friend request sent.'
                            }).show();
                            this.get_people_you_may_know()
                            this.btn_disabled = false
                        }
                    } );
            this.btn_disabled = false
        },
    }, 
    computed: {
        
    }
}
</script>

<style type="text/css">@keyframes lds-facebook_1 {
  0% {
    top: 36px;
    height: 128px;
  }
  50% {
    top: 60px;
    height: 80px;
  }
  100% {
    top: 60px;
    height: 80px;
  }
}
@-webkit-keyframes lds-facebook_1 {
  0% {
    top: 36px;
    height: 128px;
  }
  50% {
    top: 60px;
    height: 80px;
  }
  100% {
    top: 60px;
    height: 80px;
  }
}
@keyframes lds-facebook_2 {
  0% {
    top: 41.99999999999999px;
    height: 116.00000000000001px;
  }
  50% {
    top: 60px;
    height: 80px;
  }
  100% {
    top: 60px;
    height: 80px;
  }
}
@-webkit-keyframes lds-facebook_2 {
  0% {
    top: 41.99999999999999px;
    height: 116.00000000000001px;
  }
  50% {
    top: 60px;
    height: 80px;
  }
  100% {
    top: 60px;
    height: 80px;
  }
}
@keyframes lds-facebook_3 {
  0% {
    top: 48px;
    height: 104px;
  }
  50% {
    top: 60px;
    height: 80px;
  }
  100% {
    top: 60px;
    height: 80px;
  }
}
@-webkit-keyframes lds-facebook_3 {
  0% {
    top: 48px;
    height: 104px;
  }
  50% {
    top: 60px;
    height: 80px;
  }
  100% {
    top: 60px;
    height: 80px;
  }
}
.lds-facebook {
  position: relative;
}
.lds-facebook div {
  position: absolute;
  width: 30px;
}
.lds-facebook div:nth-child(1) {
  left: 35px;
  background: #47639e;
  -webkit-animation: lds-facebook_1 1s cubic-bezier(0, 0.5, 0.5, 1) infinite;
  animation: lds-facebook_1 1s cubic-bezier(0, 0.5, 0.5, 1) infinite;
  -webkit-animation-delay: -0.2s;
  animation-delay: -0.2s;
}
.lds-facebook div:nth-child(2) {
  left: 85px;
  background: #4267b2;
  -webkit-animation: lds-facebook_2 1s cubic-bezier(0, 0.5, 0.5, 1) infinite;
  animation: lds-facebook_2 1s cubic-bezier(0, 0.5, 0.5, 1) infinite;
  -webkit-animation-delay: -0.1s;
  animation-delay: -0.1s;
}
.lds-facebook div:nth-child(3) {
  left: 135px;
  background: #4b70bb;
  -webkit-animation: lds-facebook_3 1s cubic-bezier(0, 0.5, 0.5, 1) infinite;
  animation: lds-facebook_3 1s cubic-bezier(0, 0.5, 0.5, 1) infinite;
}
.lds-facebook {
  width: 145px !important;
  height: 145px !important;
  -webkit-transform: translate(-72.5px, -72.5px) scale(0.725) translate(72.5px, 72.5px);
  transform: translate(-72.5px, -72.5px) scale(0.725) translate(72.5px, 72.5px);
}
.ref-list {
    margin-top: .5em;
}
</style>