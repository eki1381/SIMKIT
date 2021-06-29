<template>
    <v-app id="inspire" class="bg">
        <v-navigation-drawer 
            v-model="drawer" 
            :clipped="$vuetify.breakpoint.lgAndUp"
            app 
            v-if="isAuth" 
            color="white"
            flat
            class="box-shadow">
            <v-list dense v-if="isEchelon3">
                <template v-for="item in echelon3Items">
                    <v-row v-if="item.heading" :key="item.heading" align="center">
                        <v-col cols="6">
                            <v-subheader v-if="item.heading" class="list-item">
                                {{ item.heading }}
                            </v-subheader>
                        </v-col>
                        <v-divider></v-divider>
                    </v-row>
                    <v-list-item-group
                        v-else-if="item.children"
                        :key="item.text"
                        v-model="item.model"
                        :prepend-icon="item.model ? item.icon : item['icon-alt']"
                        append-icon=""
                        active-class="blue--text"
                        :value="false"
                        color="primary">
                        <template v-slot:activator>
                            <v-list-item-content>
                                <v-list-item-title class="font-weight-bold">
                                    {{ item.text }}
                                </v-list-item-title>
                            </v-list-item-content>
                        </template>
                        <v-list-item v-for="(child, i) in item.children" :key="i" link router :to="child.route" dense class="list-item">
                            <v-list-item-action v-if="child.icon">
                                <v-icon>{{ child.icon }}</v-icon>
                            </v-list-item-action>
                            <v-list-item-content>
                                <v-list-item-title class="font-weight-bold">
                                    {{ child.text }}
                                </v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list-item-group>
                    <v-list-item v-else :key="item.text" link router :to="item.route" dense class="list-item">
                        <v-list-item-action>
                            <v-icon>{{ item.icon }}</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title class="font-weight-bold">
                                {{ item.text }}
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </template>
            </v-list>
            <v-list dense v-if="isEchelon4">
                <template v-for="item in echelon4Items">
                    <v-row v-if="item.heading" :key="item.heading" align="center">
                        <v-col cols="6">
                            <v-subheader v-if="item.heading" class="list-item">
                                {{ item.heading }}
                            </v-subheader>
                        </v-col>
                        <v-divider></v-divider>
                    </v-row>
                    <v-list-item-group
                        v-else-if="item.children"
                        :key="item.text"
                        v-model="item.model"
                        :prepend-icon="item.model ? item.icon : item['icon-alt']"
                        append-icon=""
                        active-class="blue--text"
                        :value="false"
                        color="primary">
                        <template v-slot:activator>
                            <v-list-item-content>
                                <v-list-item-title class="font-weight-bold">
                                    {{ item.text }}
                                </v-list-item-title>
                            </v-list-item-content>
                        </template>
                        <v-list-item v-for="(child, i) in item.children" :key="i" link router :to="child.route" dense class="list-item">
                            <v-list-item-action v-if="child.icon">
                                <v-icon>{{ child.icon }}</v-icon>
                            </v-list-item-action>
                            <v-list-item-content>
                                <v-list-item-title class="font-weight-bold">
                                    {{ child.text }}
                                </v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list-item-group>
                    <v-list-item v-else :key="item.text" link router :to="item.route" class="list-item">
                        <v-list-item-action>
                            <v-icon>{{ item.icon }}</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title class="font-weight-bold">
                                {{ item.text }}
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </template>
            </v-list>
            <v-list dense v-if="isStaff">
                <template v-for="item in staffItems">
                    <v-row v-if="item.heading" :key="item.heading" align="center">
                        <v-col cols="6">
                            <v-subheader v-if="item.heading" class="list-item">
                                {{ item.heading }}
                            </v-subheader>
                        </v-col>
                        <v-divider></v-divider>
                    </v-row>
                    <v-list-item-group
                        v-else-if="item.children"
                        :key="item.text"
                        v-model="item.model"
                        :prepend-icon="item.model ? item.icon : item['icon-alt']"
                        append-icon=""
                        active-class="blue--text"
                        :value="false"
                        color="primary">
                        <template v-slot:activator>
                            <v-list-item-content>
                                <v-list-item-title class="font-weight-bold">
                                    {{ item.text }}
                                </v-list-item-title>
                            </v-list-item-content>
                        </template>
                        <v-list-item v-for="(child, i) in item.children" :key="i" link router :to="child.route" dense class="list-item">
                            <v-list-item-action v-if="child.icon">
                                <v-icon>{{ child.icon }}</v-icon>
                            </v-list-item-action>
                            <v-list-item-content>
                                <v-list-item-title class="font-weight-bold">
                                    {{ child.text }}
                                </v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list-item-group>
                    <v-list-item v-else :key="item.text" link router :to="item.route" dense class="list-item">
                        <v-list-item-action>
                            <v-icon>{{ item.icon }}</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title class="font-weight-bold">
                                {{ item.text }}
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </template>
            </v-list>
            <v-list dense v-if="authenticatedUser.admin">
                <template v-for="item in adminItems">
                    <v-row v-if="item.heading" :key="item.heading" align="center">
                        <v-col cols="6">
                            <v-subheader v-if="item.heading" class="list-item">
                                {{ item.heading }}
                            </v-subheader>
                        </v-col>
                        <v-divider></v-divider>
                    </v-row>
                    <v-list-item-group
                        v-else-if="item.children"
                        :key="item.text"
                        v-model="item.model"
                        :prepend-icon="item.model ? item.icon : item['icon-alt']"
                        append-icon=""
                        active-class="blue--text"
                        :value="false"
                        color="primary">
                        <template v-slot:activator>
                            <v-list-item-content>
                                <v-list-item-title class="font-weight-bold">
                                    {{ item.text }}
                                </v-list-item-title>
                            </v-list-item-content>
                        </template>
                        <v-list-item v-for="(child, i) in item.children" :key="i" link router :to="child.route" dense class="list-item">
                            <v-list-item-action v-if="child.icon">
                                <v-icon>{{ child.icon }}</v-icon>
                            </v-list-item-action>
                            <v-list-item-content>
                                <v-list-item-title class="font-weight-bold">
                                    {{ child.text }}
                                </v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list-item-group>
                    <v-list-item v-else :key="item.text" link router :to="item.route" dense class="list-item">
                        <v-list-item-action>
                            <v-icon>{{ item.icon }}</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title class="font-weight-bold">
                                {{ item.text }}
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </template>
            </v-list>
        </v-navigation-drawer>
        <v-main>
            <snackbar></snackbar>
            <v-snackbars :messages.sync="vsnackbar" color="blue" :timeout="3000" bottom right>
                <template v-slot:default="{ message }">
                    <v-list two-line color="blue">
                        <v-list-item>
                            <v-list-item-avatar>
                                <v-img :src="message.image"></v-img>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-title class="font-weight-bold" v-html="message.title"></v-list-item-title>
                                <v-list-item-subtitle v-html="message.body"></v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </template>
            </v-snackbars>
            <transition
                name="fade"
                mode="out-in">
                <router-view></router-view>
            </transition>
            <!-- <v-footer v-if="isAuth" padless absolute bottom color="white" class="box-shadow-card">
                <v-col
                    class="text-center"
                    cols="12">
                    <span class="text-caption">{{ new Date().getFullYear() }} — <strong>BPS Kabupaten Kepulauan Anambas</strong> <v-icon color="red">mdi-cards-heart</v-icon></span>
                </v-col>
            </v-footer> -->
        </v-main>
        <v-app-bar 
            :clipped-left="$vuetify.breakpoint.lgAndUp" 
            app
            color="blue"
            light
            v-if="isAuth && show"
            class="box-shadow">
            <v-app-bar-nav-icon @click.stop="drawer = !drawer">
                <v-icon color="white">mdi-segment</v-icon>
            </v-app-bar-nav-icon>
            <v-toolbar-title style="width: 200px" class="white--text ml-0">
                <v-img src="https://simkit.bpsanambas.com/logo_png_1.png" class="mx-2" max-height="40" max-width="120" contain></v-img>
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-icon
                color="white" 
                class="mx-3">mdi-view-grid-outline</v-icon>
            <v-menu 
                :rounded="'lg'"
                offset-y
                transition="scale-transition"
                origin="top right"
                v-if="notifications.data"
                v-model="menuOpened">
                <template v-slot:activator="{ attrs, on }">
                    <v-badge
                        :content="notifications.data.data.length"
                        :value="notifications.data.data.length"
                        color="red"
                        overlap>
                        <v-icon 
                            color="white" 
                            class="mx-3" 
                            v-bind="attrs" 
                            v-on="on">mdi-bell-outline</v-icon>
                    </v-badge>
                </template>
                <v-card width="400" v-if="notifications.data.data.length > 0">
                    <v-list
                        class="list-scroll"
                        two-line>
                        <template
                            v-for="notification in notifications.data.data">
                            <v-list-item
                                :key="notification.id"
                                link
                                dense>
                                <v-list-item-avatar color="blue">
                                    <v-img :src="notification.icon"></v-img>
                                </v-list-item-avatar>
                                <v-list-item-content>
                                    <v-list-item-subtitle class="font-weight-bold">{{ notification.title }}</v-list-item-subtitle>
                                    <v-list-item-subtitle>{{ notification.message }}</v-list-item-subtitle>
                                </v-list-item-content>
                            </v-list-item>
                        </template>
                    </v-list>
                </v-card>
                <v-card width="400" v-else>
                    <v-row justify="center" align="center">
                        <v-col cols="12" class="text-center">
                            <span class="text-subtitle-2">Tidak ada pemberitahuan yang belum dibaca</span>
                        </v-col>
                    </v-row>
                </v-card>
            </v-menu>
            <v-menu
                :rounded="'lg'"
                offset-y
                transition="scale-transition"
                origin="top right">
                <template v-slot:activator="{ attrs, on }">
                    <v-btn icon large v-bind="attrs" v-on="on" class="ml-2">
                        <v-avatar size="32px" item>
                            <v-img :src="authenticatedUser.photo" alt="Vuetify"/>
                        </v-avatar>
                    </v-btn>
                </template>
                <v-card width="350">
                    <v-list dark color="blue accent-2">
                        <v-list-item>
                            <v-list-item-avatar>
                                <v-img :src="authenticatedUser.photo"></v-img>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-title>{{ authenticatedUser.name }}</v-list-item-title>
                                <v-list-item-subtitle>{{ authenticatedUser.email }}</v-list-item-subtitle>
                            </v-list-item-content>
                            <v-list-item-action>
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn icon @click="logout" v-bind="attrs" v-on="on">
                                            <v-icon>mdi-power</v-icon>
                                        </v-btn>
                                    </template>
                                    <span>Keluar</span>
                                </v-tooltip>
                            </v-list-item-action>
                        </v-list-item>
                    </v-list>
                    <v-list dense>
                        <v-list-item @click="profile">
                            <v-list-item-action>
                                <v-icon>mdi-account-box</v-icon>
                            </v-list-item-action>
                            <v-list-item-subtitle>Profil</v-list-item-subtitle>
                        </v-list-item>
                    </v-list>
                </v-card>
            </v-menu>
            <v-progress-linear
                :active="progressbar"
                :indeterminate="progressbar"
                absolute
                top
                color="orange accent-2"></v-progress-linear>
        </v-app-bar>
        <v-dialog v-model="userDialog" persistent max-width="500px">
            <v-card>
                <v-toolbar flat light>
                    <v-toolbar-title class="blue--text font-weight-bold">Profil Pegawai</v-toolbar-title>
                </v-toolbar>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col cols="12" sm="12" md="12">
                                <v-text-field
                                    :disabled="disabledForm"
                                    :error-messages="einErrors"
                                    @input="$v.ein.$touch()"
                                    @blur="$v.ein.$touch()"
                                    dense
                                    v-model="ein"
                                    type="number"
                                    prepend-icon="mdi-numeric"
                                    required
                                    label="Nomor Induk Pegawai">
                                </v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" sm="12" md="12">
                                <v-text-field
                                    :disabled="disabledForm"
                                    :error-messages="nameErrors"
                                    @input="$v.name.$touch()"
                                    @blur="$v.name.$touch()"
                                    dense
                                    prepend-icon="mdi-format-text-variant"
                                    v-model="name"
                                    required
                                    label="Nama Pegawai">
                                </v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" sm="12" md="12">
                                <v-text-field
                                    :disabled="disabledForm"
                                    :error-messages="emailErrors"
                                    @input="$v.email.$touch()"
                                    @blur="$v.email.$touch()"
                                    dense
                                    prepend-icon="mdi-at"
                                    v-model="email"
                                    required
                                    label="Email">
                                </v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" sm="12" md="12">
                                <v-text-field
                                    prepend-icon="mdi-lock-question"
                                    :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'"
                                    :type="show ? 'text' : 'password'"
                                    @click:append="show = !show"
                                    :disabled="disabledForm"
                                    :error-messages="passwordErrors"
                                    @input="$v.password.$touch()"
                                    @blur="$v.password.$touch()"
                                    dense
                                    v-model="password"
                                    required
                                    label="Password">
                                </v-text-field>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" :disabled="disabledForm" text @click="closeDialog">Batal</v-btn>
                    <v-btn color="blue darken-1" :loading="loading" text @click="save">Simpan</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-app>
</template>
<script>
    import { mapActions, mapState, mapMutations, mapGetters } from 'vuex'
    import { required, minLength, maxLength, email } from 'vuelidate/lib/validators'
    import Snackbar from './components/Snackbar'
    import VSnackbars from 'v-snackbars'
    import $route from './router.js'
    import $store from './store.js'
    import firebase from 'firebase/app'
    import 'firebase/messaging'
    
    export default {
        components: {
            'snackbar': Snackbar,
            'v-snackbars': VSnackbars
        },
        
        validations: {
            name: { required },
            email: { required, email },
            password: { required, minLength: minLength(8) },
            ein: { required, minLength: minLength(18), maxLength: maxLength(18) },
        },
        data: () => ({
            userDialog: false,
            disabledForm: false,
            show: false,
            loading: false,
            drawer: null,
            isEchelon3: false,
            isEchelon4: false,
            isStaff: false,
            backgroundColor: "#F9F9F9",
            show: false,
            vsnackbar: [],
            menuOpened: '',

            name: '',
            email: '',
            password: '',
            ein: '',
            photo: [],
            
            echelon3Items: [
                { icon: 'mdi-view-dashboard-outline', text: 'Beranda', route: '/' },
                { heading: 'UTAMA' },
                { icon: 'mdi-contacts-outline', text: 'Pemantauan', route: '/monitoring'},
                { icon: 'mdi-calendar-outline', text: 'Kalender Kegiatan', route: '/calendar'},
                { heading: 'PENILAIAN' },
                { icon: 'mdi-equalizer-outline', text: 'Seksi', route: '/sectionscore' },
                { icon: 'mdi-podium-gold', text: 'Individu', route: '/personscore' },
            ],
            echelon4Items: [
                { icon: 'mdi-view-dashboard-outline', text: 'Beranda', route: '/' },
                { heading: 'UTAMA' },
                { icon: 'mdi-contacts-outline', text: 'Pemantauan', route: '/monitoring'},
                { icon: 'mdi-calendar-outline', text: 'Kalender Kegiatan', route: '/calendar'},
                { heading: 'PENUGASAN' },
                { icon: 'mdi-text-box-plus-outline', text: 'Berikan Tugas', route: '/assignments' },
                { icon: 'mdi-text-box-search-outline', text: 'Terima Tugas', route: '/processing' },
                { heading: 'PENILAIAN' },
                { icon: 'mdi-equalizer-outline', text: 'Seksi', route: '/sectionscore' },
                { icon: 'mdi-podium-gold', text: 'Individu', route: '/personscore' },
                { icon: 'mdi-file-chart-outline', text: 'Capaian Kinerja', route: '/recapitulation' },
            ],
            staffItems: [
                { icon: 'mdi-view-dashboard-outline', text: 'Beranda', route: '/' },
                { heading: 'UTAMA' },
                { icon: 'mdi-calendar-outline', text: 'Kalender Kegiatan', route: '/calendar' },
                { heading: 'PENUGASAN' },
                { icon: 'mdi-text-box-search-outline', text: 'Terima Tugas', route: '/processing' },
                { heading: 'PENILAIAN' },
                { icon: 'mdi-equalizer-outline', text: 'Seksi', route: '/sectionscore' },
                { icon: 'mdi-podium-gold', text: 'Individu', route: '/personscore' },
                { icon: 'mdi-file-chart-outline', text: 'Capaian Kinerja', route: '/recapitulation' },
            ],
            adminItems: [
                { heading: 'MASTER' },
                { icon: 'mdi-account-outline', text: 'Pegawai', route: '/users' },
                { icon: 'mdi-contacts-outline', text: 'Seksi', route: '/sections' },
                { icon: 'mdi-account-box-outline', text: 'Jabatan', route: '/positions' },
                { icon: 'mdi-head-cog-outline', text: 'Kegiatan', route: '/activities' },
            ],
        }),
        created () {
            if (firebase.messaging.isSupported()) {
                let config = {
                    apiKey: "AIzaSyDVYD8XZeT7y35-tFXEfdkfHPcybf8Hwnk",
                    authDomain: "simkit-5a91e.firebaseapp.com",
                    databaseURL: "https://simkit-5a91e.firebaseio.com",
                    projectId: "simkit-5a91e",
                    storageBucket: "simkit-5a91e.appspot.com",
                    messagingSenderId: "460864187987",
                    appId: "1:460864187987:web:8f77dc8e1abfe5d06220a6",
                    measurementId: "G-YMCWFHG805"
                };
                firebase.initializeApp(config)
                const messaging = firebase.messaging()
                messaging.requestPermission().then(() => {
                    console.log('Permission accepted')
                }).catch(function(err) {
                    console.log('Unable to get permission to notify.', err)
                })

                messaging.onMessage(payload => {
                    this.vsnackbar.push({
                        title: payload.notification.title,
                        body: payload.notification.body,
                        image: payload.notification.image,
                    })

                })
            }
            //REQUEST DATA YANG SEDANG LOGIN
            if (this.isAuth) {
                this.getUserLogin().then(() => {
                    this.isEchelon3 = this.$store.getters['user/isEchelon3']
                    this.isEchelon4 = this.$store.getters['user/isEchelon4']
                    this.isStaff = this.$store.getters['user/isStaff']
                    this.overlay = false
                    this.getNotifications(this.authenticatedUser.id)
                });
            }
        },
        mounted() {
            this.show = true
            if(this.isAuth){
                this.interval = setInterval(() => {
                    this.getNotifications(this.authenticatedUser.id)
                },5000)
            }
        },
        watch: {
            menuOpened: function(){
                if(this.menuOpened == false){
                    this.updateNotifs()
                }
            } 
        },
        computed: {
            ...mapState(['token', 'progressbar']),
            ...mapState('user', {authenticatedUser: state => state.authenticated}),
            ...mapState('user', {user: state => state.user}),
            ...mapState('position', {positions: state => state.positions}),
            ...mapState('position', {positionId: state => state.position_id}),
            ...mapState('position', {results: state => state.results}),
            ...mapState('notification', {notifications: state => state.notifications}),
            ...mapGetters(['isAuth']),

            nameErrors () {
                const errors = []
                if (!this.$v.name.$dirty) return errors
                !this.$v.name.required && errors.push('Nama pegawai harus diisi');
                return errors
            },

            emailErrors () {
                const errors = []
                if (!this.$v.name.$dirty) return errors
                !this.$v.email.required && errors.push('Email harus diisi');
                !this.$v.email.email && errors.push('Email tidak valid');
                return errors
            },

            passwordErrors () {
                const errors = []
                if (!this.$v.password.$dirty) return errors
                !this.$v.password.required && errors.push('Password harus diisi');
                !this.$v.password.minLength && errors.push('Password minimal harus terdiri dari 8 karakter');
                return errors
            },

            einErrors () {
                const errors = []
                if (!this.$v.ein.$dirty) return errors
                !this.$v.ein.minLength && errors.push('Nomor Induk Pegawai harus terdiri dari 18 karakter');
                !this.$v.ein.maxLength && errors.push('Nomor Induk Pegawai harus terdiri dari 18 karakter');
                !this.$v.ein.required && errors.push('Nomor Induk Pegawai harus diisi');
                return errors
            },
        },
        methods: {
            ...mapActions('user', ['getUserLogin', 'updateUser', 'uploadPhoto']),
            ...mapActions('position', ['getPositionById']),
            ...mapActions('notification', ['getNotifications', 'updateNotification']),
            ...mapMutations('user', ['CLEAR_FORM', 'ASSIGN_FORM', 'ASSIGN_PHOTO']),
            ...mapMutations('position', ['SET_POSITION_ID']),
            ...mapMutations(['SET_PROGRESSBAR', 'SET_VSNACKBAR', 'CLEAR_VSNACKBAR']),

            updateNotifs(){
                if(this.notifications.data.data.length > 0){
                    this.updateNotification(this.notifications.data.data)
                }
            },

            closeDialog () {
                this.userDialog = false;
                this.name = '';
                this.email = '';
                this.password = '';
                this.ein = '';
                this.position_id = '';
                this.CLEAR_FORM();
            },

            logout(){
                axios.get('API/logout').then(response => {
                    localStorage.removeItem('token');
                    delete axios.defaults.headers.common['Authorization'];
                    this.$router.go('/login');
                })
                .catch(error => {
                    localStorage.removeItem('token');
                    delete axios.defaults.headers.common['Authorization'];
                    this.$router.go('/login');
                });       
            },
            profile(){
                this.name = this.authenticatedUser.name;
                this.email = this.authenticatedUser.email;
                this.password = this.authenticatedUser.password;
                this.ein = this.authenticatedUser.ein;
                this.userDialog = true;
            },

            //FUNGSI UNTUK MENYIMPAN DATA JABATAN
            save() {
                //MELIHAT APAKAH TERDAPAT ERROR PADA VUELIDATE
                this.$v.$touch();

                //JIKA TIDAK ADA ERROR MAKA FUNGSI PENYIMPANAN DIJALANKAN
                if(!this.$v.$invalid){
                    //MEMUNCULKAN LOADER DAN MENONAKTIFKAN FORM
                    this.loading = true;
                    this.disabledForm = true;

                    //MEMASUKKAN NAMA DAN KODE SEKSI PADA MODEL KE STATE
                    this.user.name = this.name;
                    this.user.email = this.email;
                    this.user.password = this.password;
                    this.user.ein = this.ein;
                    this.user.position_id = this.authenticatedUser.position_id;

                    if(this.photo == []){
                        this.ASSIGN_PHOTO(this.authenticatedUser.photo);
                    }else{
                        this.ASSIGN_PHOTO(this.photo);
                    }

                    //MENGAMBIL SEKSI DARI JABATAN
                    this.SET_POSITION_ID(this.authenticatedUser.position_id);
                    this.getPositionById().then(() => {
                        this.user.section_id = this.results.data[0].section_id;
                        this.updateUser(this.authenticatedUser.id).then(() => {
                            this.uploadPhoto(this.authenticatedUser.id).then(() => {
                                if (this.isAuth) {
                                    this.getUserLogin().then(() => {
                                        this.isEchelon3 = this.$store.getters['user/isEchelon3'];
                                        this.isEchelon4 = this.$store.getters['user/isEchelon4'];
                                        this.isStaff = this.$store.getters['user/isStaff'];
                                        this.overlay = false;
                                    });
                                }
                                this.closeDialog();
                                this.loading = false;
                                this.disabledForm = false;
                                this.name = '';
                                this.email = '';
                                this.password = '';
                                this.ein = '';
                                this.position_id = '';
                                this.photo = [];
                                this.CLEAR_FORM();
                            });
                        });
                    })
                }
            },
        },
    }
</script>
<style scoped>
    .list-item {
        max-height: 5px;
        margin: 3px;
        margin-left: 10px;
        margin-right: 10px;
        border-radius: 6px;
    }
    .bg {
        background: #f2f5f8;
        color: rgba(0,0,0,.87);
    }
    .fade-enter-active, .fade-leave-active {
        transition-duration: 0.3s;
        transition-property: opacity;
        transition-timing-function: ease;
    }

    .fade-enter, .fade-leave-active {
        opacity: 0
    }

    .list-scroll{
        height: auto;
        max-height: 400px;
        overflow-y:auto;
    }
</style>