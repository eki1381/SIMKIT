import $axios from '../api.js'

const state = () => ({
    reg_token: '',
    dashboard: [],
})

const mutations = {
    ASSIGN_REG_TOKEN(state, payload) {
        state.reg_token = payload
    },
    CLEAR_REG_TOKEN() {
        state.reg_token = ''
    },
    ASSIGN_DASHBOARD(state, payload) {
        state.dashboard = payload
    },
    CLEAR_DASHBOARD() {
        state.dashboard = []
    },
}

const actions = {
    storeRegToken({ state, commit }, payload) {
        return new Promise((resolve, reject) => {
            let formData = new FormData();
            formData.append('reg_token', payload);
            $axios.post(`/storeregtoken`, formData)
            .then((response) => {
                resolve(response.data)
            })
            .catch((error) => {
                if (error.response.status == 422) {
                    commit('SET_ERRORS', error.response.data.errors, { root: true });
                    resolve();
                }
                if (error.response.status == 500) {
                    commit('SET_ERRORS', error.response.data.errors, { root: true });
                    commit('SET_SNACKBAR', { message: 'Oops! Terjadi kesalahan teknis', type: 'error' }, { root: true });
                    resolve();
                }
                if (error.response.status == 401) {
                    localStorage.removeItem('token');
                    $router.go('/login');
                    commit('SET_SNACKBAR', { message: 'Session anda sudah habis', type: 'error' }, { root: true });
                }
            })
        })
    },
    getHome({ commit }, payload){
        return new Promise((resolve, reject) => {
            $axios.get(`/home?month=${payload}`)
            .then((response) => {
                commit('ASSIGN_DASHBOARD', response.data)
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
