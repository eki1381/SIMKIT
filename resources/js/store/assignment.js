import $axios from '../api.js'

const state = () => ({
    assignments: [],

    processings: [],

    assignment: {
        name: '',
        volume: '',
        start_date: '',
        finish_date: '',
        collect_date: '',
        is_finished: '',
        realization: '',
        file: null,
        activity_id: '',
        user_from_id: '',
        user_to_id: '',
        section_id: '',
    },

    upload: {
        realization: '',
        comment: '',
        file: null,
    },

    is_finished: '',

    page: 1
})

const mutations = {
    ASSIGN_DATA(state, payload) {
        state.assignments = payload
    },
    CLEAR_DATA() {
        state.assignments = []
    },
    ASSIGN_PROCESSING(state, payload) {
        state.processings = payload
    },
    SET_PAGE(state, payload) {
        state.page = payload
    },
    ASSIGN_FORM(state, payload) {
        state.assignment = {
            name: payload.name,
            volume: payload.volume,
            start_date: payload.start_date,
            finish_date: payload.finish_date,
            is_finished: payload.is_finished,
            activity_id: payload.activity_id,
            user_from_id: payload.user_from_id,
            user_to_id: payload.user_to_id,
            section_id: payload.section_id,
        }
    },
    CLEAR_FORM(state) {
        state.assignment = {
            name: '',
            volume: '',
            start_date: '',
            finish_date: '',
            is_finished: '',
            activity_id: '',
            user_from_id: '',
            user_to_id: '',
            section_id: '',
        }
    },
    ASSIGN_UPLOAD(state,payload){
        state.upload = {
            realization: payload.realization,
            file: payload.file,
            collect_date: payload.collect_date,
            comment: payload.comment
        }
    },
    ASSIGN_STATUS(state,payload){
        state.is_finished = payload
    },
    CLEAR_UPLOAD(state,payload){
        state.upload = {
            realization: '',
            file: '',
            collect_date: '',
            comment: '',
        }
    },
    CLEAR_STATUS(state,payload){
        state.file = null
    },
}

const actions = {
    getAssignmentsByUserFrom({ commit, state }, payload) {
        let search = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject) => {
            $axios.get(`/assignments?p=${search}`)
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

    getAssignmentsByUserTo({ commit, state }, payload) {
        let search = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject) => {
            $axios.get(`/assignments?q=${search}`)
            .then((response) => {
                commit('ASSIGN_PROCESSING', response.data)
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
    
    submitAssignment({ commit, state }) {
        return new Promise((resolve, reject) => {
            $axios.post(`/assignments`, state.assignment)
            .then((response) => {
                resolve(response.data)
                commit('SET_SNACKBAR', { message: 'Data berhasil disimpan', type: 'success' }, { root: true })
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
    updateAssignment({ state, commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.put(`/assignments/${payload}`, state.assignment)
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
    removeAssignment({ dispatch, commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.delete(`/assignments/${payload}`)
            .then((response) => {
                commit('SET_SNACKBAR', { message: 'Data berhasil dihapus', type: 'success' }, { root: true });
                resolve();
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
    upload({ state, commit }, payload) {
        return new Promise((resolve, reject) => {
            let formData = new FormData()
            formData.append('realization', state.upload.realization);
            formData.append('comment', state.upload.comment);
            formData.append('file', state.upload.file);
            formData.append('collect_date', state.upload.collect_date);
            $axios.post(`/upload/${payload}`, formData)
            .then((response) => {
                commit('SET_SNACKBAR', { message: 'Hore! Unggah berhasil', type: 'success' }, { root: true });
                resolve(response.data)
            })
            .catch((error) => {
                if (error.response.status == 422) {
                    commit('SET_ERRORS', error.response.data.errors, { root: true });
                    resolve();
                }
                if (error.response.status == 504) {
                    commit('SET_ERRORS', error.response.data.errors, { root: true });
                    commit('SET_SNACKBAR', { message: 'Ouch! File yang anda unggah rusak, silakan unggah lagi', type: 'error' }, { root: true });
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
    updateStatus({ state, commit }, payload) {
        return new Promise((resolve, reject) => {
            let formData = new FormData();
            formData.append('is_finished', state.is_finished);
            $axios.post(`/update-status/${payload}`, formData)
            .then((response) => {
                commit('SET_SNACKBAR', { message: 'Update status berhasil', type: 'success' }, { root: true });
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
    download({commit}, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/assignments/download?id=${payload}`, { responseType: 'blob' })
            .then( res => {
                let blob = new Blob([res.data], { type:'application/pdf' })
                let link = document.createElement('a')
                link.href = window.URL.createObjectURL(blob)
                link.download = 'Bukti.pdf'
                link.click()
                resolve()
            })
        }).catch((error) => {
            
        })
    },
    countPerson({ state, commit }){
        return new Promise((resolve, reject) => {
            $axios.post(`/count-person`)
            .then((response) => {
                resolve(response.data)
            })
            .catch((error) => {
                resolve(error)
            })
        })
    },
    countSection({ state, commit }){
        return new Promise((resolve, reject) => {
            $axios.post(`/count-section`)
            .then((response) => {
                resolve(response.data)
            })
            .catch((error) => {
                resolve(error)
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