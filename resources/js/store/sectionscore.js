import $axios from '../api.js'

const state = () => ({
    sections: [],

    month: 1,
})

const mutations = {
    ASSIGN_DATA(state, payload) {
        state.sections = payload
    },
    SET_MONTH(state, payload) {
        state.month = payload
    },
}

const actions = {
    getSectionScores({ commit, state }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/sectionscore?month=${state.month}`)
            .then((response) => {
                commit('ASSIGN_DATA', response.data)
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
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}