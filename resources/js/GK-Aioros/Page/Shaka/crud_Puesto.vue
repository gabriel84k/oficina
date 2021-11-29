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
         
        >
            <v-icon v-if="(tipo == 'Modificando')" dark outlined> mdi-pencil </v-icon>
            <v-icon v-else outlined>mdi-plus</v-icon>
          
          
        </v-btn>
      </template>

      <v-card>
        <v-card-title class="blue lighten-1 text-white">{{tipo}} Puesto </v-card-title>

        <v-card-text>
          <template>
            <v-form v-model="valid">
              <v-container>
                <v-row>    

                    <v-col cols="12" md="6">
                        <v-text-field
                            v-model="vpuesto.nombre"
                            label="Nombre"
                            clearable
                        ></v-text-field>
                                    
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field
                            v-model="vpuesto.descripcion"
                            label="Descripción"
                            clearable
                        ></v-text-field>
                                    
                    </v-col>
                    <v-col cols="12" md="6">
                      
                        <v-select
                          v-model="vpuesto.estado"
                          :items="itemsEstado"
                          :rules="[v => !!v || 'Se requiere un Estado']"
                          label="Estado"
                          required
                        ></v-select>
                                    
                    </v-col>
                    <v-col cols="12" md="6">
                      <v-container fluid>
                        <v-combobox
                          v-model="vpuesto.sector"
                          :items="itemsSector"
                          :search-input.sync="search"
                          :hint="'Sector que se asocia al Pesto'"
                          hide-selected
                          label="Seleccionar Sector"
                          single-line
                          return-object
                          persistent-hint
                          small-chips
                          item-text="nombre"
                          item-value="id"
                        >
                          <template v-slot:no-data>
                            <v-list-item>
                              <v-list-item-content>
                                <v-list-item-title>
                                  No results matching "<strong>{{ search }}</strong>". Press <kbd>enter</kbd> to create a new one
                                </v-list-item-title>
                              </v-list-item-content>
                            </v-list-item>
                          </template>
                        </v-combobox>
                      </v-container>
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
          <v-btn v-if="(tipo == 'Nuevo')" color="primary" text @click="nuevo(vpuesto.page)"> Guardar </v-btn>
          <v-btn v-else color="primary" text @click="modificacion(vpuesto.page +'/'+vpuesto.id)"> Modificar </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <loader :load="load"></loader>
  </div>
</template>
<script>
export default {
  name: 'CrudPuesto',
  props: ['puesto','tipo'],
  data() {
    return {
      itemsSector: [{ nombre: '', id: '' }],
      itemsEstado: ['Activo', 'Inactivo'],
      dialog:false,
      search: null,
      load:false,
      valid:true,
      page:'/home/Shaka/Red/Sector/listaCombobox',

      alerta: { mensaje: "", visible: false, tipo: 0 },
      vpuesto:{
              id:'',
              nombre:'', 
              descripcion:'',
              estado:[],
              sector:'',
              page:'/home/Shaka/Red/Puesto/data'
          },
      
    }
  },
  watch:{
    puesto(p){
      this.vpuesto.nombre = this.puesto.nombre
      this.vpuesto.descripcion = this.descripcion
      
    },
    
  },
  mounted() {
    this.listSector()
    console.log('puesto mount',this.puesto)
    this.vpuesto.id = this.puesto.id
    this.vpuesto.nombre = this.puesto.nombre
    this.vpuesto.descripcion = this.puesto.descripcion
    if (this.puesto.estado  == 1){ 
      this.vpuesto.estado = 'Activo'
    }else{
      this.vpuesto.estado = 'Inactivo'
    }
    
  },
  methods: {
        nuevo(page){
            let formData = new FormData();
            formData.append('nombre', this.vpuesto.nombre)
            formData.append('descripcion', this.vpuesto.descripcion)
            formData.append('estado', this.vpuesto.estado)
            formData.append('sector_id', this.vpuesto.sector.id)
            
            this.load=true
            try {
                axios
                .post(page, formData)
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
        modificacion(page){
            this.load=true
            let param = this.vpuesto
            param.sector_id = this.vpuesto.sector.id
            delete param.sector
            try {
                axios
                .put(page, param)
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
        listSector(){
          axios.get(this.page)
                .then((response) => {
                    this.itemsSector = response.data
                }).catch((error) => {
                
                })
                .finally(() => false);
        },
        closealert() {
            this.puesto.visible = false;
            this.dialog = false;
            this.alerta = { mensaje: "", visible: false, tipo: 0 };
            
        },
  },
}
</script>