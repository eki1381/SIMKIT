<template>
    <v-snackbar
        absolute
        top
        right
        dark
        :timeout="5000" 
        class="justify-center white--text"
        :value="!!snackbar['message']" 
        :color="snackbar['type']"
        @input="closeAlert" >
        {{ snackbar['message'] }}
        <template v-slot:action="{ attrs }">
            <v-btn
            color="white"
            text
            v-bind="attrs"
            @click="closeAlert">
            Tutup
            </v-btn>
        </template>
    </v-snackbar>
    
</template>

<script>
    import { mapState, mapMutations, mapActions } from "vuex";

    export default {
        computed: {
            ...mapState(['snackbar'])
        },
        methods: {
            ...mapMutations(['SET_SNACKBAR', 'CLEAR_SNACKBAR']),

            closeAlert(val) {
                this.SET_SNACKBAR({});
            }
        }
    };
</script>