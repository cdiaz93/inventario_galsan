<template>


    <div id="app">
        <!--  Inicializador de Vuetify 2.7  -->
       <v-app>
            <!-- Componente de tabla -->

            <record-table></record-table>
        </v-app>

    </div>
</template>

<script>
    import RecordTable from '../components/RecordTable.vue';

    export default {
        components: {
            RecordTable,

        },

        data() {
            return {}
        },
    }
</script>
