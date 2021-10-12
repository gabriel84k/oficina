<template>
 <div class="text-center">
    <v-dialog
      v-model="dialog"
      width="500"
    >
      <template v-slot:activator="{ on, attrs }">
        <v-btn
            class="mx-2 " 
            title= "Editar"
            fab  
            outlined 
            x-small 
            dark
            v-bind="attrs"
            v-on="on"
            color="cyan"
        >
          <v-icon color="cyan">mdi-pencil</v-icon>
        </v-btn>
      </template>

      <v-card>
        <v-card-title class="headline grey lighten-2">
          Editar Detalle Ctacte
        </v-card-title>

        <v-card-text>
            <br/><br/>
           <v-row id="editrow">
                <v-col cols="12" md="2">
                    {{ctacteDetalle.id}}
                </v-col>
                <v-col cols="12" md="5">
                     <v-menu
                    v-model="menu"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    transition="scale-transition"
                    offset-y
                    min-width="auto"
                  >
                    <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                          v-model="ctacteDetalle.Fecha"
                          label="Fecha de la Venta"
                          prepend-icon="mdi-calendar"
                          hint="MM/DD/YYYY format"
                          persistent-hin
                          v-bind="attrs"
                          v-on="on"
                      ></v-text-field>
                    </template>
                    <v-date-picker
                        v-model="ctacteDetalle.Fecha"
                        no-title
                        @input="menu = false"
                    ></v-date-picker>
                  </v-menu>
                </v-col>
                <v-col cols="12" md="5">
                    <v-text-field
                      v-model="ctacteDetalle.Pago"
                      :rules="Rules.decimalRules"
                      label="Monto de la Cuota"
                      required
                      prefix="$"
                    ></v-text-field>
                    
                </v-col>

            </v-row>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
            <msjAlerta :msj="alerta"></msjAlerta>
          <v-spacer></v-spacer>
          <v-btn
            color="primary"
            text
            @click="editar(ctacteDetalle.id)"
          >
            Modificar
          </v-btn>
          <v-btn
            color="primary"
            text
            @click="dialog = false"
          >
            Salir
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
     <loader :load="load"></loader>
  </div>

</template>
<script>
export default {
    props:['ctacteDetalle'],
    data() {
        return {
            page:'home/Camus/ctactedetalle/data',
            object:[],
            load:false,
            menu:false,
            dialog: false,
            alerta: { mensaje: "", visible: false, tipo: 0 },
            Rules: {
                nameRules: [
                (v) => !!v || "Este Campo es requerido",
                (v) => v.length <= 10 || "Name must be less than 10 characters",
                ],
                numberRules: [
                (v) => !!v || "Solo Valores numéricos",
                (v) => /^[0-9]{1,16}$/.test(v) || "Valor no Valido",
                ],
                decimalRules: [
                (v) => !!v || "Solo Valores numéricos",
                (v) => /^[0-9.]{1,16}$/.test(v) || "Valor no Valido",
                ],
            },
        }
    },
    created() {
        
    },
    methods: {
        editar(id){
            try {
                this.load=true
                
                axios
                .put(this.page+'/'+id,this.ctacteDetalle)
                .then((response) => {
                    if (response.data.status == 0) {
                        this.object = response.data.data;
                        this.alerta.mensaje = response.data.descripcion;
                        this.alerta.tipo = 1;
                        this.alerta.visible = true;
                         this.$emit('refresh','')
                    } else {
                        if (response.data.descripcion != ""){
                        this.alerta.mensaje =response.data.descripcion;
                        }else{
                        var errors = JSON.stringify(response.data.errors)
                                            .replace('_',' ')
                                            .replace('{','')
                                            .replace('}','')
                                            .split(',')
                        errors.forEach(element => {
                            this.alerta.mensaje += element + ' - '       
                        });
                        }
                        this.alerta.tipo = 9;
                        this.alerta.visible = true;
                    
                        
                    }
                })
                .catch((error) => {
                    console.log(error);
                    this.load=false
                })
                .finally(() => this.load=false);
            } catch (error) {
                console.log(error);
            }
        }
    }
}
</script>
<style scoped>

#editrow{
  white-space: nowrap;
  vertical-align: middle;
}

</style>