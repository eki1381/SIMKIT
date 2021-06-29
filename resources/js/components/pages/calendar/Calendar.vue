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
                <v-btn
                    color="white"
                    class="blue--text ml-5 font-weight-bold"
                    elevation="2"
                    @click="setToday">Hari ini</v-btn>
                <v-spacer></v-spacer>
                <v-btn fab small color="white" elevation="2" @click="$refs.calendar.prev()">
                    <v-icon color="blue" raised>mdi-chevron-left</v-icon>
                </v-btn>
                <span class="ml-3 font-weight-bold text-h5 white--text" v-if="$refs.calendar" v-html="$refs.calendar.title"></span>
                <v-btn fab small color="white" elevation="2" @click="$refs.calendar.next()" class="ml-3">
                    <v-icon color="blue" raised>mdi-chevron-right</v-icon>
                </v-btn>
                <v-spacer></v-spacer>
                <v-col cols="6" sm="6" md="3" lg="3">
                    <v-spacer></v-spacer>
                    <v-select
                        v-model="user_id"
                        :items="users.data"
                        item-text="name"
                        item-value="id"
                        @change="loadCalendar"
                        dense
                        solo
                        flat
                        hide-details
                        class="ma-2 font-weight-bold"
                        label="Pegawai"></v-select>
                </v-col>
            </v-row>
        </v-toolbar>
        <v-card class="elevation-0 overflow-hidden box-shadow-card">
            <v-row>
                <v-col>
                    <v-skeleton-loader
                        :loading="skeletonLoading"
                        :transition="'fade-transition'"
                        class="box-shadow-card"
                        type="table">
                        <v-sheet class="overflow-hidden box-shadow-card" height="520">
                            <v-calendar
                                class="overflow-hidden box-shadow-card font-weight-bold"
                                ref="calendar"
                                v-model="calendar"
                                color="primary"
                                locale="id"
                                :events="events"
                                :event-color="getEventColor"
                                :event-overlap-threshold="30"></v-calendar>
                        </v-sheet>
                    </v-skeleton-loader>
                </v-col>
            </v-row>
        </v-card>
    </div>
</template>

<script>
import { mapActions, mapState, mapMutations } from 'vuex';
export default {
    name: 'DataCalendar',
  
    data: () => ({
        breadcrumbs: [
            {
                text: 'Utama',
                disabled: true,
            },
            {
                text: 'Kalender Kegiatan',
                disabled: true,
            },
        ],

        calendar: '',
        user_id: '',
        skeletonLoading: true,

        title: ''
    }),

    created () {
        this.SET_PROGRESSBAR(true)
        this.skeletonLoading = true
        this.getUsers().then(() => {
            this.getUserLogin().then(() => {
                this.user_id = this.authenticatedUser.id
                this.getAssignmentsByUserTo(this.authenticatedUser.id).then(() => {
                    this.getEvents().then(() => {
                        this.skeletonLoading = false
                        this.SET_PROGRESSBAR(false)
                    })
                })
            })
        })
    },

    computed: {
        ...mapState('calendar', {users: state => state.users}),
        ...mapState('calendar', {assignments: state => state.assignments}),
        ...mapState('calendar', {events: state => state.events}),
        ...mapState('user', {authenticatedUser: state => state.authenticated}),
    },

    methods: {
        ...mapActions('calendar', ['getUsers', 'getAssignmentsByUserTo', 'getEvents']),
        ...mapActions('user', ['getUserLogin']),
        ...mapMutations(['SET_PROGRESSBAR']),

        getEventColor (event) {
            return event.color
        },

        setToday (){
            this.calendar = ''
        },

        loadCalendar(){
            this.SET_PROGRESSBAR(true)
            this.skeletonLoading = true
            this.getAssignmentsByUserTo(this.user_id).then(() => {
                this.getEvents().then(() => {
                    this.skeletonLoading = false
                    this.SET_PROGRESSBAR(false)
                })
            })
        }
    }
}
</script>