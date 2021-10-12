<template>
<div class="d-flex flex-wrap">
        <v-btn text class="ma-2" outlined color="indigo" v-bind="attrs" v-on="on" @click="filtro('>')">
                En Proceso
          <v-icon dark right>
                 mdi-information-outline
          </v-icon>
        </v-btn>
        <v-btn text class="ma-2" outlined color="success" v-bind="attrs" v-on="on"  @click="filtro('=')">
                Completado
          <v-icon dark right>
                 mdi-check-circle-outline
          </v-icon>
        </v-btn>
        <v-btn text class="ma-2" outlined color="success" v-bind="attrs" v-on="on"  @click="filtro('')">
                Todos
          <v-icon dark right>
                mdi-all-inclusive
          </v-icon>
        </v-btn>
</div>
</template>
<script>
export default {
    props:['page', 'id','msj'],
    data() {
        return {
            on:'',
            attrs:'',

        }
    },
    methods: {
        filtro(oper){
        try {
            axios
            .get(this.page+"?operador="+ oper+'&id='+this.id+"&msj="+this.msj)
            .then((response) => {
                if (response.data.status == 0) {
                    this.$emit('objeto',response.data.data);
                } else {
                    console.log("error");
                }
            })
            .catch((error) => {
                console.log(error);
            })
            .finally(() => console.log(""));
        } catch (error) {
            console.log(error);
        }
        }
    },
}
</script>