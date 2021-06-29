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
        <v-dialog v-model="positionDialog" persistent max-width="500px">
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
                                    v-model="code"
                                    type="number"
                                    prepend-icon="mdi-numeric"
                                    :error-messages="codeErrors"
                                    required
                                    dense
                                    @input="$v.code.$touch()"
                                    @blur="$v.code.$touch()"
                                    label="Kode Jabatan">
                                </v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" sm="12" md="12">
                                <v-text-field
                                    :disabled="disabledForm"
                                    v-model="name"
                                    prepend-icon="mdi-format-text-variant"
                                    :error-messages="nameErrors"
                                    required
                                    dense
                                    @input="$v.name.$touch()"
                                    @blur="$v.name.$touch()"
                                    label="Nama Jabatan">
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
                                <v-select
                                    :disabled="disabledForm"
                                    :items="types"
                                    v-model="type"
                                    prepend-icon="mdi-apache-kafka"
                                    @change="$v.type.$touch()"
                                    @blur="$v.type.$touch()"
                                    :error-messages="typeErrors"
                                    dense
                                    item-text="value"
                                    item-value="id"
                                    label="Kelas jabatan">
                                </v-select>
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
            <v-data-table :headers="headers" :items="positions.data" class="overflow-hidden box-shadow-card font-weight-bold" :items-per-page="7">
                <template v-slot:top>
                    <v-toolbar flat light="">
                        <v-toolbar-title class="blue--text"><h4>Jabatan</h4></v-toolbar-title>
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
import { mapActions, mapState, mapMutations } from 'vuex';
import { required,minLength,maxLength } from 'vuelidate/lib/validators';

export default {
  name: 'DataPosition',
  validations: {
      name: { required },
      code: { required, minLength: minLength(3), maxLength: maxLength(3) },
      type: { required },
      section_id: { required },
  },
  
  data: () => ({
    breadcrumbs: [
        {
            text: 'Master',
            disabled: true,
        },
        {
            text: 'Jabatan',
            disabled: true,
        },
    ],


    name: '',
    code: '',
    type: '',
    section_id: '',

    positionDialog: false,
    removeDialog: false,
    item: [],
    headers: [
        { text: 'KODE', value: 'code', width: '20%' },
        {
            text: 'JABATAN',
            align: 'start',
            sortable: false,
            value: 'name',
            width: '30%',
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
    hidden: true,

    types: [
        { id: 1, value: "Eselon III" },
        { id: 2, value: "Eselon IV" },
        { id: 3, value: "Fungsional Umum/Tertentu" }
    ]
  }),

  computed: {
    ...mapState('position', {positions: state => state.positions}),
    ...mapState('position', {position: state => state.position}),
    ...mapState('section', {sections: state => state.sections}),

    formTitle () {
      return this.editedIndex === -1 ? 'Tambah Jabatan' : 'Ubah Jabatan'
    },

    nameErrors () {
      const errors = []
      if (!this.$v.name.$dirty) return errors
      !this.$v.name.required && errors.push('Nama jabatan harus diisi');
      return errors
    },

    codeErrors () {
      const errors = []
      if (!this.$v.code.$dirty) return errors
      !this.$v.code.minLength && errors.push('Kode jabatan harus terdiri dari 3 karakter');
      !this.$v.code.maxLength && errors.push('Kode jabatan harus terdiri dari 3 karakter');
      !this.$v.code.required && errors.push('Kode jabatan harus diisi');
      return errors
    },

    sectionErrors () {
        const errors = []
        if (!this.$v.code.$dirty) return errors
        !this.$v.section_id.required && errors.push('Seksi harus diisi')
        return errors
    },

    typeErrors () {
        const errors = []
        if (!this.$v.type.$dirty) return errors
        !this.$v.type.required && errors.push('Tipe jabatan harus diisi')
        return errors
    },
  },

  created () {
    this.SET_PROGRESSBAR(true)
    this.getPositions().then(() => {
        this.skeletonLoading = false;
        this.SET_PROGRESSBAR(false)
        this.hidden=false;
    });

    this.getSections();
  },

  destroyed(){
      this.hidden=true;
  },

  methods: {
    ...mapActions('section', ['getSections']),
    ...mapActions('position', ['getPositions', 'submitPosition', 'updatePosition', 'removePosition']),
    ...mapMutations('position', ['CLEAR_FORM', 'ASSIGN_FORM']),
    ...mapMutations(['SET_PROGRESSBAR']),

    closeDialog () {
        this.positionDialog = false;
        this.editedIndex = -1;
        this.name = '';
        this.code = '';
        this.section_id = '';
        this.type = '';
        this.CLEAR_FORM();
    },

    openRemoveDialog (item) {
        this.removeDialog = true;
        this.item = item;
    },

    deleteItem () {
        this.loading = true;
        this.disabledForm = true;
        this.deletedIndex = this.positions.data.indexOf(this.item);
        this.removePosition(this.positions.data[this.deletedIndex].id).then(() => {
            this.deletedIndex = '';
            this.item = [];
            this.loading = false;
            this.disabledForm = false;
            this.removeDialog = false;
        });
    },

    editItem (item) {
        this.editedIndex = this.positions.data.indexOf(item);
        this.code = this.positions.data[this.editedIndex].code;
        this.name = this.positions.data[this.editedIndex].name;
        this.section_id = this.positions.data[this.editedIndex].section_id;
        this.type = this.positions.data[this.editedIndex].type;
        this.positionDialog = true;
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
            this.position.code = this.code;
            this.position.name = this.name;
            this.position.section_id = this.section_id;
            this.position.type = this.type;

            //JIKA INDEX TIDAK ADA, MAKA GUNAKAN FUNSI SUBMIT SEKSI, JIKA ADA MAKA GUNAKAN FUNGSI UPDATE
            if(this.editedIndex === -1){
                this.submitPosition().then(() => {
                    this.closeDialog();
                    this.loading = false;
                    this.dialogProgressbar = false
                    this.disabledForm = false;
                    this.code = '';
                    this.name = '';
                    this.section_id = '';
                    this.type = '';
                    this.CLEAR_FORM();
                });
            }else{ 
                this.updatePosition(this.positions.data[this.editedIndex].id).then(() => {
                    this.getPositions();
                    this.closeDialog();
                    this.loading = false;
                    this.dialogProgressbar = false
                    this.disabledForm = false;
                    this.code = '';
                    this.name = '';
                    this.section_id = '';
                    this.type = '';
                    this.CLEAR_FORM();
                });
            } 
        }else{
            this.dialogProgressbar = false
        }
    }
  },
}
</script>