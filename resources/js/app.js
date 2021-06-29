require('./bootstrap');
import Vuetify from "vuetify"
import Vuelidate from 'vuelidate'
import '../sass/app.scss'
import vueResource from 'vue-resource'
import router from './router.js'
import store from './store.js'
import App from './App.vue'
import moment from 'moment'
import momentzone from 'moment-timezone'

window.Vue = require('vue')

window.Vue.use(Vuetify)
window.Vue.use(vueResource)
window.Vue.use(Vuelidate)
momentzone.tz.setDefault('Asia/Jakarta')
window.Vue.filter('formatDate', function(value) {
    if (value) {
        var deMarch = moment(String(value))
        deMarch.locale('id')
        return deMarch.format('LL')
    }
})

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    router,
    store,
    components: {
        App,
    }
});
