<template>

  <div class="text-center">
    <v-dialog v-model="dialog" width="100%" persistent>
      <template v-slot:activator="{ on, attrs }" >
        <v-btn
          class="mx-2 " 
          :title="tipo" 
          fab  
          outlined 
          x-small 
          v-bind="attrs"
          v-on="on"
          :color="(tipo == 'Nuevo')?'withe':'cyan'"
          @click="listar"
        >
            <v-icon v-if="(tipo == 'Modificando')" dark> mdi-pencil </v-icon>
            <v-icon v-else >mdi-plus</v-icon>
          
        </v-btn>
      </template>

      <v-card>
        <v-card-title class="blue lighten-1 text-white"> Sector </v-card-title>

        <v-card-text>
          <template>
            <v-form v-model="valid">
              <v-container>
                <v-row>    

                    <v-col cols="12" md="6">
                        <v-text-field
                            v-model="sector.nombre"
                            label="Nombre"
                            clearable
                        ></v-text-field>
                                    
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field
                            v-model="sector.detalle"
                            label="Descripción"
                            clearable
                        ></v-text-field>
                                    
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field
                            v-model="sector.estado"
                            label="Estado"
                            clearable
                        ></v-text-field>
                                    
                    </v-col>
                </v-row>
              
              </v-container>
            </v-form>
          </template>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <msjAlerta :msj="alerta"></msjAlerta>
          <v-btn color="primary" text @click="closealert()"> Salir </v-btn>
          <v-btn v-if="(tipo == 'Nuevo')" color="primary" text @click="guardar()"> Guardar </v-btn>
          <v-btn v-else color="primary" text @click="modificar()"> Modificar </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <loader :load="load"></loader>
  </div>
</template>
<script>
export default {
  props: ['tipo'],
  data() {
    return {
      dialog: false,
      alerta: { mensaje: "", visible: false, tipo: 0 },
      sector:{
              nombre:'', 
              detalle:'',
              estado:0
          },
    }
  },
  methods: {
        closealert() {
            this.dialog = false;
            this.alerta = { mensaje: "", visible: false, tipo: 0 };
            
        },
  },
}
</script>