import $axios from '../api.js'

const state = () => ({
    sections: [],

    section: {
        name: '',
        code: '',
        color: '',
    },
    page: 1
})

const mutations = {
    ASSIGN_DATA(state, payload) {
        state.sections = payload
    },
    SET_PAGE(state, payload) {
        state.page = payload
    },
    ASSIGN_FORM(state, payload) {
        state.section = {
            code: payload.code,
            name: payload.name,
            color: payload.color,
        }
    },
    CLEAR_FORM(state) {
        state.section = {
            name: '',
            code: '',
            color: '',
        }
    }
}

const actions = {
    getSections({ commit, state }, payload) {
        let search = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject) => {
            $axios.get(`/sections?page=${state.page}&q=${search}`)
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
    submitSection({ dispatch, commit, state }) {
        return new Promise((resolve, reject) => {
            $axios.post(`/sections`, state.section)
            .then((response) => {
                dispatch('getSections').then(() => {
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
    updateSection({ state, commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.put(`/sections/${payload}`, state.section)
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
    removeSection({ dispatch, commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.delete(`/sections/${payload}`)
            .then((response) => {
                commit('SET_SNACKBAR', { message: 'Data berhasil dihapus', type: 'success' }, { root: true });
                dispatch('getSections').then(() => resolve())
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
    }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}