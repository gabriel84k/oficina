<template>
<v-subheader>
        <v-btn text class="ma-2" outlined color="indigo" v-bind="attrs" v-on="on" @click="filtro(3)">
                Finalizado
          <v-icon dark right>
                 mdi-information-outline
          </v-icon>
        </v-btn>
        <v-btn text class="ma-2" outlined color="success" v-bind="attrs" v-on="on"  @click="filtro(0)">
                Iniciado
          <v-icon dark right>
                 mdi-check-circle-outline
          </v-icon>
        </v-btn>
        <v-btn text class="ma-2" outlined color="success" v-bind="attrs" v-on="on"  @click="filtro(9)">
                Todos
          <v-icon dark right>
                mdi-all-inclusive
          </v-icon>
        </v-btn>
</v-subheader>
</template>
<script>
export default {
    props:['page', 'msj'],
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
                .get(this.page+"?tipo="+ oper+'&id='+"&msj="+this.msj)
                .then((response) => {
                    if (response.data.status == 0) {
                        this.$emit('objeto',[response.data.data,oper]);
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