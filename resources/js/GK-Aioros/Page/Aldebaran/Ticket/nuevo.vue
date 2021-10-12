<template>
    <div class="text-center">
        <v-dialog v-model="dialog" width="100%">
            <template v-slot:activator="{ on, attrs }">
                <v-btn
                class="mx-2" 
                :title="tipo" 
                fab  
                outlined 
                x-small 
                v-bind="attrs"
                v-on="on"
                @click="limpiar"
                :color="(tipo == 'Nuevo')?'withe':'cyan'"
                >
                <v-icon v-if="(tipo != 'Nuevo')" dark> mdi-pencil </v-icon>
                <v-icon v-else >mdi-plus</v-icon>
                </v-btn>
            </template>
                <v-card>
                    <v-card-title class="blue lighten-1 text-white"> {{tipo}} Ticket</v-card-title>
                        <v-card-text>
                            <template>
                                <v-form v-model="valid">
                                    <v-container>
                                        <v-row>
                                            <v-col cols="12" md="4">
                                                <v-combobox
                                                    :items="itemSistema"
                                                    item-value="id"
                                                    item-text="nombre"
                                                    v-model="obj.sistema"
                                                    :search-input.sync="search"
                                                    hide-selected
                                                    hint=""
                                                    label="Seleccione Sistema con Problema"
                                                    :allow-overflow="false"
                                                    :return-object="true"
                                                    persistent-hint
                                                    small-chips
                                                    
                                                    >
                                                    <template v-slot:no-data>
                                                    <v-list-item>
                                                        <v-list-item-content>
                                                        <v-list-item-title>
                                                            No existen resulstados "<strong>{{
                                                            search
                                                            }}</strong
                                                            >"
                                                        </v-list-item-title>
                                                        </v-list-item-content>
                                                    </v-list-item>
                                                    </template>
                                                </v-combobox>
                                            </v-col>
                                            <v-col cols="12" md="4">
                                                <v-combobox
                                                    :items="itemPrioridad"
                                                    item-value="id"
                                                    item-text="nombre"
                                                    v-model="obj.prioridad"
                                                    :search-input.sync="search"
                                                    hide-selected
                                                    hint=""
                                                    label="Seleccione Prioridad del Reclamo"
                                                    :allow-overflow="false"
                                                    :return-object="true"
                                                    persistent-hint
                                                    small-chips
                                                    
                                                    >
                                                    <template v-slot:no-data>
                                                    <v-list-item>
                                                        <v-list-item-content>
                                                        <v-list-item-title>
                                                            No existen resulstados "<strong>{{
                                                            search
                                                            }}</strong
                                                            >"
                                                        </v-list-item-title>
                                                        </v-list-item-content>
                                                    </v-list-item>
                                                    </template>
                                                </v-combobox>
                                            </v-col>
                                             <v-col cols="12" md="4">
                                               <v-text-field
                                                    v-model="obj.nota"
                                                    :rules="rules"
                                                    counter="25"
                                                    hint="Ingrese el nombre del cliente"
                                                    label="Regular"
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col cols="12" md="12">
                                                <v-text-field
                                                    v-model="obj.ticket_detalle.titulo"
                                                    :rules="rules"
                                                    counter="25"
                                                    hint="This field uses counter prop"
                                                    label="Regular"
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col cols="12" md="12">
                                                <ckeditor :editor="editor" 
                                                        :config="editorConfig"
                                                        v-model="obj.ticket_detalle.detalle"
                                                        label="Detalle del Problema"
                                                        outlined
                                                        name="input-7-4"
                                                        style="height: 5cm;"
                                                ></ckeditor>
                                                
                                            </v-col>
                                            
                                        </v-row>
                                       
                                    </v-container>
                                </v-form>
                            </template>
                        </v-card-text>
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

import ClassicEditor from '@ckeditor/ckeditor5-build-classic';



export default {
    
    props:['ticket','tipo'],
    data() {
        return {
            editor: ClassicEditor,
            editorConfig:{
                
            },
            dialog: false,
            load:false,
            search: "",
            page: "/home/Aldebaran/Ticket/data",
            alerta: { mensaje: "", visible: false, tipo: 0 },
            valid: false,
            itemSistema:[],
            itemPrioridad:[{nombre:'Baja',id:1},{nombre:'Media',id:2},{nombre:'Alta',id:3},{nombre:'Urgente',id:4},],
            obj:{  
                estado:"",
                nota:'',
                cliente_id:0,
                prioridad:'',
                sistema:0,
                ticket_detalle:{
                        tipo:'', 
                        titulo:'', 
                        detalle:'', 
                }
            },
        }
    },
    watch:{
        dialog(val){
            if (val){
                if (this.ticket.estado !== undefined){
                    this.obj={     
                        estado:this.ticket.estado, 
                        prioridad:this.ticket.prioridad, 
                        cliente_id:this.ticket.cliente_id, 
                        sistema_id:this.ticket.sistema_id,
                        ticket_detalle:{
                                tipo:'', 
                                titulo:'', 
                                detalle:'', 
                        }
                    }
                }else{
                    this.obj={      
                        estado:0, 
                        prioridad:0, 
                        cliente_id:0,
                        sistema_id:0,
                        ticket_detalle:{
                                tipo:'', 
                                titulo:'', 
                                detalle:'', 
                        }
                    }
                    this.combosistema()
                }
            }
        }
    },
    
    methods: {
        
        combosistema(){
            try {
                axios
                .get('/home/Aldebaran/Sistema/data')
                .then((response) => {
                    if (response.data.status == 0) {
                        this.itemSistema = response.data.data.data;
                        
                    } else {
                    
                    }
                })
                .catch((error) => {
                    console.log(error);
                })
                .finally(() => console.log(""));
            } catch (error) {
                console.log(error);
            }
        },
        
        guardar(){
            let param = this.obj;
            this.load=true
            try {
                axios
                .post(this.page, param)
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
        modificar(){
            let param = this.obj;
            this.load=true
            try {
                axios
                .put(this.page +"/"+ this.sistema.id, param)
                .then((response) => {
                    this.alerta.mensaje = ''
                    if (response.data.status == 0) {
                        //alerta//
                        this.alerta.mensaje = "Se Modifico correctamente el Usuario.";
                        this.alerta.tipo = 2;
                        this.alerta.color = 'success';
                        this.alerta.visible = true;
                        
                    } else {
                        if (response.data.descripcion != ""){
                            this.alerta.mensaje = response.data.descripcion;
                        }else{
                            
                            var errors = JSON.stringify(response.data.errors)
                                                .replace('name','nombre')
                                                .replace('_',' ')
                                                .replace('{','')
                                                .replace('}','')
                                                .split(',')
                            errors.forEach(element => {
                                
                                this.alerta.mensaje += element + ' - '       
                            });
                            this.alerta.tipo = 2;
                            this.alerta.color = 'error';
                            this.alerta.visible = true;
                        }
                    }
                })
                .catch((error) => {
                    console.log(error);
                    this.load=false
                })
                .finally(() => this.load=false);
            } catch (error) {
                console.log(error);
                this.load=false
            }
        },
        closealert() {
            this.dialog = false;
            this.alerta = { mensaje: "", visible: false, tipo: 0 };
        },
        refresh(){
            this.$emit('refresh','cliente')
        },
       
        limpiar(){
            this.obj={  nombre:"",
                        empresa:'', 
                        nota:"",
            }
        },
        closealert(){
            this.dialog=false
        }
        
    },

}
</script>