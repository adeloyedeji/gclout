import Vuex from 'vuex'
import Vue from 'vue'

Vue.use(Vuex)

export const store = new Vuex.Store({
    state: {
        notifications: [], 
        posts: [], 
        press: [],
        speech: [],
        petitions: [],
        auth_user: {},
        active_users: [],
        content: '',
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
        all_press(state) {
            return state.press
        },
        all_speech(state) {
            return state.speech
        },
        all_petitions(state) {
            return state.petitions
        },
        get_auth_user_data(state) {
            return state.auth_user
        }, 
        all_active_user(state) {
            return state.active_users
        }, 
        get_content(state) {
            return state.content
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
        update_press(state, press) {
            state.press.unshift(press);
        },
        add_press(state, press) {
            state.press.push(press)
        },
        update_press_photos(state, payLoad) {
            var press = state.press.find( (p) => {
                return p.id === payLoad.id
            })
            press.photos.push(payLoad.photo)
        },
        update_press_likes(state, payLoad) {
            var press = state.press.find( (p) => {
                return p.id === payLoad.id
            })
            press.likes.push(payLoad.like)
        },
        unlike_press_like(state, payLoad) {
            var press = state.press.find( (p) => {
                return p.id === payLoad.id
            })

            var like = press.likes.find( (l) => {
                return l.id === payLoad.like_id
            })

            var index = press.likes.indexOf(like)

            press.likes.splice(index, 1)
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
        },
        add_active_user(state, payLoad) {
            state.active_users.push(payLoad)
        },
        update_speech(state, speech) {
            state.speech.unshift(speech);
        },
        add_speech(state, speech) {
            state.speech.push(speech)
        },
        update_speech_photos(state, payLoad) {
            var speech = state.speech.find( (p) => {
                return p.id === payLoad.id
            })
            speech.photos.push(payLoad.photo)
        },
        update_speech_likes(state, payLoad) {
            var speech = state.speech.find( (p) => {
                return p.id === payLoad.id
            })
            speech.likes.push(payLoad.like)
        },
        unlike_speech_like(state, payLoad) {
            var speech = state.speech.find( (p) => {
                return p.id === payLoad.id
            })

            var like = speech.likes.find( (l) => {
                return l.id === payLoad.like_id
            })

            var index = speech.likes.indexOf(like)

            speech.likes.splice(index, 1)
        },
        update_content(state, content) {
            state.content = content
        },

        //petition section
        add_petition(state, petition) {
            state.petitions.push(petition)
        }, 
        update_petition(state, petition) {
            state.petitions.unshift(petition)
        }, 
        update_petition_photos(state, payLoad) {
            var petition = state.petitions.find( (p) => {
                return p.id === payLoad.id
            })
            petition.photos.push(payLoad.photo)
        },
    }, 
    actions: {

    }
})