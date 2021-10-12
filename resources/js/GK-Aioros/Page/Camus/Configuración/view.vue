
<template ref="ctacte_producto">
  <v-row justify="center" id="modalMenu" >
    <v-container fluid>
      <v-card>
        <v-toolbar class="sau-dataTable__title white--text" dark>
            <v-btn icon dark @click="closeModal">
                <v-icon >mdi-close</v-icon>
            </v-btn>
            <v-toolbar-title>Configuraciones </v-toolbar-title>
            <v-spacer></v-spacer>
        </v-toolbar>
        <v-card-text>
            
            <v-tabs
                color="deep-purple accent-4"
                right
            >
                <v-tab>Logs</v-tab>
                <v-tab>Zona</v-tab>
                <v-tab>Abstract</v-tab>

                <v-tab-item>
                    <v-container fluid>
                    <v-row>
                        <logs></logs>
                    </v-row>
                    </v-container>
                </v-tab-item>
                <v-tab-item>
                    <v-container fluid>
                    <v-row>
                        <v-list-item-content>
                            <v-text-field
                                v-model="nombrenuevo"

                                :counter="10"
                                label="Nombre Nuevo"
                                @keyup="guardar"
                                required>
                            </v-text-field>
                        </v-list-item-content>
                        <v-list-item-content style="height: 200px; overflow-y: auto;">
                            <template>
                                    
                                    <v-card
                                        class="mx-auto"
                                        max-width="500"
                                    >
                                        <v-list>
                                        <v-list-item-group v-model="model">
                                            <v-list-item
                                            v-for="(item, i) in itemZona"
                                            :key="i"
                                            :class="estadocolor(item)"
                                            style="overflow-y: scroll;"
                                            
                                            >
                                                <v-list-item-icon>
                                                    <v-icon v-if="item.estado == 0" v-text="'mdi-delete-circle-outline'"></v-icon>
                                                    <v-icon v-if="item.estado == 1" v-text="'mdi-check'"></v-icon>
                                                </v-list-item-icon>
                                                <v-list-item-content @click="eliminar(item.value)">
                                                    <v-list-item-title v-text="item.text"></v-list-item-title>
                                                </v-list-item-content>
                                                <v-list-item-icon>
                                                    <v-icon v-text="'mdi-pencil'" @click="modificar(item)"></v-icon>
                                                </v-list-item-icon>
                                            </v-list-item>
                                        </v-list-item-group>
                                        </v-list>
                                    </v-card>
                            </template>
                        </v-list-item-content>
                    </v-row>
                    </v-container>
                </v-tab-item>
            </v-tabs>
                    
        </v-card-text>

        <v-divider></v-divider>
        <v-card-text>
          <v-list-item-content>
            <msjAlerta :msj="alerta"></msjAlerta>
            
          </v-list-item-content>
        </v-card-text>
       
      </v-card>
    </v-container>  
    <loader :load="load"></loader>
  </v-row>
</template>
<script>
import logs from './logs'
    export default {
        props:['show', 'user', 'permiso'],
        data() {
            return {
               
                load:false,
                dialog: this.show,
                alerta: { mensaje: "", visible: false, tipo: 0 },
                object: [],
                nombrenuevo:'',
                itemZona: [
                        
                    ],
                model: 1,
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
                    (v) => /^[0-9,]{1,16}$/.test(v) || "Valor no Valido",
                    ],
                },
            
            };
        } ,
        components:{
            logs
        },
        created() {
            this.permiso = JSON.parse (this.permiso)
            this.combozona()
        },
        methods: {
            closeModal: function () {
                this.$emit("close", false);
            },
            combozona(){
                try {
                    axios
                    .get("home/Camus/util/Zona/combozona")
                    .then((response) => {
                        this.itemZona = response.data;
                    })
                    .catch((error) => {
                        console.log(error);
                    })
                    .finally(() => console.log(""));
                } catch (error) {
                    console.log(error);
                }
            },
            estadocolor(i){
                if (i.estado != 1){
                    return 'text-danger'
                }else if (i.estado != 0){
                    return 'text-success'
                }
                
            },
            guardar(key){
                let param = {'nombre':this.nombrenuevo};
                if (key.keyCode == 13){
                    try {
                        this.load=true
                        axios
                        .post('home/Camus/util/Zona/data', param)
                        .then((response) => {
                                
                                this.alerta.mensaje=''   
                                if (response.data.status == 0) {
                                    //alerta//
                                    this.alerta.mensaje = response.data.descripcion;
                                    this.alerta.tipo = 1;
                                    this.alerta.visible = true;
                                    
                                    this.combozona();
                                    
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
                }else{
                    this.alerta.mensaje += 'día:[No Existe el día]' + ' - '  
                    this.alerta.tipo = 9;
                    this.alerta.visible = true;
                } 
            },
            eliminar(v){
                try {
                    this.load=true
                    axios
                    .put('home/Camus/util/Zona/data/'+v)
                    .then((response) => {
                            
                            this.alerta.mensaje=''   
                            if (response.data.status == 0) {
                                //alerta//
                                this.alerta.mensaje = response.data.descripcion;
                                this.alerta.tipo = 1;
                                this.alerta.visible = true;
                                
                                this.combozona();
                                
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
            modificar(m){
                
            }
        },  
    }
</script>