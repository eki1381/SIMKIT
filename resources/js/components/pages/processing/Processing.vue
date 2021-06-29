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
    <v-skeleton-loader
        :loading="skeletonLoading"
        :transition="'fade-transition'"
        type="table">
        <v-data-table :headers="headers" :items="processings.data" class="overflow-hidden font-weight-bold box-shadow-card" :items-per-page="7">
            <template v-slot:item.is_finished="{ item }">
                <v-chip :color="getColorStatus(item.is_finished)" dark small label class="font-weight-bold">{{item.is_finished}}</v-chip>
            </template>
            <template v-slot:item.finish_date="{ item }">
                {{ item.finish_date | formatDate }}
            </template>
            <template v-slot:top>
                <v-toolbar flat light>
                    <v-toolbar-title class="blue--text"><h4>Terima Tugas</h4></v-toolbar-title>
                    <v-spacer/>
                    <v-dialog v-model="assignmentDialog" persistent max-width="500px">
                        <v-card>
                            <v-tabs
                                v-model="tab"
                                background-color="transparent"
                                color="blue"
                                grow>
                                <v-tab>Info</v-tab>
                                <v-tab>Unggah</v-tab>
                            </v-tabs>
                            <v-tabs-items v-model="tab">
                                <v-tab-item>
                                    <v-card flat>
                                        <v-card-text>
                                            <v-container>
                                                <v-row>
                                                    <v-col cols="12" sm="12" md="12">
                                                        <v-text-field
                                                            v-model="activity.name"
                                                            prepend-icon="mdi-database-search"
                                                            label="Master Kegiatan"
                                                            dense
                                                            readonly>
                                                        </v-text-field>
                                                    </v-col>
                                                </v-row>
                                                <v-row>
                                                    <v-col cols="12" sm="12" md="12">
                                                        <v-text-field
                                                            v-model="name"
                                                            prepend-icon="mdi-clipboard-text"
                                                            label="Nama Tugas"
                                                            dense
                                                            readonly>
                                                        </v-text-field>
                                                    </v-col>
                                                </v-row>
                                                <v-row>
                                                    <v-col cols="12" sm="12" md="12">
                                                        <v-text-field
                                                            v-model="user_from.name"
                                                            prepend-icon="mdi-account-arrow-left"
                                                            label="Diberikan oleh"
                                                            dense
                                                            readonly>
                                                        </v-text-field>
                                                    </v-col>
                                                </v-row>
                                                <v-row :align="'baseline'">
                                                    <v-col cols="6" sm="6" md="6">
                                                        <v-text-field
                                                            v-model="volume"
                                                            prepend-icon="mdi-ruler"
                                                            label="Volume"
                                                            readonly>
                                                        </v-text-field>
                                                    </v-col>
                                                    <v-col cols="6" sm="6" md="6">
                                                        <v-text-field
                                                            dense
                                                            v-model="activity.volumeUnit"
                                                            readonly>
                                                        </v-text-field>
                                                    </v-col>
                                                </v-row>
                                                <v-row :align="'baseline'">
                                                    <v-col cols="6" sm="6" md="6">
                                                        <v-text-field
                                                            v-model="start_date"
                                                            prepend-icon="mdi-calendar"
                                                            label="Tanggal Mulai"
                                                            dense
                                                            readonly>
                                                        </v-text-field>
                                                    </v-col>
                                                    <v-col cols="6" sm="6" md="6">
                                                        <v-text-field
                                                            v-model="finish_date"
                                                            prepend-icon="mdi-calendar"
                                                            label="Tanggal Selesai"
                                                            dense
                                                            readonly>
                                                        </v-text-field>
                                                    </v-col>
                                                </v-row>
                                            </v-container>
                                        </v-card-text>
                                    </v-card>
                                </v-tab-item>
                                <v-tab-item>
                                    <v-card flat>
                                        <v-card-text>
                                            <v-container>
                                                <v-row :align="'baseline'">
                                                    <v-col cols="6" sm="6" md="6">
                                                        <v-text-field
                                                            v-model="realization"
                                                            prepend-icon="mdi-ruler"
                                                            label="Realisasi"
                                                            type="number"
                                                            @change="$v.realization.$touch()"
                                                            @blur="$v.realization.$touch()"
                                                            :error-messages="realizationErrors">
                                                        </v-text-field>
                                                    </v-col>
                                                    <v-col cols="6" sm="6" md="6">
                                                        <v-text-field
                                                            dense
                                                            v-model="activity.volumeUnit"
                                                            readonly>
                                                        </v-text-field>
                                                    </v-col>
                                                </v-row>
                                                <v-row>
                                                    <v-col cols="12" sm="12" md="12">
                                                        <v-checkbox 
                                                            v-model="finished" 
                                                            :label="'Pekerjaan ini sudah selesai dilakukan'"
                                                            dense></v-checkbox>
                                                    </v-col>
                                                </v-row>
                                                <v-row v-if="finished == true">
                                                    <v-col cols="12" sm="12" md="12">
                                                        *Silakan unggah bukti pengerjaan di bawah ini. Format file yang diperbolehkan adalah .pdf
                                                    </v-col>
                                                </v-row>
                                                <v-row v-if="finished == true">
                                                    <v-col cols="12" sm="12" md="12">
                                                        <v-file-input
                                                            v-model="file"
                                                            :disabled="disabledForm"
                                                            accept="application/pdf"
                                                            show-size counter chips
                                                            @change="$v.file.$touch()"
                                                            @blur="$v.file.$touch()"
                                                            :error-messages="fileErrors"
                                                            label="Unggah bukti pengerjaan anda">
                                                            <template v-slot:selection="{ text }">
                                                                <v-chip
                                                                    small
                                                                    label
                                                                    color="primary"
                                                                >{{ text }}</v-chip>
                                                            </template>
                                                        </v-file-input>
                                                    </v-col>
                                                </v-row>
                                                <v-row v-if="finished == true">
                                                    <v-col cols="12" sm="12" md="12">
                                                        <v-textarea
                                                            label="Komentar"
                                                            v-model="comment"
                                                            auto-grow
                                                            prepend-icon="mdi-comment-outline"
                                                            rows="1"></v-textarea>
                                                    </v-col>
                                                </v-row>
                                                <v-row v-if="finished == true">
                                                    <v-col cols="12" sm="12" md="12">
                                                        <v-menu
                                                            v-model="collectDateMenu"
                                                            :close-on-content-click="false"
                                                            :nudge-right="40"
                                                            transition="scale-transition"
                                                            offset-y
                                                            min-width="290px">

                                                            <template v-slot:activator="{ on, attrs }">
                                                                <v-text-field
                                                                    v-model="collect_date"
                                                                    label="Tanggal penyelesaian"
                                                                    prepend-icon="mdi-calendar"
                                                                    readonly
                                                                    v-bind="attrs"
                                                                    v-on="on">
                                                                </v-text-field>
                                                            </template>
                                                            <v-date-picker
                                                                v-model="collect_date" 
                                                                @input="menu2 = false"
                                                                locale="id"
                                                                :min="start_date"
                                                                :max="max_date"></v-date-picker>
                                                        </v-menu>
                                                    </v-col>
                                                </v-row>
                                            </v-container>
                                        </v-card-text>
                                    </v-card>
                                </v-tab-item>
                            </v-tabs-items>
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
                </v-toolbar>
            </template>
            <template v-slot:item.actions="{ item }">
                <v-tooltip bottom>
                    <template v-slot:activator="{ on, attrs }">
                        <v-icon 
                            color="blue"
                            small
                            class="mr-2"
                            @click="openUploadDialog(item)"
                            v-bind="attrs"
                            v-on="on"
                            v-if="item.is_finished == 'Belum selesai'">mdi-checkbox-marked-circle-outline</v-icon>
                    </template>
                    <span>Selesaikan</span>
                </v-tooltip>
            </template>
        </v-data-table>
    </v-skeleton-loader>
</div>
</template>

<script>
import { mapActions, mapState, mapMutations, mapGetters } from 'vuex'
import { required, requiredIf } from 'vuelidate/lib/validators'
import moment from 'moment-timezone'

export default {
    validations: {
        realization: { required },
        file: {
            required: requiredIf(function () {
                return this.finished == true
            })
        },
        collect_date: {
            required: requiredIf(function () {
                return this.finished == true
            }),
        }
    },
  
  data: () => ({
    breadcrumbs: [
        {
            text: 'Penugasan',
            disabled: true,
        },
        {
            text: 'Terima Tugas',
            disabled: true,
        },
    ],

    name: '',
    user_from: '',
    volume: '',
    start_date: moment().format('YYYY-MM-DD'),
    finish_date: moment().format('YYYY-MM-DD'),
    collect_date: moment().format('YYYY-MM-DD'),
    activity: '',
    is_finished: '',
    realization: 0,
    comment: '',

    file: null,

    startDateMenu: null,
    finishDateMenu: null,
    collectDateMenu: null,

    tab: 0,

    assignmentDialog: false,
    removeDialog: false,
    fetchVolume: null,
    selectedActivity: null,
    item: [],
    headers: [
        {
            text: 'TUGAS',
            align: 'start',
            sortable: false,
            value: 'name',
            width: '20%',
        },
        { text: 'PEMBERI TUGAS', value: 'user_from.name', width: '20%', align: 'center' },
        { text: 'SAMPAI TANGGAL', value: 'finish_date', width: '20%', align: 'center' },
        { text: 'STATUS', value: 'is_finished', width: '20%', align: 'center' },
        { text: '', value: 'actions', align: 'center', sortable: false, width: '20%' },
    ],
    editedIndex: -1,
    deletedIndex: '',
    skeletonLoading: true,
    dialogProgressbar: false,
    loading: false,
    disabledForm: false,
    finished: false,
    max_date: moment().format('YYYY-MM-DD'),
    myObj: {},
  }),

    computed: {
        ...mapState('user', {authenticatedUser: state => state.authenticated}),
        ...mapState('assignment', {processings: state => state.processings}),
        ...mapGetters(['isAuth']),

        realizationErrors () {
            const errors = []
            if (!this.$v.realization.$dirty) return errors
            !this.$v.realization.required && errors.push('Realisasi harus diisi terlebih dahulu');
            return errors
        },

        fileErrors () {
            const errors = []
            if (!this.$v.file.$dirty) return errors
            !this.$v.file.required && errors.push('Unggah file anda terlebih dahulu')
            return errors
        },

        collectDateErrors () {
            const errors = []
            if (!this.$v.collect_date.$dirty) return errors
            !this.$v.collect_date.required && errors.push('Tanggal penyelesaian harus diisi terlebih dahulu')
            return errors
        }
    },

    created () {
        this.SET_PROGRESSBAR(true)
        this.skeletonLoading = true
        this.getUserLogin().then(() => {
            this.getAssignmentsByUserTo(this.authenticatedUser.id).then(() => {
                this.skeletonLoading = false
                this.SET_PROGRESSBAR(false)
            })
        })
    },

    mounted() {
        this.interval = setInterval(() => {
            this.getAssignmentsByUserTo(this.authenticatedUser.id)
        },10000)
    },

    destroyed () {
        this.CLEAR_DATA()
        clearInterval(this.interval)
    },

  methods: {
    ...mapActions('section', ['getSections']),
    ...mapActions('assignment', ['getAssignmentsByUserTo', 'upload']),
    ...mapActions('user', ['getUserLogin']),
    ...mapMutations('assignment', ['CLEAR_UPLOAD', 'ASSIGN_UPLOAD', 'CLEAR_DATA']),
    ...mapMutations(['SET_PROGRESSBAR']),

    getColorStatus(is_finished){
        if(is_finished == "Belum selesai"){
            return "red";
        }else if(is_finished == "Menunggu pengecekan"){
            return "orange";
        }else{
            return "green";
        }
    },

    closeDialog () {
        this.assignmentDialog = false;
        this.editedIndex = -1;
        this.CLEAR_UPLOAD();
    },

    openUploadDialog(item) {
        this.editedIndex = this.processings.data.indexOf(item)
        this.name = this.processings.data[this.editedIndex].name
        this.volume = this.processings.data[this.editedIndex].volume
        this.start_date = this.processings.data[this.editedIndex].start_date
        this.finish_date = this.processings.data[this.editedIndex].finish_date
        this.realization = this.processings.data[this.editedIndex].realization
        this.comment = this.processings.data[this.editedIndex].comment
        this.activity = this.processings.data[this.editedIndex].activity
        this.user_from = this.processings.data[this.editedIndex].user_from
        this.assignmentDialog = true
    },

    save() {
        this.$v.$touch()

        //JIKA TIDAK ADA ERROR MAKA FUNGSI PENYIMPANAN DIJALANKAN
        if(!this.$v.$invalid){
            //MEMUNCULKAN LOADER DAN MENONAKTIFKAN FORM
            this.loading = true
            this.disabledForm = true
            
            this.myObj = {"realization":this.realization, "comment":this.comment, "file":this.file, "collect_date":this.collect_date}
            this.ASSIGN_UPLOAD(this.myObj)

            this.upload(this.processings.data[this.editedIndex].id).then(() => {
                this.getAssignmentsByUserTo(this.authenticatedUser.id)
                this.closeDialog();
                this.disabledForm = false;
                this.loading = false;
                this.realization = 0;
                this.comment = '';
                this.file = null;
                this.tab = 0;
                this.collect_date = new Date().toISOString().substr(0, 10);
            });
        }
    }
  },
}
</script>