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
        <v-card-title class="blue lighten-1 text-white"> Albun </v-card-title>

        <v-card-text>
          <template>
            <v-form v-model="valid">
              <v-container>
                <v-row>    

                    <v-col cols="12" md="6">
                        <v-text-field
                            v-model="albun.titulo"
                            label="Título"
                            clearable
                        ></v-text-field>
                                    
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field
                            v-model="albun.descripcion"
                            label="Descripción"
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
            menu: false,
            search: "",
            load:false,
            page: "/home/Ikki/Albun/data",
            alerta: { mensaje: "", visible: false, tipo: 0 },
            albun:{
                titulo:'', 
                descripcion:'',
            },
            valid: false,
        };
    },
    methods: {
        
        guardar() {
            
            let formData = new FormData();
            formData.append('titulo', this.albun.titulo)
            formData.append('descripcion', this.albun.descripcion)
            try {
                this.load=true
                axios
                .post(this.page, formData)
                .then((response) => {
                        
                        this.alerta.mensaje=''   
                        if (response.data.status == 0) {
                            //alerta//
                            this.alerta.mensaje = response.data.descripcion;
                            this.alerta.tipo = 1;
                            this.alerta.visible = true;
                            this.refresh();
                            
                        } else {
                            if (response.data.descripcion != ""){
                                this.alerta.mensaje = response.data.descripcion;
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
                    
                    this.load=false
                })
                .finally(() => this.load=false);
            } catch (error) {
                console.log(error);
            } 
        
            
        }, 
        closealert() {
            this.dialog = false;
            this.alerta = { mensaje: "", visible: false, tipo: 0 };
            
        },
        refresh(){
            this.$emit('refresh')
        },
        
    }
};

</script>