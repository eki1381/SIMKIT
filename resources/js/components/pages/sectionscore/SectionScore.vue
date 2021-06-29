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
        <v-toolbar src="https://simkit.bpsanambas.com/landingpage.png" color="blue" class="box-shadow-card">
            <v-row> 
                <v-col cols="6" sm="6" md="3" lg="3">
                    <v-select
                        v-model="monthSelected"
                        flat
                        solo
                        hide-details
                        :items="months"
                        item-text="name"
                        item-value="id"
                        class="font-weight-bold"
                        dense
                        label="Pilih Bulan"
                        @change="loadData">
                    </v-select>
                </v-col>
            </v-row>
        </v-toolbar>
        <v-skeleton-loader
            :loading="skeletonLoading"
            :transition="'fade-transition'"
            class="box-shadow-card"
            type="table">
            <v-data-table 
                :headers="headers" 
                :items="sectionscores.data" 
                :items-per-page="7"
                :sort-desc.sync="sortDesc"
                class="box-shadow-card overflow-hidden font-weight-bold">
                <template v-slot:item.score="{ item }">
                    <v-chip :color="getColorStatus(item.score)" dark small>{{item.score != null ? item.score.final_score : 'N/A'}}</v-chip>
                </template>
            </v-data-table>
        </v-skeleton-loader>
    </div>
</template>

<script>
import { mapActions, mapState, mapMutations } from 'vuex';

export default {
  name: 'DataUser',
  data: () => ({
    breadcrumbs: [
        {
            text: 'Penilaian',
            disabled: true,
        },
        {
            text: 'Capaian Kinerja',
            disabled: true,
        },
    ],

    name: '',
    email: '',
    password: '',
    ein: '',
    position_id: '',

    userDialog: false,
    removeDialog: false,
    item: [],
    headers: [
        {
            text: 'SEKSI',
            align: 'start',
            sortable: false,
            value: 'name',
            width: '80%',
        },
        { text: 'NILAI', value: 'score', align: 'center', width: '20%' },
    ],
    months: [
        {id: 1, name: 'Januari'},
        {id: 2, name: 'Februari'},
        {id: 3, name: 'Maret'},
        {id: 4, name: 'April'},
        {id: 5, name: 'Mei'},
        {id: 6, name: 'Juni'},
        {id: 7, name: 'Juli'},
        {id: 8, name: 'Agustus'},
        {id: 9, name: 'September'},
        {id: 10, name: 'Oktober'},
        {id: 11, name: 'November'},
        {id: 12, name: 'Desember'},
    ],
    monthSelected: '',
    editedIndex: -1,
    deletedIndex: '',
    skeletonLoading: true,
    loading: false,
    disabledForm: false,
    show: false,
    sortDesc: true,
  }),

    computed: {
        ...mapState('sectionscore', {sectionscores: state => state.sections}),
        ...mapState('sectionscore', {month: state => state.month}),
    },

    created () {
        this.monthSelected = this.months[new Date().getMonth()].id
        this.SET_MONTH(this.monthSelected)
        this.loadData()
    },

    methods: {
        ...mapActions('sectionscore', ['getSectionScores']),
        ...mapMutations('sectionscore', ['SET_MONTH']),
        ...mapMutations(['SET_PROGRESSBAR']),

        getColorStatus(payload){
            if(payload != null){
                if(payload.final_score >= 3.5){
                    return "green";
                }else if(payload.final_score < 3.5 && payload.final_score >= 2.0){
                    return "orange";
                }else if(payload.final_score < 2.0){
                    return "red";
                }
            }else{
                return "grey";
            }   
        },
        loadData(){
            this.skeletonLoading = true
            this.SET_PROGRESSBAR(true)
            this.SET_MONTH(this.monthSelected)
            this.getSectionScores().then(() => {
                this.skeletonLoading = false
                this.SET_PROGRESSBAR(false)
            });
        }
    }
}
</script>