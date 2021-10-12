<template>
    <div class="text-center">
        <v-dialog v-model="dialog" width="100%">
            <template v-slot:activator="{ on, attrs }">
                <v-btn
                    v-if="true"
                    elevation="14"
                    outlined
                    x-small
                    color="teal darken-1"
                    v-bind="attrs"
                    v-on="on"
                >
                    <v-icon> mdi-eye-outline </v-icon>
                </v-btn>
            </template>
           
            <v-card>
                <v-card-title class="blue lighten-1 text-white"> 
                    Detalle Ticket N°: {{ticket.id}} 
                    <v-spacer></v-spacer>
                    <div class="v-timeline-item__dot--small">
                        <div class="v-timeline-item__inner-dot pink">
                        </div>
                    </div> 
                    {{ticket.cliente.nombre}}</v-card-title>
                    <v-card-text>
                        <div class="row">
                            <div class="col-4">
                                <template>
                                    <br>
                                    <v-card width="100%" >
                                        <v-card-title class="blue lighten-1 text-white"> Responder </v-card-title>
                                        <v-card-text>
                                            <br>
                                            <v-text-field
                                                v-model="detalleticket.titulo"
                                                counter="50"
                                                hint="Asunto"
                                                label="Coloque asunto del ticket"
                                            ></v-text-field>
                                            <br>
                                            <ckeditor :editor="editor" 
                                                outlined
                                                v-model="detalleticket.detalle"
                                                name="input-7-4"
                                                label="Escriba su Respuesta"
                                                value="..."
                                            ></ckeditor>
                                            <br>
                                            <upArchivo @upfile="upfile"></upArchivo>
                                        </v-card-text>
                                        <v-card-actions>
                                            <msjAlerta :msj="alerta"></msjAlerta>
                                            
                                            <v-btn color="primary" text @click="enviar()"> Enviar </v-btn>
                                            <v-btn color="secundary" text @click="closealert()"> Salir </v-btn>
                                        </v-card-actions>
                                       
                                    </v-card>
                                    <br />
                                    <v-card width="100%" >
                                        <v-card-title class="blue lighten-1 text-white"> Propiedades </v-card-title>
                                        <v-card-text>
                                            <br>
                                            <p>
                                            <v-combobox
                                                v-model="estado.selectEstado"
                                                :items="estado.itemsEstado"
                                                label="Estado"
                                                hide-selected
                                                small-chips
                                                outlined
                                                dense
                                                @change="editar"
                                                ></v-combobox>
                                            </p>
                                            <p>
                                                <v-combobox
                                                v-model="prioridad.selectPrioridad"
                                                :items="prioridad.itemsPrioridad"
                                                label="Prioridad"
                                                hide-selected
                                                small-chips
                                                outlined
                                                dense
                                                @change="editar"
                                                ></v-combobox>
                                            </p>
                                            <p><b> Sistema : {{ticket.sistema.nombre}} </b></p>
                                            <p><b> Empresa : {{ticket.sistema.empresa}} </b></p>
                                        </v-card-text>
                                        
                                    </v-card>
                                </template>
                            </div>
                            <div class="col-8">
                                <template>
                                    <v-form v-model="valid" style="overflow-y:auto; heigth:50%">
                                            <v-timeline
                                                align-top
                                                dense
                                            >
                                                <v-timeline-item
                                                    v-for="(item, i) in ticket.detalleticket"
                                                    :key="i"
                                                    :color="(item.user_id)?'blue':'pink'"
                                                    fill-dot
                                                    small
                                                >
                                                    <v-row class="pt-1">
                                                        <v-col cols="3">
                                                        <strong>{{formate(item.updated_at)}} </strong>
                                                        <br>
                                                        {{funciones.tecnicoOcliente(item,ticket.cliente)}}
                                                        </v-col>
                                                        <v-col>
                                                            <v-row>
                                                                <strong>{{item.titulo}} </strong>
                                                                <v-spacer></v-spacer> 
                                                                <v-btn
                                                                    v-if="true"
                                                                    elevation="7"
                                                                    outlined
                                                                    x-small
                                                                    color="teal darken-1"
                                                                >
                                                                    Editar
                                                                </v-btn>
                                                            </v-row>
                                                        <v-divider></v-divider>
                                                        <div class="caption" v-html="item.detalle">
                                                            
                                                        </div>
                                                        <br>
                                                        <div v-for="(f,i) in item.foto" :key="i">
                                                            <img :src="'images/ticket/'+f.nombre" alt="" style=" width: 80px;height: 50px;">
                                                        </div>
                                                        </v-col>
                                                    </v-row>
                                                    
                                                </v-timeline-item>
                                            </v-timeline>
                                    
                                    </v-form>
                                </template>
                            </div>
                        </div>
                    </v-card-text>
            </v-card>
        </v-dialog>
        
        <loader :load="load"></loader>
    </div>
</template>
<script>
    import upArchivo from '../../../Otros/upArchivo';
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
  export default {
    props:['ticke','permiso'],
    data: () => ({
        editor:ClassicEditor,
        dialog:false,
        funciones:aldebaran,
        valid:false,
        alerta: { mensaje: "", visible: false, tipo: 0 },
        load:[],
        page:'/home/Aldebaran/Ticket/storeDetalleTicket/',
        estilo: [
            {
                color: 'red lighten-2'
            },
            {
                color: 'pink lighten-2'
            },
        ],
        estado:{
            selectEstado:[],
            itemsEstado:[
                    {id:0,text:'Iniciado'},
                    {id:1,text:'En Proceso'},
                    {id:2,text:'Derivado'},
                    {id:3,text:'Finalizado'},
                    {id:4,text:'Cancelado'},
            ],
        },
        prioridad:{
            selectPrioridad:[],
            itemsPrioridad:[
                {id:0, text:'Muy baja'},
                {id:1, text:'Baja'},
                {id:2, text:'Media'},
                {id:3, text:'Alta'},
                {id:4, text:'Muy Alta'},
            ]
        },
        archivos:[],
        detalleticket:{
            titulo:'',
            tipo:0,
            detalle:'',
            ticket_id:0,
        },
        ticket:{}
    }),
    components:{
        upArchivo
    },
    watch:{
        ticke(t){
             this.ticket = t
             this.estado.selectEstado = this.estado.itemsEstado[this.ticket.estado]
             this.prioridad.selectPrioridad = this.prioridad.itemsPrioridad[this.ticket.prioridad]
             
        }
    },
    created(){
        
        this.ticket = this.ticke
        
        this.estado.selectEstado = this.estado.itemsEstado[this.ticket.estado]
        this.prioridad.selectPrioridad = this.prioridad.itemsPrioridad[this.ticket.prioridad]
    },
    
    methods: {
        formate(val){
            return formatfecha.formatEN_ES_TiME(val)
        },
        enviar(){

            let param= new FormData()
            let img= Array()
            for (let index = 0; index < this.archivos.length; index++) {
                param.append('image['+index+']' , this.archivos[index])
            }
            param.append('titulo',this.detalleticket.titulo)
            param.append('tipo',this.detalleticket.tipo)
            param.append('detalle',this.detalleticket.detalle)
            param.append('ticket_id',this.ticket.id)
            
            this.load=true
            try {
                axios
                .post(this.page + this.ticket.id , 
                        param,
                        {headers:{"Content-Type": "multipart/form-data"}}
                    )
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
        editar(){
           try {
                let param= new FormData()
               
                param.append('estado', this.estado.selectEstado.id )
                param.append('prioridad',this.prioridad.selectPrioridad.id)
                console.log(param)
                axios
                .post('/home/Aldebaran/Ticket/storeTicket/' + this.ticket.id , 
                        param,
                        {headers:{"Content-Type": "multipart/form-data"}}
                    )
                .then((response) => {
                    
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
        refresh(){
            //this.$store.commit('getTicket', this.ticke.id)
            this.$emit('refresh')
        },
        upfile(arr){
           this.archivos = arr
        }
    },

  }
</script>