
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.Noty = require('Noty');
window.Moment = require('moment');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('post', require('./components/Post.vue'));

Vue.component('feed', require('./components/Feed.vue'));

Vue.component('init', require('./components/Init.vue'));

Vue.component('photos', require('./components/Photo.vue'));

Vue.component('friend', require('./components/Friend.vue'));

Vue.component('search', require('./components/Search.vue'));

Vue.component('profile', require('./components/Profile.vue'));

Vue.component('navigation', require('./components/Navigation.vue'));

Vue.component('appsidebar', require('./components/AppSidebar.vue'));

Vue.component('friends-list', require('./components/FriendList.vue'));

Vue.component('profile-edit', require('./components/ProfileEdit.vue'));

Vue.component('unread', require('./components/UnreadNotification.vue'));

Vue.component('notification', require('./components/Notification.vue'));

Vue.component('post-comment', require('./components/PostComponent.vue'));

Vue.component('profile-setup', require('./components/ProfileSetup.vue'));

Vue.component('change-cover', require('./components/ChangeCover.vue'));

Vue.component('change-avatar', require('./components/ChangeAvatar.vue'));

Vue.component('activity-feed', require('./components/ActivityFeed.vue'));

Vue.component('friend-status', require('./components/FriendStatus.vue'));

Vue.component('people-you-may-know', require('./components/YouMayKnow.vue'));

import { store } from './store'

const app = new Vue({
    el: '#app', 
    store
});

