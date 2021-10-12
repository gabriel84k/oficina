<template>
    <div class="row">
      <div class="col-4" v-for="(item,index) in obj" :key="index">
        <v-card class="mx-auto" max-width="344" outlined >
            <v-list-item three-line>
                <v-list-item-content>
                    <v-list-item-title class="text-h5 mb-1">
                       {{item.texto}}
                    </v-list-item-title>
                </v-list-item-content>

                <v-list-item-avatar tile size="80" text >
                    <v-btn elevation="2" fab outlined text color="red" >{{item.val}}</v-btn>
                </v-list-item-avatar>
            </v-list-item>
          </v-card>
      </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            obj:{
                0:{texto:'Total Cliente', val:0},
                1:{texto:'Total Usuarios', val:0},
                2:{texto:'Total Presupuesto', val:0}
            }
        }
    },

}
</script>