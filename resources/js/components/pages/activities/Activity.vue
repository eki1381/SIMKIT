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
        
        <v-dialog v-model="activityDialog" persistent max-width="500px">
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
                                    :error-messages="codeErrors"
                                    type="number"
                                    v-model="code"
                                    prepend-icon="mdi-numeric"
                                    required
                                    dense
                                    @input="$v.code.$touch()"
                                    @blur="$v.code.$touch()"
                                    label="Kode Kegiatan">
                                </v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" sm="12" md="12">
                                <v-text-field
                                    :disabled="disabledForm"
                                    :error-messages="nameErrors"
                                    v-model="name"
                                    prepend-icon="mdi-format-text-variant"
                                    required
                                    dense
                                    @input="$v.code.$touch()"
                                    @blur="$v.code.$touch()"
                                    label="Nama Kegiatan">
                                </v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" sm="12" md="12">
                                <v-select
                                    :disabled="disabledForm"
                                    :items="sections.data"
                                    prepend-icon="mdi-contacts"
                                    v-model="section_id"
                                    @change="$v.section_id.$touch()"
                                    @blur="$v.section_id.$touch()"
                                    :error-messages="sectionErrors"
                                    dense
                                    item-text="name"
                                    item-value="id"
                                    label="Seksi">
                                </v-select>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" sm="12" md="12">
                                <v-text-field
                                    :disabled="disabledForm"
                                    v-model="volumeUnit"
                                    prepend-icon="mdi-ruler"
                                    required
                                    @change="$v.section_id.$touch()"
                                    @blur="$v.section_id.$touch()"
                                    :error-messages="volumeUnitErrors"
                                    dense
                                    label="Satuan Volume">
                                </v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" sm="12" md="12">
                                <v-text-field
                                    :disabled="disabledForm"
                                    v-model="timeUnit"
                                    prepend-icon="mdi-calendar-clock"
                                    required
                                    @change="$v.section_id.$touch()"
                                    @blur="$v.section_id.$touch()"
                                    :error-messages="timeUnitErrors"
                                    dense
                                    label="Satuan Waktu">
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
            <v-data-table :headers="headers" :items="activities.data" class="overflow-hidden box-shadow-card font-weight-bold" :items-per-page="7">
                <template v-slot:top>
                    <v-toolbar flat light>
                        <v-toolbar-title class="blue--text"><h4>Kegiatan</h4></v-toolbar-title>
                        <v-spacer/>
                        
                        <v-dialog v-model="removeDialog" persistent max-width="500px">
                            <v-card>
                                <v-card-title class="title font-weight-light">
                                    Anda yakin ingin menghapus?
                                </v-card-title>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn color="blue darken-1" text :disabled="disabledForm" @click="removeDialog = false">Tidak</v-btn>
                                    <v-btn color="blue darken-1" text :loading="loading" @click="deleteItem">Ya</v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                        
                    </v-toolbar>
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
        code: { required, minLength: minLength(4), maxLength: maxLength(4) },
        name: { required },
        volumeUnit: { required },
        timeUnit: { required },
        section_id: { required },
    },

    data: () => ({
        breadcrumbs: [
            {
                text: 'Master',
                disabled: true,
            },
            {
                text: 'Kegiatan',
                disabled: true,
            },
        ],

        code: '',
        name: '',
        volumeUnit: '',
        timeUnit: '',
        section_id: '',

        activityDialog: false,
        removeDialog: false,
        item: [],

        headers: [
            { text: 'KODE', value: 'code', width: '10%' },
            {
                text: 'KEGIATAN',
                align: 'start',
                sortable: false,
                value: 'name',
                width: '40%',
            },
            { text: 'SEKSI', value: 'section.name', width: '30%' },
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
        ...mapState('activity', {activities: state => state.activities}),
        ...mapState('activity', {activity: state => state.activity}),
        ...mapState('section', {sections: state => state.sections}),

        formTitle () {
            return this.editedIndex === -1 ? 'Tambah Kegiatan' : 'Ubah Kegiatan'
        },

        codeErrors () {
            const errors = []
            if (!this.$v.code.$dirty) return errors
            !this.$v.code.minLength && errors.push('Kode kegiatan harus terdiri dari 4 karakter')
            !this.$v.code.maxLength && errors.push('Kode kegiatan harus terdiri dari 4 karakter')
            !this.$v.code.required && errors.push('Kode kegiatan harus diisi')
            return errors
        },

        nameErrors () {
            const errors = []
            if (!this.$v.name.$dirty) return errors
            !this.$v.name.required && errors.push('Nama kegiatan harus diisi')
            return errors
        },
        
        sectionErrors () {
            const errors = []
            if (!this.$v.code.$dirty) return errors
            !this.$v.section_id.required && errors.push('Seksi harus diisi')
            return errors
        },

        timeUnitErrors () {
            const errors = []
            if (!this.$v.timeUnit.$dirty) return errors
            !this.$v.timeUnit.required && errors.push('Satuan waktu harus diisi')
            return errors
        },

        volumeUnitErrors () {
            const errors = []
            if (!this.$v.volumeUnit.$dirty) return errors
            !this.$v.volumeUnit.required && errors.push('Satuan volume harus diisi')
            return errors
        },
    },

    created () {
        this.SET_PROGRESSBAR(true)
        this.getActivities().then(() => {
            this.skeletonLoading = false
            this.SET_PROGRESSBAR(false)
            this.hidden = false
        });

        this.getSections();
    },

    destroyed(){
        this.hidden=true;
    },

    methods: {
        ...mapActions('section', ['getSections']),
        ...mapActions('activity', ['getActivities', 'submitActivity', 'updateActivity', 'removeActivity']),
        ...mapMutations('activity', ['CLEAR_FORM', 'ASSIGN_FORM']),
        ...mapMutations(['SET_PROGRESSBAR']),

        closeDialog () {
            this.activityDialog = false
            this.name = ''
            this.code = ''
            this.volumeUnit = ''
            this.timeUnit = ''
            this.section_id = ''
            this.CLEAR_FORM()
            this.editedIndex = -1
        },

        openRemoveDialog (item) {
            this.removeDialog = true
            this.item = item
        },

        editItem (item) {
            this.editedIndex = this.activities.data.indexOf(item)
            this.code = this.activities.data[this.editedIndex].code
            this.name = this.activities.data[this.editedIndex].name
            this.volumeUnit = this.activities.data[this.editedIndex].volumeUnit
            this.timeUnit = this.activities.data[this.editedIndex].timeUnit
            this.section_id = this.activities.data[this.editedIndex].section_id
            this.activityDialog = true
        },

        deleteItem () {
            this.loading = true
            this.disabledForm = true
            this.deletedIndex = this.activities.data.indexOf(this.item)
            this.removeActivity(this.activities.data[this.deletedIndex].id).then(() => {
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
            this.$v.$touch()

            //JIKA TIDAK ADA ERROR MAKA FUNGSI PENYIMPANAN DIJALANKAN
            if(!this.$v.$invalid){
                //MEMUNCULKAN LOADER DAN MENONAKTIFKAN FORM
                this.loading = true
                this.disabledForm = true

                //MEMASUKKAN NAMA DAN KODE SEKSI PADA MODEL KE STATE
                this.activity.code = this.code
                this.activity.name = this.name
                this.activity.volumeUnit = this.volumeUnit
                this.activity.timeUnit = this.timeUnit
                this.activity.section_id = this.section_id

                //JIKA INDEX TIDAK ADA, MAKA GUNAKAN FUNSI SUBMIT SEKSI, JIKA ADA MAKA GUNAKAN FUNGSI UPDATE
                if(this.editedIndex === -1){
                    this.submitActivity().then(() => {
                        this.closeDialog()
                        this.loading = false
                        this.dialogProgressbar = false
                        this.disabledForm = false
                        this.code = ''
                        this.name = ''
                        this.volumeUnit = ''
                        this.timeUnit = ''
                        this.section_id = ''
                        this.CLEAR_FORM()
                    })
                }else{ 
                    this.updateActivity(this.activities.data[this.editedIndex].id).then(() => {
                        this.getActivities()
                        this.closeDialog()
                        this.loading = false
                        this.dialogProgressbar = false
                        this.disabledForm = false
                        this.code = ''
                        this.name = ''
                        this.volumeUnit = ''
                        this.timeUnit = ''
                        this.section_id = ''
                        this.CLEAR_FORM()
                    })
                } 
            }else{
                this.dialogProgressbar = false
            }
        },
    }
}
</script>