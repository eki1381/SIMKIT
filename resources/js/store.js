import Vue from 'vue';
import Vuex from 'vuex';
import auth from './store/auth.js';
import home from './store/home.js';
import section from './store/section.js';
import position from './store/position.js';
import user from './store/user.js';
import activity from './store/activity.js';
import assignment from './store/assignment.js';
import personscore from './store/personscore.js';
import sectionscore from './store/sectionscore.js';
import calendar from './store/calendar.js';
import recapitulation from './store/recapitulation.js';
import monitoring from './store/monitoring.js';
import notification from './store/notification.js';

Vue.use(Vuex);

const store = new Vuex.Store({
    modules: {auth, home, section, position, user, activity, assignment, personscore, sectionscore, calendar, recapitulation, monitoring, notification},
    state: {
        token: localStorage.getItem('token'),
        errors: [],
        snackbar: {
            message: '',
            type: '',
        },
        vsnackbar: [],
        progressbar: false,
    },
    getters: {
        isAuth: state => {
            return state.token != "null" && state.token != null;
        }
    },
    mutations: {
        SET_TOKEN(state, payload){
            state.token = payload
        },
        SET_ERRORS(state, payload){
            state.errors = payload
        },
        CLEAR_ERRORS(state){
            state.errors = []
        },
        SET_SNACKBAR(state, payload){
            state.snackbar = payload
        },
        CLEAR_SNACKBAR(state){
            state.snackbar = {
                message: '',
                type: '',
            };
        },
        SET_VSNACKBAR(state, payload){
            state.vsnackbar.push({
                title: payload.title,
                body: payload.body,
            })
        },
        CLEAR_VSNACKBAR(state){
            state.vsnackbar = []
        },
        SET_PROGRESSBAR(state, payload){
            state.progressbar = payload
        },
    }
})

export default store;