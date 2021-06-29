import $axios from '../api.js'

const state = () => ({
    notifications: [],

    notification: {
        message: '',
        is_read: '',
        user_id: '',
    }
})

const mutations = {
    ASSIGN_NOTIFICATIONS(state, payload) {
        state.notifications = payload
    },
    SET_NOTIFICATION(state, payload) {
        state.notification.message = payload.message
        state.notification.is_read = payload.is_read
        state.notification.user_id = payload.user_id
    }
}

const actions = {
    getNotifications({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/notifications?user=${payload}`)
            .then((response) => {
                commit('ASSIGN_NOTIFICATIONS', response.data)
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
    submitNotification({ commit, state, dispatch }) {
        return new Promise((resolve, reject) => {
            $axios.post(`/notifications`, state.notification)
            .then((response) => {
                dispatch('getNotifications').then(() => resolve())
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
    },
    updateNotification({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.put(`/notifications/${payload}`, payload)
            .then((response) => {
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
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}