<template>
    <div>
        <v-skeleton-loader
            :loading="false"
            class="box-shadow-card">
            <v-card class="mb-5 elevation-0 overflow-hidden box-shadow-card">
                <v-breadcrumbs :items="breadcrumbs">
                    <template v-slot:item="{ item }">
                        <v-breadcrumbs-item
                            :href="item.href"
                            :disabled="item.disabled"
                            class="font-weight-bold">
                            {{ item.text.toUpperCase() }}
                        </v-breadcrumbs-item>
                    </template>
                </v-breadcrumbs>
            </v-card>
        </v-skeleton-loader>
        <v-dialog v-model="userDialog" persistent max-width="500px">
            <template v-slot:activator="{ on }">
                <v-fab-transition>
                <v-btn color="pink" v-on="on" v-show="!hidden" fab small fixed large bottom right>
                    <v-icon color="white">mdi-plus</v-icon>
                </v-btn>
                </v-fab-transition>
            </template>
            <v-card>
                <v-toolbar flat light>
                    <v-toolbar-title class="blue--text font-weight-bold">{{ formTitle }}</v-toolbar-title>
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
                        <v-row>
                            <v-col cols="12" sm="12" md="12">
                                <v-select
                                    prepend-icon="mdi-account-cowboy-hat"
                                    :disabled="disabledForm"
                                    :error-messages="positionErrors"
                                    @change="$v.position_id.$touch()"
                                    @blur="$v.position_id.$touch()"
                                    dense
                                    :items="positions.data"
                                    v-model="position_id"
                                    item-text="name"
                                    item-value="id"
                                    label="Jabatan">
                                </v-select>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" sm="12" md="12">
                                <v-text-field
                                    :disabled="disabledForm"
                                    :error-messages="photoErrors"
                                    @input="$v.photo.$touch()"
                                    @blur="$v.photo.$touch()"
                                    dense
                                    prepend-icon="mdi-account-box"
                                    v-model="photo"
                                    required
                                    label="Link foto">
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
                <v-progress-linear
                    :active="dialogProgressbar"
                    :indeterminate="dialogProgressbar"
                    absolute
                    top
                    color="orange accent-2"></v-progress-linear>
            </v-card>
        </v-dialog>
        <v-skeleton-loader
            :loading="skeletonLoading"
            :transition="'fade-transition'"
            class="box-shadow-card"
            type="table">
            <v-data-table :headers="headers" :items="users.data" class="overflow-hidden box-shadow-card font-weight-bold" :items-per-page="7">
                <template v-slot:top>
                    <v-toolbar flat light>
                        <v-toolbar-title class="blue--text"><h4>Pegawai</h4></v-toolbar-title>
                        <v-spacer/>

                        <v-dialog v-model="removeDialog" persistent max-width="500px">
                            <v-card>
                                <v-card-title>Anda yakin ingin menghapus?</v-card-title>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn color="blue darken-1" text :disabled="disabledForm" @click="removeDialog = false">Tidak</v-btn>
                                    <v-btn color="blue darken-1" text :loading="loading" @click="deleteItem">Ya</v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                    </v-toolbar>
                </template>
                <template v-slot:item.photo="{ item }">
                    <v-avatar class="ma-1">
                        <v-img :src="item.photo"></v-img>
                    </v-avatar>                
                </template>
                <template v-slot:item.actions="{ item }">
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                            <v-icon
                                color="blue"
                                small
                                class="mr-2"
                                @click="editItem(item)"
                                v-bind="attrs"
                                v-on="on">mdi-pencil-outline</v-icon>
                        </template>
                        <span>Ubah</span>
                    </v-tooltip>
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                            <v-icon
                                color="red"
                                small
                                @click="openRemoveDialog(item)"
                                v-bind="attrs"
                                v-on="on">mdi-delete-outline</v-icon>
                        </template>
                        <span>Hapus</span>
                    </v-tooltip>
                </template>
            </v-data-table>
        </v-skeleton-loader>
    </div>
</template>

<script>
import { mapActions, mapState, mapMutations } from 'vuex'
import { required,minLength,maxLength,email } from 'vuelidate/lib/validators'

export default {
  validations: {
      name: { required },
      email: { required, email },
      password: { required, minLength: minLength(8) },
      ein: { required, minLength: minLength(18), maxLength: maxLength(18) },
      position_id: { required },
      photo: { required },
  },
  data: () => ({
    breadcrumbs: [
        {
            text: 'Master',
            disabled: true,
        },
        {
            text: 'Pegawai',
            disabled: true,
        },
    ],
      
    name: '',
    email: '',
    password: '',
    ein: '',
    position_id: '',
    photo: '',

    userDialog: false,
    removeDialog: false,
    item: [],
    headers: [
        { text: '', value: 'photo', sortable: false, width: '5%' },
        { text: 'NIP', align: 'center', value: 'ein', width: '15%' },
        {
            text: 'NAMA',
            align: 'start',
            sortable: false,
            value: 'name',
            width: '30%',
        },
        { text: 'JABATAN', value: 'position.name', width: '30%' },
        { text: '', value: 'actions', align: 'center', sortable: false, width: '20%' },
    ],
    editedIndex: -1,
    deletedIndex: '',
    skeletonLoading: true,
    dialogProgressbar: false,
    loading: false,
    disabledForm: false,
    show: false,
    hidden: true,
  }),

    computed: {
            ...mapState('user', {users: state => state.users}),
            ...mapState('user', {user: state => state.user}),
            ...mapState('position', {positions: state => state.positions}),
            ...mapState('position', {positionId: state => state.position_id}),
            ...mapState('position', {results: state => state.results}),

        formTitle () {
            return this.editedIndex === -1 ? 'Tambah Pegawai' : 'Ubah Pegawai'
        },

        nameErrors () {
            const errors = []
            if (!this.$v.name.$dirty) return errors
            !this.$v.name.required && errors.push('Nama pegawai harus diisi')
            return errors
        },

        emailErrors () {
            const errors = []
            if (!this.$v.name.$dirty) return errors
            !this.$v.email.required && errors.push('Email harus diisi')
            !this.$v.email.email && errors.push('Email tidak valid')
            return errors
        },

        passwordErrors () {
            const errors = []
            if (!this.$v.password.$dirty) return errors
            !this.$v.password.required && errors.push('Password harus diisi')
            !this.$v.password.minLength && errors.push('Password minimal harus terdiri dari 8 karakter')
            return errors
        },

        einErrors () {
            const errors = []
            if (!this.$v.ein.$dirty) return errors
            !this.$v.ein.minLength && errors.push('Nomor Induk Pegawai harus terdiri dari 18 karakter')
            !this.$v.ein.maxLength && errors.push('Nomor Induk Pegawai harus terdiri dari 18 karakter')
            !this.$v.ein.required && errors.push('Nomor Induk Pegawai harus diisi')
            return errors
        },

        positionErrors () {
            const errors = []
            if (!this.$v.position_id.$dirty) return errors
            !this.$v.position_id.required && errors.push('Jabatan harus diisi')
            return errors
        },

        photoErrors () {
            const errors = []
            if (!this.$v.photo.$dirty) return errors
            !this.$v.photo.required && errors.push('Link foto harus diisi')
            return errors
        },
    },

    created () {
        this.SET_PROGRESSBAR(true)
        this.getUsers().then(() => {
            this.skeletonLoading = false
            this.SET_PROGRESSBAR(false)
            this.hidden = false
        });
        this.getPositions()
    },

    destroyed() {
        this.hidden = true
    },

    methods: {
        ...mapActions('user', ['getUsers', 'submitUser', 'updateUser', 'removeUser']),
        ...mapActions('position', ['getPositions', 'getPositionById']),
        ...mapMutations('user', ['CLEAR_FORM', 'ASSIGN_FORM']),
        ...mapMutations('position', ['SET_POSITION_ID']),
        ...mapMutations(['SET_PROGRESSBAR']),

    closeDialog () {
        this.editedIndex = -1
        this.userDialog = false
        this.name = ''
        this.email = ''
        this.password = ''
        this.ein = ''
        this.position_id = ''
        this.photo = ''
        this.CLEAR_FORM()
    },

    openRemoveDialog (item) {
        this.removeDialog = true;
        this.item = item;
    },

    editItem (item) {
        this.editedIndex = this.users.data.indexOf(item)
        this.name = this.users.data[this.editedIndex].name
        this.email = this.users.data[this.editedIndex].email
        this.password = this.users.data[this.editedIndex].password
        this.ein = this.users.data[this.editedIndex].ein
        this.position_id = this.users.data[this.editedIndex].position_id
        this.photo = this.users.data[this.editedIndex].photo
        this.userDialog = true
    },

    deleteItem () {
        this.loading = true
        this.disabledForm = true
        this.deletedIndex = this.users.data.indexOf(this.item)
        this.removeUser(this.users.data[this.deletedIndex].id).then(() => {
            this.deletedIndex = ''
            this.item = []
            this.loading = false
            this.disabledForm = false
            this.removeDialog = false
        });
    },

    //FUNGSI UNTUK MENYIMPAN DATA JABATAN
    save() {
        this.dialogProgressbar = true
        //MELIHAT APAKAH TERDAPAT ERROR PADA VUELIDATE
        this.$v.$touch();

        //JIKA TIDAK ADA ERROR MAKA FUNGSI PENYIMPANAN DIJALANKAN
        if(!this.$v.$invalid){
            //MEMUNCULKAN LOADER DAN MENONAKTIFKAN FORM
            this.loading = true;
            this.disabledForm = true;

            //MEMASUKKAN NAMA DAN KODE SEKSI PADA MODEL KE STATE
            this.user.name = this.name
            this.user.email = this.email
            this.user.password = this.password
            this.user.ein = this.ein
            this.user.position_id = this.position_id
            this.user.photo = this.photo

            //MENGAMBIL SEKSI DARI JABATAN
            this.SET_POSITION_ID(this.position_id);
            this.getPositionById().then(() => {
                this.user.section_id = this.results.data[0].section_id;

                //JIKA INDEX TIDAK ADA, MAKA GUNAKAN FUNSI SUBMIT SEKSI, JIKA ADA MAKA GUNAKAN FUNGSI UPDATE
                if(this.editedIndex === -1){
                    this.submitUser().then((response) => {
                        if(response.status == 'success'){
                            this.closeDialog()
                            this.loading = false
                            this.dialogProgressbar = false
                            this.disabledForm = false;
                            this.name = ''
                            this.email = ''
                            this.password = ''
                            this.ein = ''
                            this.position_id = ''
                            this.photo = ''
                            this.CLEAR_FORM()
                            this.getUsers()
                        }
                    })
                }else{ 
                    this.updateUser(this.users.data[this.editedIndex].id).then((response) => {
                        if(response.status == 'success'){
                            this.closeDialog()
                            this.loading = false
                            this.dialogProgressbar = false
                            this.disabledForm = false;
                            this.name = ''
                            this.email = ''
                            this.password = ''
                            this.ein = ''
                            this.position_id = ''
                            this.photo = ''
                            this.CLEAR_FORM()
                            this.getUsers()
                        }
                    })
                } 
            })
        }else{
            this.dialogProgressbar = false
        }
    },
  }
}
</script>