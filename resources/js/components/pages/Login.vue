<template>
    <v-row v-if="!isAuth" class="mx-1" justify="center" align="center">
        <v-col cols="12" sm="6" md="6" lg="6">
            <v-main>
                <v-container class="bg">
                    <v-row justify="center">
                        <v-col cols="12" sm="10" md="8" lg="6">
                            <v-skeleton-loader class="box-shadow-card">
                                <v-card class="pb-5 box-shadow-card elevation-0">
                                    <v-row justify="center">
                                        <v-img src="https://simkit.bpsanambas.com/logo_png_2.png" height="60px" class="mt-7" contain></v-img>
                                    </v-row>
                                    <v-row justify="center">
                                        <span class="text-h4 font-weight-bold mt-5 mx-5 text-center">Selamat Datang</span>
                                    </v-row>
                                    <v-row justify="center" class="mx-2">
                                        <span class="text-body-2 mt-5 text-center">Silakan masuk dengan email anda</span>
                                    </v-row>
                                    <v-form>
                                    <v-row justify="center" class="mt-7 mx-5">
                                        <v-text-field
                                            label="Email"
                                            type="email"
                                            v-model="data.email"
                                            prepend-inner-icon="mdi-account"
                                            outlined></v-text-field>
                                    </v-row>
                                    <v-row justify="center" class="mx-5">
                                        <v-text-field
                                            label="Password"
                                            prepend-inner-icon="mdi-lock"
                                            :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'"
                                            :type="show ? 'text' : 'password'"
                                            v-model="data.password"
                                            @click:append="show = !show"
                                            outlined></v-text-field>
                                    </v-row>
                                    <v-row justify="center" class="mx-5">
                                        <v-btn class="button-shadow white--text" color="blue" block @click.prevent="postLogin">
                                            <span class="font-weight-bold">MASUK</span>
                                        </v-btn>
                                    </v-row>
                                    <v-row justify="center" class="mx-5 mt-3">
                                        <span class="text-center text-body-2 text-center">Tidak bisa masuk? Silakan hubungi admin</span>
                                    </v-row>
                                    </v-form>
                                </v-card>
                            </v-skeleton-loader>
                        </v-col>
                    </v-row>
                    <v-overlay :value="overlay">
                        <v-progress-circular indeterminate size="64" color="blue"></v-progress-circular>
                    </v-overlay>
                </v-container>
            </v-main>
        </v-col>
    </v-row>
</template>

<script>
import {mapActions, mapMutations, mapGetters, mapState} from 'vuex';
export default {
    data(){
        return{
            data:{
                email: '',
                password: '',
                remember_me: false,

            },
            overlay: false,
            show: false,
        }
    },
    created(){
        if(this.isAuth){
            this.$router.push({name: 'home'});
        }
    },
    computed: {
        ...mapGetters(['isAuth']),
        ...mapState(['errors']),
        ...mapState({snackbar: state => state.snackbar}),
    },
    methods: {
        ...mapActions('auth', ['submit', 'initFirebase']),
        ...mapActions('user', ['getUserLogin']),
        ...mapMutations(['CLEAR_ERRORS', 'SET_SNACKBAR']),

        postLogin() {
            this.overlay = !this.overlay;
            this.submit(this.data).then(()=>{
                if(this.isAuth) {
                    this.CLEAR_ERRORS();
                    this.$router.go({name: 'home'});
                    this.overlay = false;
                }else{
                    this.CLEAR_ERRORS();
                    this.overlay = false;
                }
            })
        },
    },
}
</script>
<style scoped>
    .bg {
        height: 100%;
        background:#f2f5f8;
    }

    .button-shadow {
        box-shadow: 1px 1px 18px #2196F3;
    }
</style>