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
        <v-toolbar src="https://simkit.bpsanambas.com/landingpage.png" color="blue darken-1">
            <v-row>
                <v-col cols="6" sm="6" md="3" lg="3">
                    <v-select
                        v-model="monthSelected"
                        flat
                        solo
                        hide-details
                        :items="months"
                        item-text="name"
                        class="font-weight-bold"
                        item-value="id"
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
                :items="personscores.data" 
                :items-per-page="7"
                :sort-desc.sync="sortDesc"
                class="overflow-hidden box-shadow-card font-weight-bold">
                <template v-slot:item.photo="{ item }">
                    <v-avatar class="ma-1">
                        <v-img :src="item.photo"></v-img>
                    </v-avatar>                
                </template>
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
            text: 'Individu',
            disabled: true,
        },
    ],
    
    item: [],
    headers: [
        { text: '', value: 'photo', sortable: false, width: '5%' },
        {
            text: 'NAMA',
            align: 'start',
            sortable: false,
            value: 'name',
            width: '75%',
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
    deletedIndex: '',
    skeletonLoading: true,
    loading: false,
    disabledForm: false,
    show: false,
    sortDesc: true,
  }),

  computed: {
    ...mapState('personscore', {personscores: state => state.users}),
    ...mapState('personscore', {month: state => state.month}),
  },

  created () {
        this.monthSelected = this.months[new Date().getMonth()].id
        this.SET_MONTH(this.monthSelected)
        this.loadData()
  },

  methods: {
    ...mapActions('personscore', ['getPersonScores']),
    ...mapMutations('personscore', ['SET_MONTH']),
    ...mapMutations(['SET_PROGRESSBAR']),

    getColorStatus(payload){
        if(payload != null){
            if(payload.final_score >= 3.0){
                return "green";
            }else if(payload.final_score < 3.0 && payload.final_score >= 2.0){
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
        this.getPersonScores().then(() => {
            this.skeletonLoading = false
            this.SET_PROGRESSBAR(false)
        })
    }
}
}
</script>