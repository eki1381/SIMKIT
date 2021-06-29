import $axios from '../api.js'

const state = () => ({
    loas: [],

    loa: {
        number: '',
        purpose: '',
        destination: '',
        section: '',
        position: '',
        start_date: '',
        finish_date: '',
        sign_date: '',
        user_id: '',
        section_id: '',
        position_id: '',
        sign_id: '',
    },
    page: 1
})

const mutations = {
    ASSIGN_DATA(state, payload) {
        state.loas = payload
    },
    SET_PAGE(state, payload) {
        state.page = payload
    },
    ASSIGN_FORM(state, payload) {
        state.loa = {
            number: payload.number,
            purpose: payload.purpose,
            destination: payload.destination,
            section: payload.section,
            position: payload.position,
            start_date: payload.start_date,
            finish_date: payload.finish_date,
            sign_date: payload.sign_date,
            user_id: payload.user_id,
            section_id: payload.section_id,
            position_id: payload.position_id,
            sign_id: payload.sign_id,
        }
    },
    CLEAR_FORM(state) {
        state.loa = {
            number: '',
            purpose: '',
            destination: '',
            section: '',
            position: '',
            start_date: '',
            finish_date: '',
            sign_date: '',
            user_id: '',
            section_id: '',
            position_id: '',
            sign_id: '',
        }
    }
}

const actions = {
    getLoas({ commit, state }, payload) {
        let search = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject) => {
            $axios.get(`/loas?page=${state.page}&q=${search}`)
            .then((response) => {
                commit('ASSIGN_DATA', response.data)
                resolve(response.data)
            })
            .catch((error) => {
                if (error.response.status == 401) {

                }
            })
        })
    },
    submitLoa({ dispatch, commit, state }) {
        return new Promise((resolve, reject) => {
            $axios.post(`/loas`, state.loa)
            .then((response) => {
                dispatch('getLoas').then(() => {
                    resolve(response.data)
                    commit('SET_SNACKBAR', { message: 'Data berhasil disimpan', type: 'success' }, { root: true });
                })
            })
            .catch((error) => {
                if (error.response.status == 422) {
                    commit('SET_ERRORS', error.response.data.errors, { root: true });
                    resolve();
                }
            })
        })
    },
    updateLoa({ state, commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.put(`/loas/${payload}`, state.loa)
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
            })
        })
    } ,
    removeLoa({ dispatch, commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.delete(`/loas/${payload}`)
            .then((response) => {
                commit('SET_SNACKBAR', { message: 'Data berhasil dihapus', type: 'success' }, { root: true });
                dispatch('getLoas').then(() => resolve())
            })
            .catch((error) => {
                if (error.response.status == 500) {
                    commit('SET_SNACKBAR', { message: 'Data gagal dihapus karena masih digunakan oleh entitas lain', type: 'error' }, { root: true });
                    commit('SET_ERRORS', error.response.data.errors, { root: true });
                    resolve();
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