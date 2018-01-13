import Vuex from 'vuex'
import Vue from 'vue'

Vue.use(Vuex)

export const store = new Vuex.Store({
    state: {
        notifications: [], 
        posts: [], 
        auth_user: {},
    }, 
    getters: {
        all_notifications(state) {
            return state.notifications
        }, 
        all_notifications_count(state) {
            return state.notifications.length
        }, 
        all_posts(state) {
            return state.posts
        },
        auth_user_data(state) {
            return state.auth_user
        }
    }, 
    mutations: {
        add_notification(state, notification) {
            state.notifications.push(notification)
        }, 
        add_post(state, post) {
            state.posts.push(post)
        },
        empty_post(state) {
            states.posts = []
        },
        auth_user_data(state, user) {
            state.auth_user = user
        }, 
        update_post_likes(state, payLoad) {
            var post = state.posts.find( (p) => {
                return p.id === payLoad.id
            })
            post.likes.push(payLoad.like)
        }, 
        unlike_post_like(state, payLoad) {
            var post = state.posts.find( (p) => {
                return p.id === payLoad.post_id
            })

            var like = post.likes.find( (l) => {
                return l.id === payLoad.like_id
            })
            
            var index = post.likes.indexOf(like)

            post.likes.splice(index, 1)
        },
        update_post_comments(state, payLoad) {
            var post = state.posts.find( (p) => {
                return p.id === payLoad.post_id
            })
            post.comments.push(payLoad.comments)
        }
    }, 
    actions: {

    }
})