import $axios from '../api.js'

const state = () => ({
    users: [],
    assignments: [],
    events: [],

})

const mutations = {
    ASSIGN_USERS(state, payload) {
        state.users = payload
    },
    CLEAR_USERS() {
        state.users = []
    },
    ASSIGN_ASSIGNMENTS(state, payload) {
        state.assignments = payload
    },
    CLEAR_ASSIGNMENTS() {
        state.assignments = []
    },
    ASSIGN_EVENTS(state, payload) {
        state.events = payload
    },
    CLEAR_EVENTS() {
        state.events = []
    },
}

const actions = {
    getUsers({ commit, state }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/users`)
            .then((response) => {
                commit('ASSIGN_USERS', response.data)
                resolve(response.data)
            })
            .catch((error) => {
                if (error.response.status == 401) {
                    localStorage.removeItem('token');
                    commit('SET_SNACKBAR', { message: 'Session anda sudah habis', type: 'error' }, { root: true });
                    $router.go('/login');
                }
            })
        })
    },
    getAssignmentsByUserTo({ commit, state }, payload) {
        let search = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject) => {
            $axios.get(`/assignments?q=${search}`)
            .then((response) => {
                commit('ASSIGN_ASSIGNMENTS', response.data)
                resolve(response.data)
            })
            .catch((error) => {
                if (error.response.status == 401) {
                    localStorage.removeItem('token');
                    $router.go('/login');
                    commit('SET_SNACKBAR', { message: 'Session anda sudah habis', type: 'error' }, { root: true });
                }
            })
        })
    },
    getEvents({ commit, state }){
        return new Promise((resolve, reject) => {
            const events = []
            for (let i = 0; i < state.assignments.data.length; i++) {
                const end = ''
                if(state.assignments.data[i].is_finished === "Sudah selesai"){
                    end = state.assignments.data[i].collect_date
                }else{
                    end = state.assignments.data[i].finish_date
                }

                events.push({
                    name: state.assignments.data[i].name,
                    start: state.assignments.data[i].start_date,
                    end: end,
                    color: state.assignments.data[i].section.color,
                })
            }
            commit('ASSIGN_EVENTS', events)
            resolve(events)
        })
    },
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}