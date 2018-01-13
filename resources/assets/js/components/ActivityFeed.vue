<template>
    <div>
        <div class="widget">
            <div class="widget-header">
                <h3 class="widget-caption">Activity Feed</h3>
            </div>
            <div class="widget-body bordered-top bordered-sky">
                <div class="card">
                    <div class="content">
                        <ul class="list-unstyled team-members" id="people-suggestion">
                            <div class="lds-css ng-scope" v-if="feeds.length <= 0">
                                <div style="width:200px;height:200px;" class="lds-facebook">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </div>
                            <li>
                              {{ feeds }}
                            </li>
                            <li v-for="feed in feeds">
                              <div class="row">
                                <div class="col-xs-3">
                                  <div class="avatar">
                                      <img src="http://social/public/defaults/avatars/male.jpg" alt="img" class="img-circle img-no-padding img-responsive">
                                  </div>
                                </div>
                                <div class="col-xs-9">
                                  <b><a href="#">Hillary Markston</a></b> shared a 
                                  <b><a href="#">publication</a></b>. 
                                  <span class="timeago" >5 min ago</span>
                                </div>
                              </div>
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
    data() {
        return {
          notifications: {},
        }
    },
    mounted() {
        setInterval(this.feeds, 5000)
    },
    methods: {
    },
    computed: {
        feeds() {
          console.log("Your activity feeds")
            this.notifications = this.$store.getters.all_notifications
            console.log(this.notifications)
            return this.$store.getters.all_notifications
        }
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
</style>