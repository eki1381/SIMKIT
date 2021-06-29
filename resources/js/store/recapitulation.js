import $axios from '../api.js'

const state = () => ({
    assignments: [],
})

const mutations = {
    ASSIGN_ASSIGNMENTS(state, payload) {
        state.assignments = payload
    },
    CLEAR_ASSIGNMENTS(state) {
        state.assignments = []
    },
}

const actions = {
    getRecapitulation({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/recapitulation?q=${payload.user}&m=${payload.month}`)
            .then((response) => {
                commit('ASSIGN_ASSIGNMENTS', response.data)
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
    downloadRecapitulation({commit}, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/recapitulation/download?id=${payload.id}&ein=${payload.ein}&name=${payload.name}&position=${payload.position}&period=${payload.period}&month=${payload.month}&section=${payload.section_id}`, { responseType: 'blob' })
            .then( res => {
                const url = URL.createObjectURL(new Blob([res.data], {
                    type: 'application/vnd.ms-excel'
                }))
                const link = document.createElement('a')
                link.href = url
                link.setAttribute('download', 'CKP.xlsx')
                document.body.appendChild(link)
                link.click()
                resolve()
            })
            .catch((error) => {
                if (error.response.status == 401) {
                    localStorage.removeItem('token')
                    $router.go('/login')
                    commit('SET_SNACKBAR', { message: 'Session anda sudah habis', type: 'error' }, { root: true })
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