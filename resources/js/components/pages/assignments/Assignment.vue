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

        <v-dialog v-model="assignmentDialog" persistent max-width="500px">
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
                                <v-autocomplete
                                    v-model="activity_id"
                                    :search-input.sync="fetchVolume"
                                    :items="activities.data"
                                    @change="$v.activity_id.$touch()"
                                    @blur="$v.activity_id.$touch()"
                                    :error-messages="activityErrors"
                                    hide-no-data
                                    hide-selected
                                    dense
                                    item-text="name"
                                    item-value="id"
                                    label="Master Kegiatan"
                                    prepend-icon="mdi-database-search">
                                </v-autocomplete>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" sm="12" md="12">
                                <v-autocomplete
                                    v-model="user_to_id"
                                    :items="users.data"
                                    @change="$v.user_to_id.$touch()"
                                    @blur="$v.user_to_id.$touch()"
                                    :error-messages="userToErrors"
                                    hide-no-data
                                    hide-selected
                                    dense
                                    item-text="name"
                                    item-value="id"
                                    label="Tugas diberikan kepada"
                                    prepend-icon="mdi-account-arrow-right">
                                </v-autocomplete>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" sm="12" md="12">
                                <v-text-field
                                    :disabled="disabledForm"
                                    @change="$v.name.$touch()"
                                    @blur="$v.name.$touch()"
                                    :error-messages="nameErrors"
                                    v-model="name"
                                    dense
                                    prepend-icon="mdi-clipboard-text"
                                    required
                                    label="Nama Tugas">
                                </v-text-field>
                            </v-col>
                        </v-row>
                        <v-row
                            :align="'baseline'">
                            <v-col cols="6" sm="6" md="6">
                                <v-text-field
                                    type="number"
                                    :disabled="disabledForm"
                                    @change="$v.volume.$touch()"
                                    @blur="$v.volume.$touch()"
                                    :error-messages="volumeErrors"
                                    v-model="volume"
                                    prepend-icon="mdi-ruler"
                                    required
                                    label="Volume">
                                </v-text-field>
                            </v-col>
                            <v-col cols="6" sm="6" md="6">
                                <v-text-field
                                    readonly
                                    dense
                                    v-if="selectedActivity !== null"
                                    v-model="selectedActivity[0].volumeUnit"></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row
                            :align="'baseline'">
                            <v-col cols="6" sm="6" md="6">
                                <v-menu
                                    v-model="startDateMenu"
                                    :close-on-content-click="false"
                                    :nudge-right="40"
                                    transition="scale-transition"
                                    offset-y
                                    min-width="290px">
                                    
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field
                                            v-model="start_date"
                                            label="Tanggal mulai"
                                            prepend-icon="mdi-calendar"
                                            readonly
                                            v-bind="attrs"
                                            v-on="on"></v-text-field>
                                    </template>
                                    <v-date-picker 
                                        v-model="start_date" 
                                        @input="menu2 = false"
                                        @change="setMin"
                                        locale="id"></v-date-picker>
                                </v-menu>
                            </v-col>
                            <v-col cols="6" sm="6" md="6">
                                <v-menu
                                    v-model="finishDateMenu"
                                    :close-on-content-click="false"
                                    :nudge-right="40"
                                    transition="scale-transition"
                                    offset-y
                                    min-width="290px">

                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field
                                            v-model="finish_date"
                                            label="Tanggal selesai"
                                            prepend-icon="mdi-calendar"
                                            readonly
                                            v-bind="attrs"
                                            v-on="on">
                                        </v-text-field>
                                    </template>
                                    <v-date-picker
                                        v-model="finish_date" 
                                        @input="menu2 = false"
                                        locale="id"
                                        :min="min_date"></v-date-picker>
                                </v-menu>
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
        <v-dialog v-model="approvalDialog" persistent max-width="500px">
            <v-card>
                <v-tabs
                    v-model="tab"
                    background-color="transparent"
                    color="blue"
                    grow>
                    <v-tab>Info</v-tab>
                    <v-tab>Persetujuan</v-tab>
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
                                                v-model="user_to.name"
                                                prepend-icon="mdi-account-arrow-left"
                                                label="Diberikan kepada"
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
                                        <v-col cols="12" sm="12" md="12">
                                            <v-btn
                                                :loading="loading2"
                                                :disabled="loading2"
                                                color="blue darken-1" text
                                                @click="downloadFile(id)">Unduh file di sini
                                                <v-icon right dark>mdi-cloud-download</v-icon>
                                            </v-btn>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="12" sm="12" md="12">
                                            <v-textarea
                                                label="Komentar dari pelaksana"
                                                v-model="comment"
                                                readonly
                                                auto-grow
                                                prepend-icon="mdi-comment-outline"
                                                rows="1"></v-textarea>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-radio-group v-model="is_finished" dense>
                                            <template v-slot:label>
                                                <div>Apakah anda <strong>setuju</strong> tugas ini sudah selesai?</div>
                                            </template>
                                            <v-radio value="Belum selesai" label="Belum selesai"></v-radio>
                                            <v-radio value="Sudah selesai" label="Sudah selesai"></v-radio>
                                        </v-radio-group>
                                    </v-row>
                                </v-container>
                            </v-card-text>
                        </v-card>
                    </v-tab-item>
                </v-tabs-items>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" :disabled="disabledForm" text @click="closeDialog">Batal</v-btn>
                    <v-btn color="blue darken-1" :loading="loading" text @click="approve(id)">Simpan</v-btn>
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
            type="table">
            <v-data-table :headers="headers" :items="assignments.data" class="overflow-hidden font-weight-bold box-shadow-card" :items-per-page="7">
                <template v-slot:top>
                    <v-toolbar flat light>
                        <v-toolbar-title class="blue--text"><h4>Berikan Tugas</h4></v-toolbar-title>
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
                <template v-slot:item.finish_date="{ item }">
                    {{ item.finish_date | formatDate }}
                </template>
                <template v-slot:item.is_finished="{ item }">
                    <v-chip :color="getColorStatus(item.is_finished)" dark label small class="font-weight-bold">{{item.is_finished}}</v-chip>
                </template>
                <template v-slot:item.actions="{ item }">
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                            <v-icon 
                                color="blue" 
                                small 
                                class="mr-2" 
                                @click="editItem(item)" 
                                v-if="item.is_finished !== 'Sudah selesai'"
                                v-bind="attrs"
                                v-on="on">mdi-pencil-outline</v-icon>
                        </template>
                        <span>Ubah</span>
                    </v-tooltip>
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                            <v-icon
                                color="green" 
                                small 
                                class="mr-2" 
                                @click="openApprovalDialog(item)" 
                                v-if="item.is_finished === 'Menunggu pengecekan'"
                                v-bind="attrs"
                                v-on="on">mdi-checkbox-marked-circle-outline</v-icon>
                        </template>
                        <span>Setujui</span>
                    </v-tooltip>
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                            <v-icon
                                color="red"
                                small
                                class="mr-2"
                                @click="openRemoveDialog(item)"
                                v-if="item.is_finished !== 'Sudah selesai'"
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
import { mapActions, mapState, mapMutations, mapGetters } from 'vuex';
import { required } from 'vuelidate/lib/validators';

export default {
    name: 'DataAssignment',

    validations: {
        name: {required},
        volume: {required},
        start_date: {required},
        finish_date: {required},
        activity_id: {required},
        user_to_id: {required},
    },

    data: () => ({
        breadcrumbs: [
            {
                text: 'Penugasan',
                disabled: true,
            },
            {
                text: 'Berikan Tugas',
                disabled: true,
            },
        ],

        id: '',
        name: null,
        user_to_id: null,
        volume: 0,
        start_date: new Date().toISOString().substr(0, 10),
        finish_date: new Date().toISOString().substr(0, 10),
        min_date: new Date().toISOString().substr(0, 10),
        activity_id: null,
        activity: '',
        user_to: '',
        file_path: '',
        comment: '',
        is_finished: 'Belum selesai',
        status: false,

        startDateMenu: null,
        finishDateMenu: null,

        assignmentDialog: false,
        approvalDialog: false,
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
            { text: 'PELAKSANA', value: 'user_to.name', align: 'center', width: '20%' },
            { text: 'SAMPAI TANGGAL', value: 'finish_date', width: '20%' },
            { text: 'STATUS', value: 'is_finished', width: '20%', align: 'center' },
            { text: '', value: 'actions', align: 'center', sortable: false, width: '20%' },
        ],

        editedIndex: -1,
        deletedIndex: '',
        skeletonLoading: true,
        dialogProgressbar: false,
        loading: false,
        loading2: false,
        disabledForm: false,
        show: false,
        hidden: true,
        tab: 0,
    }),

    computed: {
        ...mapState('assignment', {assignments: state => state.assignments}),
        ...mapState('assignment', {assignment: state => state.assignment}),
        ...mapState('activity', {activities: state => state.activities}),
        ...mapState('user', {users: state => state.users}),
        ...mapState('user', {authenticatedUser: state => state.authenticated}),
        ...mapGetters(['isAuth']),

        formTitle () {
            return this.editedIndex === -1 ? 'Tambah Tugas' : 'Ubah Tugas'
        },

        activityErrors () {
            const errors = []
            if (!this.$v.activity_id.$dirty) return errors
            !this.$v.activity_id.required && errors.push('Master kegiatan harus diisi')
            return errors
        },

        userToErrors () {
            const errors = []
            if (!this.$v.user_to_id.$dirty) return errors
            !this.$v.user_to_id.required && errors.push('Kegiatan ini belum ditujukan pada siapapun')
            return errors
        },

        nameErrors () {
            const errors = []
            if (!this.$v.name.$dirty) return errors
            !this.$v.name.required && errors.push('Nama kegiatan harus diisi')
            return errors
        },

        volumeErrors () {
            const errors = []
            if (!this.$v.volume.$dirty) return errors
            !this.$v.volume.required && errors.push('Volume kegiatan harus diisi')
            return errors
        },
    },

    created () {
        this.SET_PROGRESSBAR(true)
        this.getUserLogin().then(() => {
            this.getAssignmentsByUserFrom(this.authenticatedUser.id).then(() => {
                this.getActivitiesBySection(this.authenticatedUser.section_id)
                this.getUsersEchelonStaff()
                this.skeletonLoading = false
                this.SET_PROGRESSBAR(false)
                this.hidden = false
            })
        })
    },

    mounted() {
        this.interval = setInterval(() => {
            this.getAssignmentsByUserFrom(this.authenticatedUser.id)
        },10000)
    },

    destroyed (){
        this.hidden = true
        clearInterval(this.interval)
    },

    watch: {
        fetchVolume(val){
            if(this.activity_id != null){
                this.selectedActivity = this.activities.data.filter((a) => {
                    return (a.id == this.activity_id);
                })
            }else{
                this.selectedActivity = null;
            }
        }
    },

    methods: {
        ...mapActions('assignment', ['getAssignmentsByUserFrom',
                                        'submitAssignment', 'updateAssignment', 'removeAssignment',
                                        'download', 'updateStatus', 'countPerson', 'countSection']),
        ...mapActions('activity', ['getActivities', 'getActivitiesBySection']),
        ...mapActions('user', ['getUsers', 'getUserLogin', 'getUsersEchelonStaff']),
        ...mapMutations('assignment', ['CLEAR_FORM', 'ASSIGN_FORM', 'ASSIGN_STATUS']),
        ...mapMutations(['SET_PROGRESSBAR']),

        setMin(){
            this.min_date = this.start_date
        },

        getColorStatus(is_finished){
            if(is_finished == "Belum selesai"){
                return "red";
            }else if(is_finished == "Menunggu pengecekan"){
                return "orange";
            }else{
                return "green";
            }
        },

        downloadFile(item) {
            this.dialogProgressbar = true
            this.loading2 = true
            this.download(item).then(() => {
                this.loading2 = false
                this.dialogProgressbar = false
            }).catch(() => {
                this.loading2 = false
                this.dialogProgressbar = false
            })
        },

        openApprovalDialog (item) {
            this.editedIndex = this.assignments.data.indexOf(item);
            this.id = this.assignments.data[this.editedIndex].id;
            this.name = this.assignments.data[this.editedIndex].name;
            this.volume = this.assignments.data[this.editedIndex].volume;
            this.start_date = this.assignments.data[this.editedIndex].start_date;
            this.finish_date = this.assignments.data[this.editedIndex].finish_date;
            this.file_path = this.assignments.data[this.editedIndex].file_path;
            this.comment = this.assignments.data[this.editedIndex].comment;
            this.activity = this.assignments.data[this.editedIndex].activity;
            this.user_to = this.assignments.data[this.editedIndex].user_to;
            this.approvalDialog = true;
        },

        closeDialog () {
            this.assignmentDialog = false;
            this.approvalDialog = false;
            this.name = null;
            this.volume = null;
            this.start_date = new Date().toISOString().substr(0, 10);
            this.finish_date = new Date().toISOString().substr(0, 10);
            this.activity_id = null;
            this.user_to_id = null;
            this.editedIndex = -1;
            this.CLEAR_FORM();
        },

        openRemoveDialog (item) {
            this.removeDialog = true;
            this.item = item;
        },

        editItem (item) {
            this.editedIndex = this.assignments.data.indexOf(item);
            this.name = this.assignments.data[this.editedIndex].name;
            this.volume = this.assignments.data[this.editedIndex].volume;
            this.start_date = this.assignments.data[this.editedIndex].start_date;
            this.finish_date = this.assignments.data[this.editedIndex].finish_date;
            this.activity_id = this.assignments.data[this.editedIndex].activity_id;
            this.user_to_id = this.assignments.data[this.editedIndex].user_to_id;
            this.assignmentDialog = true;
        },

        deleteItem () {
            this.loading = true;
            this.disabledForm = true;
            this.deletedIndex = this.assignments.data.indexOf(this.item);
            this.removeAssignment(this.assignments.data[this.deletedIndex].id).then(() => {
                this.countPerson().then(() => {
                    this.countSection().then(() => {
                        this.getAssignmentsByUserFrom(this.authenticatedUser.id).then(() => {
                            this.deletedIndex = '';
                            this.item = [];
                            this.loading = false;
                            this.disabledForm = false;
                            this.removeDialog = false;
                        });
                    });
                });
            });
        },

        approve(item){
            this.dialogProgressbar = true
            this.loading = true;
            this.ASSIGN_STATUS(this.is_finished);
            this.updateStatus(item).then(() => {
                this.countPerson().then(() => {
                    this.countSection().then(() => {
                        this.getAssignmentsByUserFrom(this.authenticatedUser.id).then(() => {
                            this.approvalDialog = false;
                            this.loading = false;
                            this.dialogProgressbar = false
                            this.editedIndex = -1;
                        });
                    });
                });
            })
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
                this.assignment.name = this.name;
                this.assignment.volume = this.volume;
                this.assignment.start_date = this.start_date;
                this.assignment.finish_date = this.finish_date;
                this.assignment.activity_id = this.activity_id;
                this.assignment.user_to_id = this.user_to_id;

                //JIKA INDEX TIDAK ADA, MAKA GUNAKAN FUNGSI SUBMIT SEKSI, JIKA ADA MAKA GUNAKAN FUNGSI UPDATE
                if(this.editedIndex === -1){
                    this.submitAssignment().then(() => {
                        this.getAssignmentsByUserFrom(this.authenticatedUser.id)
                        this.closeDialog();
                        this.loading = false;
                        this.dialogProgressbar = false
                        this.disabledForm = false;
                        this.name = null;
                        this.volume = null;
                        this.start_date = new Date().toISOString().substr(0, 10);
                        this.finish_date = new Date().toISOString().substr(0, 10);
                        this.activity_id = null;
                        this.user_to_id = null;
                        this.CLEAR_FORM();
                    });
                }else{ 
                    this.updateAssignment(this.assignments.data[this.editedIndex].id).then(() => {
                        this.countPerson().then(() => {
                            this.countSection().then(() => {
                                this.getAssignmentsByUserFrom(this.authenticatedUser.id).then(() => {
                                    this.closeDialog();
                                    this.loading = false;
                                    this.dialogProgressbar = false
                                    this.disabledForm = false;
                                    this.volume = null;
                                    this.start_date = new Date().toISOString().substr(0, 10);
                                    this.finish_date = new Date().toISOString().substr(0, 10);
                                    this.activity_id = null;
                                    this.user_to_id = null;
                                    this.CLEAR_FORM();
                                });
                            });
                        });                        
                    });
                } 
            }else{
                this.dialogProgressbar = false
            }
        },
    }
}
</script>