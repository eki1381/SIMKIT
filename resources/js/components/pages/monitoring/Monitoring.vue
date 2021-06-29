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
                <v-col cols="6" sm="6" md="3" lg="3">
                    <v-select
                        v-model="section_id"
                        :disabled="disabledSelect"
                        :items="sections.data"
                        item-text="name"
                        item-value="id"
                        @input="loadTable"
                        dense
                        solo
                        flat
                        hide-details
                        class="font-weight-bold"
                        label="Pilih seksi"></v-select>
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
                :items="assignments.data"
                :items-per-page="7"
                item-key="id"
                @click:row="showDetailAssignment"
                class="overflow-hidden font-weight-bold box-shadow-card">
                <template v-slot:item.start_date="{ item }">
                    <span>{{ item.start_date | formatDate }}</span>
                </template>
                <template v-slot:item.finish_date="{ item }">
                    <span v-if="item.is_finished !== 'Sudah selesai'">{{ item.finish_date | formatDate }}</span>
                    <span v-else>{{ item.collect_date | formatDate }}</span>
                </template>
                <template v-slot:item.realization="{ item }">
                    <v-progress-linear
                        color="red"
                        height="13"
                        :value="item.realization/item.volume*100"
                        striped
                        v-if="item.is_finished === 'Belum selesai'">
                        <template v-slot="{ value }">
                            <strong>{{ Math.ceil(value) }}%</strong>
                        </template>
                    </v-progress-linear>

                    <v-progress-linear
                        color="orange"
                        height="13"
                        :value="item.realization/item.volume*100"
                        striped
                        v-else-if="item.is_finished === 'Menunggu pengecekan'">
                        <template v-slot="{ value }">
                            <strong>{{ Math.ceil(value) }}%</strong>
                        </template>
                    </v-progress-linear>

                    <v-progress-linear
                        color="green"
                        height="13"
                        :value="100"
                        striped
                        v-else>
                        <template v-slot="{ value }">
                            <strong>{{ Math.ceil(value) }}%</strong>
                        </template>
                    </v-progress-linear>
                </template>
            </v-data-table>
        </v-skeleton-loader>
        <v-dialog v-model="detailAssignmentDialog" persistent max-width="500px">
            <v-card>
                <v-toolbar flat light>
                    <v-toolbar-title class="blue--text font-weight-bold">Detail Tugas</v-toolbar-title>
                </v-toolbar>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col cols="4">
                                <span class="text-body-1 font-weight-bold">Nama</span>
                            </v-col>
                            <v-col cols="1">
                                <span class="text-body-1 font-weight-bold">:</span>
                            </v-col>
                            <v-col cols="7">
                                <span class="text-body-1 font-weight-bold">{{ assignment.name }}</span>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="4">
                                <span class="text-body-1 font-weight-bold">Pelaksana</span>
                            </v-col>
                            <v-col cols="1">
                                <span class="text-body-1 font-weight-bold">:</span>
                            </v-col>
                            <v-col cols="7">
                                <span class="text-body-1 font-weight-bold">{{ assignment.user_to }}</span>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="4">
                                <span class="text-body-1 font-weight-bold">Realisasi</span>
                            </v-col>
                            <v-col cols="1">
                                <span class="text-body-1 font-weight-bold">:</span>
                            </v-col>
                            <v-col cols="7">
                                <span class="text-body-1 font-weight-bold">{{ assignment.realization }}</span>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="4">
                                <span class="text-body-1 font-weight-bold">Tanggal Mulai</span>
                            </v-col>
                            <v-col cols="1">
                                <span class="text-body-1 font-weight-bold">:</span>
                            </v-col>
                            <v-col cols="7">
                                <span class="text-body-1 font-weight-bold">{{ assignment.start_date | formatDate }}</span>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="4">
                                <span class="text-body-1 font-weight-bold">Tanggal Selesai</span>
                            </v-col>
                            <v-col cols="1">
                                <span class="text-body-1 font-weight-bold">:</span>
                            </v-col>
                            <v-col cols="7">
                                <span class="text-body-1 font-weight-bold">{{ assignment.finish_date | formatDate }}</span>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="4">
                                <span class="text-body-1 font-weight-bold">Status</span>
                            </v-col>
                            <v-col cols="1">
                                <span class="text-body-1 font-weight-bold">:</span>
                            </v-col>
                            <v-col cols="7">
                                <v-chip v-if="assignment.is_finished === 'Belum selesai'" color="red" dark label small class="font-weight-bold">{{ assignment.is_finished }}</v-chip>
                                <v-chip v-else-if="assignment.is_finished === 'Menunggu pengecekan'" color="orange" dark label small class="font-weight-bold">{{assignment.is_finished}}</v-chip>
                                <v-chip v-else color="green" dark label small class="font-weight-bold">{{assignment.is_finished}}</v-chip>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="detailAssignmentDialog = false">Tutup</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
    import { mapActions, mapState, mapMutations } from 'vuex'

    export default {
        name: 'DataUser',
    
        data: () => ({
            breadcrumbs: [
                {
                    text: 'Utama',
                    disabled: true,
                },
                {
                    text: 'Pemantauan',
                    disabled: true,
                },
            ],

            skeletonLoading : false,
            detailAssignmentDialog : false,

            section_id: '',
            disabledSelect: false,

            assignment: {
                name: '',
                user_to: '',
                volume: '',
                realization: '',
                start_date: '',
                finish_date: '',
                is_finished: '',
            },
            
            headers : [
                { text: 'TUGAS', value: 'name', sortable: false, width: '20%' },
                { text: 'PELAKSANA', value: 'user_to.name', align: 'center', sortable: false, width: '20%' },
                { text: 'TANGGAL MULAI', value: 'start_date', align: 'center', sortable: false, width: '20%' },
                { text: 'TANGGAL SELESAI', value: 'finish_date', align: 'center', sortable: false, width: '20%' },
                { text: 'PROGRESS', value: 'realization', align: 'center', sortable: false, width: '20%' },
            ],
        }),

        created () {
            this.SET_PROGRESSBAR(true)
            this.skeletonLoading = true
            this.getUserLogin().then(() => {
                if(this.authenticatedUser.position.type == 2){
                    this.disabledSelect = true
                    this.section_id = this.authenticatedUser.position.section_id
                    this.getSections().then(() => {
                        this.loadTable()
                    })
                }else{
                    this.getSections().then(() => {
                        this.skeletonLoading = false
                        this.SET_PROGRESSBAR(false)
                    })
                }
            })
        },

        destroyed () {
            this.CLEAR_SECTIONS()
            this.CLEAR_ASSIGNMENTS()
        },

        computed: {
            ...mapState('user', {authenticatedUser: state => state.authenticated}),
            ...mapState('monitoring', {sections: state => state.sections}),
            ...mapState('monitoring', {assignments: state => state.assignments}),
        },

        methods: {
            ...mapActions('user', ['getUserLogin']),
            ...mapActions('monitoring', ['getSections', 'getAssignments']),
            ...mapMutations('monitoring', ['CLEAR_ASSIGNMENTS', 'CLEAR_SECTIONS']),
            ...mapMutations(['SET_PROGRESSBAR']),

            loadTable(){
                this.skeletonLoading = true
                this.SET_PROGRESSBAR(true)
                this.getAssignments(this.section_id).then(() => {
                    this.skeletonLoading = false
                    this.SET_PROGRESSBAR(false)
                })
            },

            showDetailAssignment(item){
                this.assignment.name = item.name
                this.assignment.user_to = item.user_to.name

                if(item.realization === null){
                    this.assignment.realization = '0' +' dari '+ item.volume + ' ' + item.activity.volumeUnit
                }else{
                    this.assignment.realization = item.realization +' dari '+ item.volume+ ' ' + item.activity.volumeUnit
                }

                this.assignment.start_date = item.start_date

                if(item.is_finished === "Sudah selesai"){
                    this.assignment.finish_date = item.collect_date
                }else{
                    this.assignment.finish_date = item.finish_date
                }

                this.assignment.is_finished = item.is_finished
                
                
                this.detailAssignmentDialog = true
            },
        }
    }
</script>