import $axios from '../api.js'

const state = () => ({
    sections: [],
    assignments: [],
})

const mutations = {
    ASSIGN_SECTIONS(state, payload) {
        state.sections = payload
    },
    CLEAR_SECTIONS(state) {
        state.sections = []
    },
    ASSIGN_ASSIGNMENTS(state, payload) {
        state.assignments = payload
    },
    CLEAR_ASSIGNMENTS(state) {
        state.assignments = []
    },
}

const actions = {
    getSections({ commit }){
        return new Promise((resolve, reject) => {
            $axios.get(`/monitoring`)
            .then((response) => {
                commit('ASSIGN_SECTIONS', response.data)
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

    getAssignments({ commit }, payload){
        return new Promise((resolve, reject) => {
            $axios.get(`/monitoring/assignments?sectionid=${payload}`)
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
    }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}