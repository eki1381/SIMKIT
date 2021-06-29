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
            <v-row align="center">
                <v-col xs="6" sm="6" md="3" lg="3" xl="3">
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
                <v-spacer></v-spacer>
                <v-btn
                    color="white"
                    class="ma-2 blue--text font-weight-bold mr-3"
                    :loading="downloadLoading"
                    @click="downloadCkp">Unduh
                    <v-icon
                        right
                        dark>mdi-arrow-down-bold-circle-outline</v-icon>
                    </v-btn>
            </v-row>
        </v-toolbar>
        <v-skeleton-loader
            :loading="skeletonLoading"
            :transition="'fade-transition'"
            class="box-shadow-card"
            type="table">
            <v-data-table 
                :headers="headers" 
                :items="assignments.data" 
                :items-per-page="7"
                :sort-desc.sync="sortDesc"
                class="overflow-hidden box-shadow-card font-weight-bold">
                <template v-slot:item.interval="{ item }">
                    {{ getInterval(item.start_date, item.collect_date) }} hari
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

        item: [],
        headers: [
            {
                text: 'KEGIATAN',
                align: 'start',
                sortable: false,
                value: 'name',
            },
            { text: 'TARGET', value: 'volume', align: 'center' },
            { text: 'REALISASI', value: 'realization', align: 'center' },
            { text: 'SATUAN VOLUME', value: 'activity.volumeUnit', align: 'center' },
            { text: 'WAKTU', value: 'interval', align: 'center' },
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
        intervals:{
            day: 1000 * 60 * 60 * 24
        },
        monthSelected: '',
        skeletonLoading: true,
        loading: false,
        downloadLoading: false,
        disabledForm: false,
        show: false,
        sortDesc: true,
    }),

    computed: {
        ...mapState('recapitulation', {assignments: state => state.assignments}),
        ...mapState('user', {authenticatedUser: state => state.authenticated}),
    },

    created () {
        this.SET_PROGRESSBAR(true)
        this.monthSelected = this.months[new Date().getMonth()].id
        this.getUserLogin().then(() => {
            this.getRecapitulation({user: this.authenticatedUser.id, month: this.monthSelected}).then(() => {
                this.skeletonLoading = false
                this.SET_PROGRESSBAR(false)
            })
        })
    },

    methods: {
        ...mapActions('recapitulation', ['getRecapitulation', 'downloadRecapitulation']),
        ...mapActions('user', ['getUserLogin']),
        ...mapMutations(['SET_PROGRESSBAR']),
        ...mapMutations('recapitulation', ['SET_PARAMETERS']),

        getInterval(start, end){
            let diff = Math.abs(new Date(end) - new Date(start))
            let days = Math.floor(diff / this.intervals.day)+1
            return days
        },

        loadData(){
            this.SET_PROGRESSBAR(true)
            this.skeletonLoading = true
            this.getRecapitulation({user: this.authenticatedUser.id, month: this.monthSelected}).then(() => {
                this.skeletonLoading = false
                this.SET_PROGRESSBAR(false)
            })
        },

        downloadCkp(){
            this.downloadLoading = true
            this.downloadRecapitulation({
                id: this.authenticatedUser.id,
                ein: this.authenticatedUser.ein,
                name: this.authenticatedUser.name,
                position: this.authenticatedUser.position.name,
                period: this.months[this.monthSelected-1].name + ' ' + '2020',
                month: this.monthSelected, 
                section_id: this.authenticatedUser.section_id
            }).then(() => {
                this.downloadLoading = false
            })
        }
    }
}
</script>