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
    <v-dialog v-model="sectionDialog" persistent max-width="500px">
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
                v-model="name"
                :error-messages="nameErrors"
                prepend-icon="mdi-format-text-variant"
                required
                dense
                @input="$v.name.$touch()"
                @blur="$v.name.$touch()"
                label="Nama Seksi">
              </v-text-field>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12" sm="12" md="12">
              <v-text-field 
                type="number"
                :disabled="disabledForm"
                v-model="code"
                prepend-icon="mdi-numeric"
                :error-messages="codeErrors"
                required
                dense
                @input="$v.code.$touch()"
                @blur="$v.code.$touch()"
                label="Kode Seksi">
              </v-text-field>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12" sm="12" md="12">
              <v-menu
                :close-on-content-click="false"
                transition="scale-transition"
                offset-y
                max-width="290px"
                min-width="290px">
                <template v-slot:activator="{ on, attrs }">
                  <v-text-field
                    v-model="color"
                    label="Warna"
                    persistent-hint
                    prepend-icon="mdi-eyedropper"
                    v-bind="attrs"
                    v-on="on"></v-text-field>
                </template>
                <v-color-picker
                  v-model="color"
                  class="ma-2"
                  hide-mode-switch></v-color-picker>
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
    <v-skeleton-loader
        :loading="skeletonLoading"
        :transition="'fade-transition'"
        class="box-shadow-card"
        type="table">
        <v-data-table 
          :headers="headers"
          :items="sections.data"
          class="overflow-hidden box-shadow-card font-weight-bold"
          :items-per-page="7">
            <template v-slot:top>
                <v-toolbar flat>
                    <v-toolbar-title class="blue--text"><h4>Seksi</h4></v-toolbar-title>
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
import { required,minLength,maxLength } from 'vuelidate/lib/validators'

export default {
  validations: {
      name: { required },
      code: { required, minLength: minLength(5), maxLength: maxLength(5) },
      color: { required },
  },
  
  data: () => ({
    breadcrumbs: [
            {
                text: 'Master',
                disabled: true,
            },
            {
                text: 'Seksi',
                disabled: true,
            },
        ],

    name: '',
    code: '',
    color: '',

    sectionDialog: false,
    removeDialog: false,
    item: [],
    headers: [
      { text: 'KODE', value: 'code', width: '20%' },
      {
        text: 'SEKSI',
        align: 'start',
        sortable: false,
        value: 'name',
        width: '60%',
      },
      { text: '', value: 'actions', align: 'center', sortable: false, width: '20%' },
    ],
    editedIndex: -1,
    deletedIndex: '',
    loading: false,
    skeletonLoading: true,
    dialogProgressbar: false,
    disabledForm: false,
    hidden: true,
  }),

  computed: {
    ...mapState('section', {sections: state => state.sections}),
    ...mapState('section', {section: state => state.section}),

    formTitle () {
      return this.editedIndex === -1 ? 'Tambah Seksi' : 'Ubah Seksi'
    },
    
    nameErrors () {
      const errors = []
      if (!this.$v.name.$dirty) return errors
      !this.$v.name.required && errors.push('Nama seksi harus diisi')
      return errors
    },

    codeErrors () {
      const errors = []
      if (!this.$v.code.$dirty) return errors
      !this.$v.code.minLength && errors.push('Kode seksi harus terdiri dari 5 karakter')
      !this.$v.code.maxLength && errors.push('Kode seksi harus terdiri dari 5 karakter')
      !this.$v.code.required && errors.push('Kode seksi harus diisi')
      return errors
    },

    colorErrors () {
      const errors = []
      if (!this.$v.color.$dirty) return errors
      !this.$v.color.required && errors.push('Warna harus diisi')
      return errors
    }
  },

  watch: {
    search() {
      this.getSections(this.search)
    },
  },

  created () {
    this.SET_PROGRESSBAR(true)
    this.getSections().then(() => {
      this.skeletonLoading = false
      this.SET_PROGRESSBAR(false)
      this.hidden=false
    });
  },

  destroyed(){
    this.hidden=true;
  },

  methods: {
    ...mapActions('section', ['getSections', 'removeSection']),
    ...mapActions('section', ['submitSection']),
    ...mapMutations('section', ['CLEAR_FORM', 'ASSIGN_FORM']),
    ...mapActions('section', ['editSection', 'updateSection']),
    ...mapMutations(['SET_PROGRESSBAR']),

    editItem (item) {
      this.editedIndex = this.sections.data.indexOf(item)
      this.name = this.sections.data[this.editedIndex].name
      this.code = this.sections.data[this.editedIndex].code
      this.color = this.sections.data[this.editedIndex].color
      this.sectionDialog = true
    },

    openRemoveDialog (item) {
      this.removeDialog = true
      this.item = item
    },

    deleteItem () {
      this.loading = true
      this.disabledForm = true
      this.deletedIndex = this.sections.data.indexOf(this.item)
      this.removeSection(this.sections.data[this.deletedIndex].id).then(() => {
        this.deletedIndex = ''
        this.item = []
        this.loading = false
        this.disabledForm = false
        this.removeDialog = false
      });
    },

    closeDialog () {
      this.editedIndex = -1;
      this.sectionDialog = false;
      this.name = '';
      this.code = '';
      this.color = '';
      this.CLEAR_FORM();
    },

    //FUNGSI UNTUK MENYIMPAN DATA SEKSI
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
        this.section.name = this.name;
        this.section.code = this.code;
        this.section.color = this.color;

        //JIKA INDEX TIDAK ADA, MAKA GUNAKAN FUNSI SUBMIT SEKSI, JIKA ADA MAKA GUNAKAN FUNGSI UPDATE
        if(this.editedIndex === -1){
          this.submitSection().then(() => {
            this.closeDialog();
            this.loading = false;
            this.dialogProgressbar = false
            this.disabledForm = false;
            this.name = '';
            this.code = '';
            this.color = '';
            this.CLEAR_FORM();
          });
        }else{ 
          this.updateSection(this.sections.data[this.editedIndex].id).then(() => {
            this.getSections();
            this.closeDialog();
            this.loading = false;
            this.dialogProgressbar = false
            this.disabledForm = false;
            this.name = '';
            this.code = '';
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