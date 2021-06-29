import $axios from '../api.js'

const state = () => ({

})

const mutations = {
    
}

const actions = {
    submit({ commit }, payload) {
        localStorage.setItem('token', null);
        commit('SET_TOKEN', null, { root: true });
      
        return new Promise((resolve, reject) => {
            $axios.post('/login', payload)
            .then((response) => {
                if (response.data.status == 'success') {
                    localStorage.setItem('token', response.data.data);
                    commit('SET_TOKEN', response.data.data, { root: true });
                } else {
                    commit('SET_SNACKBAR', { message: 'Pengguna tidak terdaftar', type: 'error' }, { root: true });
                    commit('SET_ERRORS', { invalid: 'Email/Password Salah' }, { root: true })
                }
                resolve(response.data);
            })
            .catch((error) => {
                if (error.response.status == 422) {
                    commit('SET_SNACKBAR', { message: 'Pengguna tidak terdaftar', type: 'error' }, { root: true });
                    commit('SET_ERRORS', error.response.data.errors, { root: true })
                    resolve(error.response.data);
                }
            })
        })
    },
    initFirebase({ commit }, payload) {
        return new Promise((resolve, reject) => {
            const messaging = firebase.messaging();
            messaging.requestPermission().then(function () {
                console.log("Notification permission granted.");
                messaging.getToken().then(token => {
                    
                })
            })
            .catch(function (err) {
                console.log("Unable to get permission to notify.", err);
            });
        })
    }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}