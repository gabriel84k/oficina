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
          :color="(tipo == 'Nuevo')?'green':'cyan'"
          @click="listar"
        >
            <v-icon v-if="(tipo == 'Modificando')" dark outlined> mdi-pencil </v-icon>
            <v-icon v-else outlined>mdi-plus</v-icon>
          
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
                            v-model="vsector.nombre"
                            label="Nombre"
                            clearable
                        ></v-text-field>
                                    
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field
                            v-model="vsector.detalle"
                            label="Descripción"
                            clearable
                        ></v-text-field>
                                    
                    </v-col>
                    <v-col cols="12" md="6">
                         <v-select
                          v-model="vsector.estado"
                          :items="items"
                          :rules="[v => !!v || 'Se requiere un Item']"
                          label="Item"
                          required
                        ></v-select>
                                    
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
          <v-btn v-if="(tipo == 'Nuevo')" color="primary" text @click="nuevo()"> Guardar </v-btn>
          <v-btn v-else color="primary" text @click="modificar()"> Modificar </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <loader :load="load"></loader>
  </div>
</template>
<script>
export default {
  props: ['sector','tipo'],
  data() {
    return {
     
      alerta: { mensaje: "", visible: false, tipo: 0 },
      vsector:{
              nombre:'', 
              detalle:'',
              estado:0
          },
      items:['Activo','Inactivo']
    }
  },
  watch:{
    sector(s){
      this.dialog = s.visible
    }
  },
  methods: {
        nuevo(){
          
          
            let formData = new FormData();
            formData.append('nombre', this.vsector.nombre)
            formData.append('descripcion', this.vsector.detalle)
            formData.append('estado', this.vsector.estado)
            
            this.load=true
            try {
                axios
                .post(this.sector.page, formData)
                .then((response) => {
                    
                    if (response.data.status == 0) {
                        //alerta//
                        this.alerta.mensaje = response.data.descripcion;
                        this.alerta.tipo = 2;
                        this.alerta.color = 'success';
                        this.alerta.visible = true;
                        this.refresh();
                    } else {
                        if (response.data.descripcion != ""){
                            this.alerta.mensaje = response.data.descripcion;
                        }else{
                            this.alerta.mensaje = funciones.errorjson(response.data.errors)    
                        }
                            this.alerta.tipo = 2;
                            this.alerta.color = 'error';
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
      
        },
        closealert() {
            this.sector.visible = false;
            this.dialog = false;
            this.alerta = { mensaje: "", visible: false, tipo: 0 };
            
        },
  },
}
</script>