<template>
    <div class="container">
        <section class="content">
            <div class="row">
                <v-container>
                    <router-view></router-view>
                </v-container>
            </div>
        </section>
    </div>
</template>
<script>
    import Breadcrumb from '../../Breadcrumb.vue'
    export default {
        name: 'IndexProcessing',
        components: {
            'breadcrumb': Breadcrumb
        }
    }
</script>