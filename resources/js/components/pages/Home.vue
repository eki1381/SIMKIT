<template>
    <v-container>
        <v-row>
            <v-col cols="12" sm="12" md="12" lg="12">
                <v-skeleton-loader
                    :loading="skeletonLoading"
                    :transition="'fade-transition'"
                    type="image"
                    class="box-shadow-card">
                    <v-card color="blue" class="elevation-0 overflow-hidden box-shadow-card">
                        <v-img src="https://simkit.bpsanambas.com/landingpage.png">
                            <v-row>
                                <v-col class="text-center">
                                    <v-avatar color="blue darken-1" size="56">
                                        <v-icon dark>mdi-trophy</v-icon>
                                    </v-avatar>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col class="text-center">
                                    <div :class="`text-h5`" class="white--text font-weight-medium">Selamat datang</div>
                                    <div :class="`text-h5`" class="white--text font-weight-bold">{{ authenticatedUser.name }}</div>
                                </v-col>
                            </v-row>
                        </v-img>
                    </v-card>
                </v-skeleton-loader>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12" sm="12" md="6" lg="6">
                <v-skeleton-loader
                    :loading="skeletonLoading"
                    :transition="'fade-transition'"
                    type="image"
                    class="box-shadow-card">
                    <v-card height="300" class="elevation-0 overflow-hidden box-shadow-card">
                        <v-card-title class="blue--text font-weight-bold">
                            Penyelesaian Tugas
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on, attrs }">
                                    <v-icon class="ml-2" color="blue" v-bind="attrs" v-on="on">mdi-help-circle-outline</v-icon>
                                </template>
                                <span>Persentase jumlah tugas yang selesai dan belum selesai</span>
                            </v-tooltip>
                        </v-card-title>
                        <v-card-text>
                            <v-row justify="center">
                                <div id="chart">
                                    <apexchart 
                                        type="pie"
                                        width="450"
                                        :options="finishChartOptions"
                                        :series="finishChartSeries"></apexchart>
                                </div>
                            </v-row>
                        </v-card-text>
                    </v-card>
                </v-skeleton-loader>
            </v-col>
            <v-col cols="12" sm="12" md="6" lg="6">
                <v-skeleton-loader
                    :loading="skeletonLoading"
                    :transition="'fade-transition'"
                    type="image"
                    class="box-shadow-card">
                    <v-card height="300" class="elevation-0 overflow-hidden box-shadow-card">
                        <v-card-title class="blue--text font-weight-bold">
                            Bidang Tugas
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on, attrs }">
                                    <v-icon class="ml-2" color="blue" v-bind="attrs" v-on="on">mdi-help-circle-outline</v-icon>
                                </template>
                                <span>Persentase bidang tugas yang diberikan</span>
                            </v-tooltip>
                        </v-card-title>
                        <v-card-text>
                            <v-row justify="center">
                                <div id="chart">
                                    <apexchart 
                                        type="donut" 
                                        class="mx-auto" 
                                        width="250" 
                                        :options="sectionChartOptions" 
                                        :series="sectionChartSeries"></apexchart>
                                </div>
                            </v-row>
                        </v-card-text>
                    </v-card>
                </v-skeleton-loader>
            </v-col>
        </v-row>
        <v-row justify="center">
            <v-col cols="12" sm="12" md="6" lg="6">
                <v-skeleton-loader
                    :loading="skeletonLoading"
                    :transition="'fade-transition'"
                    type="image"
                    class="box-shadow-card">
                    <v-card height="430" class="elevation-0 overflow-hidden box-shadow-card">
                        <v-card-title class="blue--text font-weight-bold">
                            <v-row>
                                <v-col cols="12" sm="12" md="6" lg="6">
                                    Nilai Seksi
                                    <v-tooltip bottom>
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-icon class="ml-2" color="blue" v-bind="attrs" v-on="on">mdi-help-circle-outline</v-icon>
                                        </template>
                                        <span>Akumulasi nilai setiap seksi</span>
                                    </v-tooltip>
                                </v-col>
                                <v-spacer></v-spacer>
                                <v-col cols="12" sm="12" md="6" lg="4">
                                    <v-select
                                        v-model="month"
                                        :items="months"
                                        item-text="name"
                                        item-value="id"
                                        label="Pilih bulan"
                                        @change="refreshDashboard"
                                        solo></v-select>
                                </v-col>
                            </v-row>
                        </v-card-title>
                        <v-card-text>
                            <v-row justify="center">
                                <div id="chart">
                                    <apexchart 
                                        type="bar" 
                                        width="450" 
                                        :options="sectionScoreChartOptions" 
                                        :series="sectionScoreChartOptions.series"></apexchart>
                                </div>
                            </v-row>
                        </v-card-text>
                    </v-card>
                </v-skeleton-loader>
            </v-col>
            <v-col cols="12" sm="12" md="6" lg="6">
                <v-skeleton-loader
                    :loading="skeletonLoading"
                    :transition="'fade-transition'"
                    type="image"
                    class="box-shadow-card">
                    <v-card
                        class="mx-auto elevation-0 box-shadow-card"
                        height="430">
                            <v-toolbar
                                color="white"
                                flat
                                class="elevation-1">
                                <v-app-bar-nav-icon class="ml-1">
                                    <v-avatar size="42px">
                                        <v-tooltip bottom>
                                            <template v-slot:activator="{ on, attrs }">
                                                <v-img
                                                    :src="authenticatedUser.photo"
                                                    v-bind="attrs"
                                                    v-on="on"></v-img>
                                            </template>
                                            <span>Cuma foto</span>
                                        </v-tooltip>
                                    </v-avatar>
                                </v-app-bar-nav-icon>
                                <v-spacer></v-spacer>
                                <v-toolbar-title>
                                    <v-tooltip bottom>
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-icon 
                                                size="34"
                                                color="cyan"
                                                v-bind="attrs"
                                                v-on="on">mdi-bird</v-icon>
                                        </template>
                                        <span>Logo ini ada matanya</span>
                                    </v-tooltip>
                                </v-toolbar-title>
                                <v-spacer></v-spacer>
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn 
                                            icon
                                            v-bind="attrs"
                                            v-on="on">
                                            <v-icon size="30" color="cyan">mdi-weather-night</v-icon>
                                        </v-btn>
                                    </template>
                                    <span>Cuma hiasan</span>
                                </v-tooltip>
                            </v-toolbar>
                            <v-list class="list-scroll" three-line>
                                <template v-for="(item, index) in assignments">
                                        <v-divider
                                            :key="index"></v-divider>
                                        <v-list-item
                                            :key="item.created_at"
                                            v-if="item.is_finished == 'Belum selesai'">
                                            <v-list-item-avatar>
                                                <v-img :src="item.user_from.photo"></v-img>
                                            </v-list-item-avatar>
                                            <v-list-item-content>
                                                <v-list-item-title>
                                                    <span class="font-weight-bold">{{ item.user_from.name }}</span>
                                                    <v-icon color="blue" small>mdi-check-decagram</v-icon>
                                                    <span class="text-body-2">@{{ item.user_from.email.substr(0, item.user_from.email.length-10) }}</span>
                                                    <v-spacer></v-spacer>
                                                    <time-ago class="text-right" :refresh="60" :datetime="new Date(item.updated_at)" locale="id"></time-ago>
                                                </v-list-item-title>
                                                <v-list-item-subtitle class="font-weight-medium text-subtitle-1">
                                                    {{ item.name }}
                                                    <span class="cyan--text" hover>@{{ item.user_to.email.substr(0, item.user_to.email.length-10) }}</span>
                                                </v-list-item-subtitle>
                                            </v-list-item-content>
                                        </v-list-item>
                                        <v-list-item
                                            :key="item.created_at"
                                            v-else-if="item.is_finished == 'Menunggu pengecekan'">
                                            <v-list-item-avatar>
                                                <v-img :src="item.user_to.photo"></v-img>
                                            </v-list-item-avatar>
                                            <v-list-item-content>
                                                <v-list-item-title>
                                                    <span class="font-weight-bold">{{ item.user_to.name }}</span>
                                                    <v-icon color="blue" small>mdi-check-decagram</v-icon>
                                                    <span class="text-body-2">@{{ item.user_to.email.substr(0, item.user_to.email.length-10) }}</span>
                                                    <v-spacer></v-spacer>
                                                    <time-ago class="text-right" :refresh="60" :datetime="new Date(item.updated_at)" locale="id"></time-ago>
                                                </v-list-item-title>
                                                <v-list-item-subtitle class="font-weight-medium text-subtitle-1">
                                                    {{ item.name }} sudah dikerjakan, silakan dicek kk!
                                                    <span class="cyan--text" hover>@{{ item.user_from.email.substr(0, item.user_from.email.length-10) }}</span>
                                                </v-list-item-subtitle>
                                            </v-list-item-content>
                                        </v-list-item>
                                        <v-list-item
                                            :key="item.created_at"
                                            v-else-if="item.is_finished == 'Sudah selesai'">
                                            <v-list-item-avatar>
                                                <v-img :src="item.user_from.photo"></v-img>
                                            </v-list-item-avatar>
                                            <v-list-item-content>
                                                <v-list-item-title>
                                                    <span class="font-weight-bold">{{ item.user_from.name }}</span>
                                                    <v-icon color="blue" small>mdi-check-decagram</v-icon>
                                                    <span class="text-body-2">@{{ item.user_from.email.substr(0, item.user_from.email.length-10) }}</span>
                                                    <v-spacer></v-spacer>
                                                    <time-ago class="text-right" :refresh="60" :datetime="new Date(item.updated_at)" locale="id"></time-ago>
                                                </v-list-item-title>
                                                <v-list-item-subtitle class="font-weight-medium text-subtitle-1">
                                                    Mantap! {{ item.name }} sudah oke, makasih ya!
                                                    <span class="cyan--text" hover>@{{ item.user_to.email.substr(0, item.user_to.email.length-10) }}</span>
                                                </v-list-item-subtitle>
                                            </v-list-item-content>
                                        </v-list-item>
                                    </template>
                                    </v-list>
                                </v-card>
                </v-skeleton-loader>
            </v-col>
        </v-row>
    </v-container>
</template>
<script>
    import { mapActions, mapState, mapMutations, mapGetters } from 'vuex'
    import firebase from "firebase/app"
    import "firebase/messaging"
    import VueApexCharts from 'vue-apexcharts'
    import TimeAgo from 'vue2-timeago'

    export default {
        components: {
            apexchart: VueApexCharts,
            TimeAgo,
        },
        data: () => ({
            token: '',
            skeletonLoading : false,

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
            month: '',

            assignments: [],

            finishChartSeries: [],
            sectionChartSeries: [],
            sectionScoreChartSeries: [],

            finishChartOptions: {
                chart: {
                    fontFamily: 'Quicksand, sans-serif',
                    toolbar: {
                        show: false
                    }
                },
                labels: ['Belum selesai', 'Menunggu pengecekan', 'Sudah selesai'],
                colors: ['#F03A47', '#FFBA49', '#02C39A'],
                legend: {
                    fontSize: '14px',
                    fontWeight: 800,
                },
                dataLabels: {
                    enabled: false,
                },
                responsive: [{
                    breakpoint: 500,
                    options: {
                        chart: {
                            width: 275
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }],
                noData: {
                    text: 'Belum ada data'
                }
            },

            sectionChartOptions: {
                chart: {
                    fontFamily: 'Quicksand, sans-serif',
                    toolbar: {
                        show: false
                    }
                },
                labels: [],
                colors: [],
                legend: {
                    show: false,
                    position: 'bottom'
                },
                dataLabels: {
                    enabled: false,
                },
                responsive: [{
                    breakpoint: 500,
                    options: {
                        chart: {
                            width: 275
                        },
                    }
                }],
                noData: {
                    text: 'Belum ada data'
                }
            },

            sectionScoreChartOptions: {
                chart: {
                    type: 'bar',
                    height: 350,
                    toolbar: {
                        show: false
                    }
                },
                series: [],
                colors: [],
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    show: false,
                    categories: [],
                    labels: {
                        show: false,
                        style: {
                            fontSize: '12px',
                            fontFamily: 'Quicksand, sans-serif',
                            fontWeight: '800'
                        },
                    },
                },
                yaxis: {
                    min: 0.0,
                    max: 4.0,
                    labels: {
                        style: {
                            fontSize: '12px',
                            fontFamily: 'Quicksand, sans-serif',
                        },
                    },
                },
                grid: {
                    show: false,
                },
                fill: {
                    opacity: 1
                },
                responsive: [{
                    breakpoint: 500,
                    options: {
                        chart: {
                            horizontal: true,
                            width: 275
                        },
                        plotOptions: {
                            bar: {
                                horizontal: true
                            }
                        },
                        yaxis: {
                            labels: {
                                minWidth: 0,
                                maxWidth: 100,
                            }
                        }
                    }
                }],
                noData: {
                    text: 'Belum ada data'
                }
            },
        }),
        created(){
            this.month = this.months[new Date().getMonth()].id

            this.SET_PROGRESSBAR(true)
            this.skeletonLoading = true
            const messaging = firebase.messaging()
            messaging.getToken().then((token) => {
                this.storeRegToken(token)
            })
            .catch((err) => {
                console.log('An error occurred while retrieving token. ', err);
            })

            this.getHome(this.month).then(() => {
                this.finishChartSeries = this.dashboard.data.finish_chart
                this.sectionChartSeries = this.dashboard.data.section_chart[0]
                this.sectionScoreChartOptions.series = [{
                    name: 'Nilai Seksi',
                    data: this.dashboard.data.section_score_chart[0],
                }]

                this.sectionChartOptions.labels = this.dashboard.data.section_chart[1]
                this.sectionChartOptions.colors = this.dashboard.data.section_chart[2]

                this.assignments = this.dashboard.data.recent_assignment[0]

                this.skeletonLoading = false
                this.SET_PROGRESSBAR(false)
            })
        },
        mounted() {
            this.interval = setInterval(() => {
                this.getHome(this.month).then(() => {
                    this.finishChartSeries = this.dashboard.data.finish_chart
                    this.sectionChartSeries = this.dashboard.data.section_chart[0]
                    this.sectionScoreChartOptions.series = [{
                        name: 'Nilai Seksi',
                        data: this.dashboard.data.section_score_chart[0],
                    }]

                    this.sectionChartOptions.labels = this.dashboard.data.section_chart[1]
                    this.sectionChartOptions.colors = this.dashboard.data.section_chart[2]

                    this.assignments = this.dashboard.data.recent_assignment[0]
                })
            },10000)
        },
        destroyed() {
            clearInterval(this.interval)
        },
        computed: {
            ...mapState('user', {authenticatedUser: state => state.authenticated}),
            ...mapState('home', {dashboard: state => state.dashboard}),
        },
        methods: {
            ...mapActions('home', ['storeRegToken']),
            ...mapActions('home', ['getHome']),
            ...mapMutations(['SET_PROGRESSBAR', 'SET_VSNACKBAR']),

            refreshDashboard(){
                this.getHome(this.month).then(() => {
                    this.finishChartSeries = this.dashboard.data.finish_chart
                    this.sectionChartSeries = this.dashboard.data.section_chart[0]
                    this.sectionScoreChartOptions.series = [{
                        name: 'Nilai Seksi',
                        data: this.dashboard.data.section_score_chart[0],
                    }]

                    this.sectionChartOptions.labels = this.dashboard.data.section_chart[1]
                    this.sectionChartOptions.colors = this.dashboard.data.section_chart[2]

                    this.assignments = this.dashboard.data.recent_assignment[0]
                })
            }
        }
    }
</script>
<style scoped>
    .list-scroll{
        height:366px;/* or any height you want */
        overflow-y:auto
    }
</style>