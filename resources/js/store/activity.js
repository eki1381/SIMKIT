import $axios from '../api.js'

const state = () => ({
    activities: [],

    activity: {
        code: '',
        name: '',
        volumeUnit: '',
        timeUnit: '',
        section_id: '',
    },
    page: 1,
})

const mutations = {
    ASSIGN_DATA(state, payload) {
        state.activities = payload
    },
    SET_PAGE(state, payload) {
        state.page = payload
    },
    ASSIGN_FORM(state, payload) {
        state.activity = {
            code: payload.code,
            name: payload.name,
            volumeUnit: payload.volumeUnit,
            timeUnit: payload.timeUnit,
            section_id: payload.section_id,
        }
    },
    CLEAR_FORM(state) {
        state.activity = {
            code: '',
            name: '',
            volumeUnit: '',
            timeUnit: '',
            section_id: '',
        }
    }
}

const actions = {
    getActivities({ commit, state }, payload) {
        let search = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject) => {
            $axios.get(`/activities?page=${state.page}&q=${search}`)
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
    getActivitiesBySection({ state, commit }, payload){
        let sectionId = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject) => {
            $axios.get(`/activities/${sectionId}`)
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
    submitActivity({ dispatch, commit, state }) {
        return new Promise((resolve, reject) => {
            $axios.post(`/activities`, state.activity)
            .then((response) => {
                dispatch('getActivities').then(() => {
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
    updateActivity({ state, commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.put(`/activities/${payload}`, state.activity)
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
    removeActivity({ dispatch, commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.delete(`/activities/${payload}`)
            .then((response) => {
                commit('SET_SNACKBAR', { message: 'Data berhasil dihapus', type: 'success' }, { root: true });
                dispatch('getActivities').then(() => resolve())
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