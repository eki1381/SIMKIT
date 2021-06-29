import Vue from 'vue';
import Router from 'vue-router';
import Home from './components/pages/Home.vue';
import Login from './components/pages/Login.vue';
import store from './store.js';

import IndexSection from './components/pages/sections/Index.vue';
import DataSection from './components/pages/sections/Section.vue';

import IndexPosition from './components/pages/positions/Index.vue';
import DataPosition from './components/pages/positions/Position.vue';

import IndexUser from './components/pages/users/Index.vue';
import DataUser from './components/pages/users/User.vue';

import IndexActivity from './components/pages/activities/Index.vue';
import DataActivity from './components/pages/activities/Activity.vue';

import IndexAssignment from './components/pages/assignments/Index.vue';
import DataAssignment from './components/pages/assignments/Assignment.vue';

import IndexProcessing from './components/pages/processing/Index.vue';
import DataProcessing from './components/pages/processing/Processing.vue';

import IndexPersonScore from './components/pages/personscore/Index.vue';
import DataPersonScore from './components/pages/personscore/PersonScore.vue';

import IndexSectionScore from './components/pages/sectionscore/Index.vue';
import DataSectionScore from './components/pages/sectionscore/SectionScore.vue';

import IndexCalendar from './components/pages/calendar/Index.vue';
import DataCalendar from './components/pages/calendar/Calendar.vue';

import IndexRecapitulation from './components/pages/recapitulation/Index.vue';
import DataRecapitulation from './components/pages/recapitulation/Recapitulation.vue';

import IndexMonitoring from './components/pages/monitoring/Index.vue';
import DataMonitoring from './components/pages/monitoring/Monitoring.vue';

Vue.use(Router);

const router = new Router({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home,
            meta: {requiresAuth: true},
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
        },
        {
            path: '/users',
            component: IndexUser,
            meta: {requiresAuth: true},
            children: [
                {
                    path: '',
                    name: 'users.data',
                    component: DataUser,
                    meta: { title: 'Atur Pegawai' }
                },
            ]
        },
        {
            path: '/sections',
            component: IndexSection,
            meta: {requiresAuth: true},
            children: [
                {
                    path: '',
                    name: 'sections.data',
                    component: DataSection,
                    meta: { title: 'Atur Seksi' }
                },
            ]
        },
        {
            path: '/positions',
            component: IndexPosition,
            meta: {requiresAuth: true},
            children: [
                {
                    path: '',
                    name: 'positions.data',
                    component: DataPosition,
                    meta: { title: 'Atur Jabatan' }
                },
            ]
        },
        {
            path: '/activities',
            component: IndexActivity,
            meta: {requiresAuth: true},
            children: [
                {
                    path: '',
                    name: 'activities.data',
                    component: DataActivity,
                    meta: { title: 'Atur Master Kegiatan' }
                },
            ]
        },
        {
            path: '/assignments',
            component: IndexAssignment,
            meta: {requiresAuth: true},
            children: [
                {
                    path: '',
                    name: 'assignments.data',
                    component: DataAssignment,
                    meta: { title: 'Atur Tugas' }
                },
            ]
        },
        {
            path: '/processing',
            component: IndexProcessing,
            meta: {requiresAuth: true},
            children: [
                {
                    path: '',
                    name: 'processing.data',
                    component: DataProcessing,
                    meta: { title: 'Atur Tugas' }
                },
            ]
        },
        {
            path: '/personscore',
            component: IndexPersonScore,
            meta: {requiresAuth: true},
            children: [
                {
                    path: '',
                    name: 'personscore.data',
                    component: DataPersonScore,
                    meta: { title: 'Nilai Individu' }
                },
            ]
        },
        {
            path: '/sectionscore',
            component: IndexSectionScore,
            meta: {requiresAuth: true},
            children: [
                {
                    path: '',
                    name: 'sectionscore.data',
                    component: DataSectionScore,
                    meta: { title: 'Nilai Seksi' }
                },
            ]
        },
        {
            path: '/calendar',
            component: IndexCalendar,
            meta: {requiresAuth: true},
            children: [
                {
                    path: '',
                    name: 'calendar.data',
                    component: DataCalendar,
                    meta: { title: 'Kalender Kegiatan' }
                },
            ]
        },
        {
            path: '/recapitulation',
            component: IndexRecapitulation,
            meta: {requiresAuth: true},
            children: [
                {
                    path: '',
                    name: 'recapitulation.data',
                    component: DataRecapitulation,
                    meta: { title: 'Capaian Kinerja' }
                },
            ]
        },
        {
            path: '/monitoring',
            component: IndexMonitoring,
            meta: {requiresAuth: true},
            children: [
                {
                    path: '',
                    name: 'monitoring.data',
                    component: DataMonitoring,
                    meta: { title: 'Pemantauan' }
                },
            ]
        },
    ]
});

router.beforeEach((to,from,next) => {
    store.commit('CLEAR_ERRORS')
    if(to.matched.some(record => record.meta.requiresAuth)) {
        let auth = store.getters.isAuth;
        if(!auth){
            next({name: 'login'});
        }else{
            next();
        }
    }else{
        next();
    }
});

export default router;