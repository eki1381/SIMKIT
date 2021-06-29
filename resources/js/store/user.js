import $axios from '../api.js'
import $router from '../router.js'

const state = () => ({
    users: [],

    user: {
        name: '',
        email: '',
        password: '',
        ein: '',
        position_id: '',
        section_id: '',
        photo: '',
    },

    roles: [],
    permissions: [],
    role_permission: [],
    authenticated: [],

    page: 1
})

const getters = {
    isEchelon3: state => {
        return state.authenticated.position.type == "1";
    },
    isEchelon4: state => {
        return state.authenticated.position.type == "2";
    },
    isStaff: state => {
        return state.authenticated.position.type == "3";
    }
}

const mutations = {
    ASSIGN_DATA(state, payload) {
        state.users = payload
    },
    SET_PAGE(state, payload) {
        state.page = payload
    },
    ASSIGN_FORM(state, payload) {
        state.user = {
            name: payload.name,
            email: payload.email,
            password: payload.password,
            ein: payload.ein,
            position_id: payload.position_id,
            section_id: payload.section_id,
            photo: payload.photo,
        }
    },
    CLEAR_FORM(state) {
        state.user = {
            name: '',
            email: '',
            password: '',
            ein: '',
            position_id: '',
            section_id: '',
            photo: '',
        }
    },
    ASSIGN_ROLES(state, payload) {
        state.roles = payload
    },
    ASSIGN_PERMISSION(state, payload) {
        state.permissions = payload
    },
    ASSIGN_ROLE_PERMISSION(state, payload) {
        state.role_permission = payload
    },
    CLEAR_ROLE_PERMISSION(state) {
        state.role_permission = []
    },
    ASSIGN_USER_AUTH(state, payload) {
        state.authenticated = payload
    },
}

const actions = {
    getUsers({ commit, state }, payload) {
        let search = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject) => {
            $axios.get(`/users?page=${state.page}&q=${search}`)
            .then((response) => {
                commit('ASSIGN_DATA', response.data)
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
    getUsersEchelonStaff({ commit, state }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/usersechelonstaff`)
            .then((response) => {
                commit('ASSIGN_DATA', response.data)
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
    submitUser({ dispatch, commit, state }) {
        return new Promise((resolve, reject) => {
            $axios.post(`/users`, state.user)
            .then((response) => {
                dispatch('getUsers').then(() => {
                    commit('SET_SNACKBAR', { message: 'Data berhasil disimpan', type: 'success' }, { root: true });
                    resolve(response.data)
                })
            })
            .catch((error) => {
                if (error.response.status == 422) {
                    commit('SET_ERRORS', error.response.data.errors, { root: true });
                    resolve();
                }
                if (error.response.status == 401) {
                    localStorage.removeItem('token');
                    commit('SET_SNACKBAR', { message: 'Session anda sudah habis', type: 'error' }, { root: true });
                    $router.go('/login');
                }
                if (error.response.status == 500) {
                    commit('SET_SNACKBAR', { message: 'Email sudah dipakai', type: 'error' }, { root: true });
                    commit('SET_ERRORS', error.response.data.errors, { root: true });
                    resolve(error.response.status);
                }
            })
        })
    },
    updateUser({ state, commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.put(`/users/${payload}`, state.user)
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
                    commit('SET_SNACKBAR', { message: 'Session anda sudah habis', type: 'error' }, { root: true });
                    $router.go('/login');
                }
            })
        })
    } ,
    removeUser({ dispatch, commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.delete(`/users/${payload}`)
            .then((response) => {
                commit('SET_SNACKBAR', { message: 'Data berhasil dihapus', type: 'success' }, { root: true });
                dispatch('getUsers').then(() => resolve())
            })
            .catch((error) => {
                if (error.response.status == 500) {
                    commit('SET_SNACKBAR', { message: 'Data gagal dihapus karena masih digunakan oleh entitas lain', type: 'error' }, { root: true });
                    commit('SET_ERRORS', error.response.data.errors, { root: true });
                    resolve();
                }
                if (error.response.status == 401) {
                    localStorage.removeItem('token');
                    commit('SET_SNACKBAR', { message: 'Session anda sudah habis', type: 'error' }, { root: true });
                    $router.go('/login');
                }
            })
        })
    },
    
    //MENGAMBIL DATA USER YANG SEDANG LOGIN
    getUserLogin({ commit }) {
        return new Promise((resolve, reject) => {
            $axios.get(`user-authenticated`)
            .then((response) => {
                commit('ASSIGN_USER_AUTH', response.data.data)
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
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}