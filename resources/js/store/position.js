import $axios from '../api.js'

const state = () => ({
    positions: [],

    results: [],

    position: {
        name: '',
        code: '',
        section_id: '',
        type: '',
    },

    position_id: '',

    page: 1
})

const mutations = {
    ASSIGN_DATA(state, payload) {
        state.positions = payload
    },
    ASSIGN_RESULT(state, payload) {
        state.results = payload
    },
    SET_PAGE(state, payload) {
        state.page = payload
    },
    SET_POSITION_ID(state, payload) {
        state.position_id = payload
    },
    ASSIGN_FORM(state, payload) {
        state.position = {
            name: payload.name,
            code: payload.code,
            section_id: payload.section,
            type: payload.type,
        }
    },
    CLEAR_FORM(state) {
        state.position = {
            name: '',
            code: '',
            section_id: '',
            type: '',
        }
    },
}

const actions = {
    getPositions({ commit, state }, payload) {
        let search = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject) => {
            $axios.get(`/positions?page=${state.page}&q=${search}`)
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
    submitPosition({ dispatch, commit, state }) {
        return new Promise((resolve, reject) => {
            $axios.post(`/positions`, state.position)
            .then((response) => {
                dispatch('getPositions').then(() => {
                    resolve(response.data)
                    commit('SET_SNACKBAR', { message: 'Data berhasil disimpan', type: 'success' }, { root: true });
                })
            })
            .catch((error) => {
                if (error.response.status == 422) {
                    commit('SET_ERRORS', error.response.data.errors, { root: true });
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
    updatePosition({ state, commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.put(`/positions/${payload}`, state.position)
            .then((response) => {
                commit('CLEAR_FORM')
                commit('SET_SNACKBAR', { message: 'Data berhasil disimpan', type: 'success' }, { root: true });
                resolve(response.data)
            })
            .catch((error) => {
                if (error.response.status == 422) {
                    commit('SET_ERRORS', error.response.data.errors, { root: true });
                    resolve();
                }
                if (error.response.status == 401) {
                    localStorage.removeItem('token');
                    $router.go('/login');
                    commit('SET_SNACKBAR', { message: 'Session anda sudah habis', type: 'error' }, { root: true });
                }
            })
        })
    } ,
    removePosition({ dispatch, commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.delete(`/positions/${payload}`)
            .then((response) => {
                commit('SET_SNACKBAR', { message: 'Data berhasil dihapus', type: 'success' }, { root: true });
                dispatch('getPositions').then(() => resolve())
            })
            .catch((error) => {
                if (error.response.status == 500) {
                    commit('SET_SNACKBAR', { message: 'Data gagal dihapus karena masih digunakan oleh entitas lain', type: 'error' }, { root: true });
                    commit('SET_ERRORS', error.response.data.errors, { root: true });
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
    getPositionById({ commit, state }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/positions?id=${state.position_id}`)
            .then((response) => {
                commit('ASSIGN_RESULT', response.data)
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