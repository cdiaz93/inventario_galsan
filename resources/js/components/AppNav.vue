<template>
    <v-sheet height="400" class="overflow-hidden col-md-12" style="position: relative;">


        <div class="col-md-12 my-2 px-0">
            <v-btn color="pink" right dark @click.stop="drawer = !drawer">   <v-app-bar-nav-icon></v-app-bar-nav-icon>  </v-btn>

        </div>



        <v-navigation-drawer v-model="drawer" absolute temporary>
            <v-list-item>
                <v-list-item-avatar>
                <v-img src="https://randomuser.me/api/portraits/men/78.jpg"></v-img>
                </v-list-item-avatar>

                <v-list-item-content>
                <v-list-item-title>John Leider</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-divider></v-divider>

            <v-list dense>
                <v-list-item  link>
                <v-list-item-icon>
                    <v-icon>mdi-view-dashboard</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title> Home </v-list-item-title>
                </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>
    </v-sheet>
</template>

<script>

    import RecordTable from '../components/RecordTable.vue';


  export default {

    components: {
        RecordTable,

    },


    data () {
      return {
        drawer: null,
        items: [
          { title: 'Home', icon: 'mdi-view-dashboard' },
          { title: 'About', icon: 'mdi-forum' },
        ],
      }
    },
  }
</script>
