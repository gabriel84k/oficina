<template>
<v-subheader>
    <v-row>
        <v-col cols="12"  sm="6">
            <v-menu
            v-model="menu1"
            :close-on-content-click="false"
            :nudge-right="40"
            transition="scale-transition"
            offset-y
            min-width="auto"
        >
            <template v-slot:activator="{ on, attrs }">
            <v-text-field
                v-model="fdesde"
                label="Fecha Desde"
                prepend-icon="mdi-calendar"
                readonly
                v-bind="attrs"
                v-on="on"
            ></v-text-field>
            </template>
            <v-date-picker
            v-model="fdesde"
            @change="filtro"
            @input="menu1 = false"
            ></v-date-picker>
            </v-menu>
        </v-col>
        <v-col cols="12"  sm="6" >
            <v-menu
            v-model="menu2"
            :close-on-content-click="false"
            :nudge-right="40"
            transition="scale-transition"
            offset-y
            min-width="auto"
        >
            <template v-slot:activator="{ on, attrs }">
            <v-text-field
                v-model="fhasta"
                label="Fecha Hasta"
                prepend-icon="mdi-calendar"
                readonly
                v-bind="attrs"
                v-on="on"
            ></v-text-field>
            </template>
            <v-date-picker
            v-model="fhasta"
            @change="filtro"
            @input="menu2 = false"
            ></v-date-picker>
            </v-menu>
        </v-col>
    </v-row>
</v-subheader>
</template>
<script>
export default {
    props:['param', 'id'],
    data() {
        return {
            fdesde: new Date().toISOString().substr(0, 10),
            fhasta: new Date().toISOString().substr(0, 10),
            menu1: false,
            menu2: false,
        }
    },
    methods: {
        filtro(){
            try {
                axios
                .get(this.page+"?fdesde="+ this.fdesde + "&fhasta="+ this.fhasta +'&id='+this.id+"&msj="+this.param.msj)
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