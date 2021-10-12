<template>
    
    <div class="modal fade"  id="newturno" tabindex="9999" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" >
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{tipo}} Nota</h5>
                <button type="button" @click="close()" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
           
            <div class="modal-body" >
                <div class="form-group" >
                    <!-- Titulo -->
                    <div v-if="true" class="input-group">
                        <div class="col-md-12">
                            <span class="input-text"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Titulo.</font></font></span>
                            <div class="input-group-prepend">
                                <v-text-field  id="titulo" v-model="strtitulo"  style="width:100%;"></v-text-field>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div v-if="false" class="input-group">
                        <!-- Seleccion de Cliente-->
                        <div class="col-md-6">
                            <span class="input-text">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">
                                        Cliente
                                    </font>
                                </font>
                            </span>
                            <div  class="dropdown input-group-prepend">
                                <button class="btn btn-secondary dropdown-toggle widthtotal" type="button" id="SelectProd" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                    Seleccione el Cliente &nbsp<i class="fas fa-search"></i>
                                    
                                </button>
                                <div class="dropdown-menu widthtotal" aria-labelledby="SelectProd">
                                    
                                <input id="paciente" type="text" class="form-control " @keyup="selectpaciente(strcliente.nombre)" v-model="strcliente.nombre" placeholder="Nombre y Apellido" aria-label="Nombre y Apellido" aria-describedby="basic-addon2" >
                                    <button v-for="(item) in clientes" :key="item.id" class="dropdown-item " type="button" @click="seleccionar(item,'paciente')">{{item.apellidonombre}}</button>
                                </div>
                                <div class="input-group-append">
                                   
                                </div>
                            </div>
                        </div>    
                        <!-- Seleccion de Usuario-->
                        <div  class="col-md-6">
                            <span class="input-text">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">
                                        Usuario
                                    </font>
                                </font>
                            </span>
                            
                            <div  class="dropdown input-group-prepend">
                                <button class="btn btn-secondary dropdown-toggle widthtotal" type="button" id="SelectMed" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                    Selecione el Usuario &nbsp<i class="fas fa-search"></i>
                                </button>
                                <div class="dropdown-menu widthtotal" aria-labelledby="SelectProd">
                                    
                                    <input id="medico" type="text" class="form-control " @keyup="selectmedico(struser.nombre)" v-model="struser.nombre" placeholder="Nombre y Apellido" aria-label="Nombre y Apellido" aria-describedby="basic-addon2">
                                    <button v-for="(item) in user" :key="item.id" class="dropdown-item " type="button" @click="seleccionar(item,'medico')">{{item.name}}</button>
                                </div>
                                <div class="input-group-append">
                                   
                                </div>
                            </div>
                            
                        </div>
                       
                    </div>
                    
                    <div class="input-group">
                        <!-- Fecha de Inicio Fecha Fin-->
                        <div class="col-md-6">
                            <span class="input-text"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Fecha Inicio.</font></font></span>
                            <div class="input-group-prepend">
                                <input id="start" type="date" class="form-control"  placeholder="Inicio" aria-label="inicio" :value="start=formatDate(event.start,false,0)" style="width:68%">&nbsp
                                <input id="startTime" type="time"  min="0" max="23" placeholder="hora Inicio" aria-label="inicio" :value="hora.startTime" style="width:22%; border: 0px; color: #666b71; font-size:15px" >
                                <font style="line-height: 3;">hs.</font>
                            </div>
                            <br />
                            <span class="input-text"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Fecha Fin.</font></font></span>
                            <div class="input-group-prepend">
                                <input id='fin' type="date" class="form-control"  placeholder="Fin" aria-label="fin" :value="end=formatDate(event.end,false,0)" style="width:68%">&nbsp
                                <input id='finTime' type="time"  min="0" max="23" placeholder="hora Fin" aria-label="fin" :value="hora.finTime" style="width:22%; border: 0px; color: #666b71; font-size:15px" >
                                <font style="line-height: 3;">hs.</font>
                            </div>
                        </div>
                        <!-- Detalle -->
                        <div class="col-md-6">
                            <div class="input-group-prepend">
                                <v-textarea
                                    outlined
                                    name="input-7-4"
                                    label="Detalle"
                                    value=""
                                    id="detalle" 
                                    v-model="strdetalle"
                                ></v-textarea>
                            </div>
                        </div>
                    </div>
                     <br>
                </div>
               
            </div>
            <div class="modal-footer">
                <msjAlerta :msj="alerta"></msjAlerta>
                <button type="button" :class="'btn btn-danger '+disabled " @click="borrar(disabled)">Borrar Nota</button>
                <button type="button" class="btn btn-secondary"  @click="close()" data-dismiss="modal">Cerrar</button>
                <button v-if="(tipo=='Nuevo')" type="button" class="btn btn-success" @click="guardar()">Guardar</button>
                <button v-else-if="(tipo=='Editar')" type="button" class="btn btn-success" @click="editar()">Editar</button>
            </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios'
export default {
    props:['event','disabled','tipo','autoedit'],
    data() {
        return {
            index:0,
            hora:{startTime:0,finTime:0},
            selected: '',
            turno:1,
            canchas:{},
            select_cancha:0,
            alerta:{id:0,mensaje: "", titulo:'',subtitulo:'', body:'',clase:'', visible:false, tipo: 0},
         
            id:this.event.id,
            start:'',
            startTime:'',
            end:'',
            endTime:'',
            cliente:[],
            user:[],
            strcliente:{nombre:'',id:''},
            struser:{nombre:'',id:''},
            strdetalle:'',
            strtitulo:''
           
        }
    },
    mounted() {
        
    },
    watch:{
        event:function(e){
            if (e.extendedProps.description){
                this.strdetalle = e.extendedProps.description
                this.strtitulo = e.title
            }
            this.show(e)
        }
    },
    
    methods: {
       
        show(item){
           
            if (item){
                this.start=item.startStr.split('T')[0]
                this.hora.startTime=item.startStr.split('T')[1].split('-')[0]
                this.end=item.endStr.split('T')[0]
                this.hora.finTime=item.endStr.split('T')[1].split('-')[0]
                axios.get('home/Shion/Turnos/data/'+item.id)
                    .then(response => {
                        if (!response.data){
                            
                            this.struser.nombre=''
                            this.struser.id=''
                            this.strcliente.nombre=''
                            this.strcliente.id=''
                            this.strdetalle=''
                            this.strtitulo=''
                            $('#SelectMed').html('Selecione el Médico &nbsp<i class="fas fa-search"></i>')
                            $('#SelectProd').html( 'Selecione el Paciente &nbsp<i class="fas fa-search"></i>')
                        }else{
                            
                            console.log(response.data.detalle)
                            this.struser.nombre=response.data.usuario.name
                            this.struser.id=response.data.usuario.id
                            this.strcliente.nombre=response.data.apellido
                            this.strcliente.id=response.data.cliente_id
                            this.strdetalle = response.data.detalle
                            this.strtitulo = response.data.title
                            $('#SelectMed').html(this.struser.nombre+'&nbsp<i class="fas fa-search"></i>')
                            $('#SelectProd').html( this.strcliente.nombre+'&nbsp<i class="fas fa-search"></i>')
                            if (this.autoedit){
                                this.editar()
                            }
                        }
                    })
                    .catch(error => {
                        this.errored = true
                    })
            }
        },
        guardar(){
            try {
                    let finTime=parseInt($('#finTime').val())
                    let startTime=parseInt($('#startTime').val())
                    let start=new  Date($('#start').val())
                    let end=new  Date($('#fin').val())
              
                    if ((finTime<=startTime) && (start>end)){
                            this.errored =false
                            this.alerta.visible=true
                            this.alerta.mensaje = 'La fecha de fin no puede ser menor a la fecha de inicio.';
                            this.alerta.tipo = 2;
                            this.alerta.color = 'error';
                    }else{
                        this.end=$('#fin').val()
                        this.endTime=$('#finTime').val()
                        this.start=$('#start').val()
                        this.startTime=$('#startTime').val()
                        $("#start").prop("disabled", false)
                        $("#startTime").prop("disabled", false)
                        $("#fin").prop("disabled", false)
                        $("#finTime").prop("disabled", false)

                    
                            
                        let params={'titulo':this.strtitulo,'detalle':this.strdetalle,'start':this.start+' '+this.startTime,'end':this.end+' '+this.endTime,
                                    'apellido':this.strcliente.nombre, 'cliente_id':this.strcliente.id,'user_id':this.struser.id}

                        axios.post('home/Shion/Turnos/data', params)
                                .then(response => {
                                  console.log  (response.data.status)
                                if (response.data.status!=0){
                                    this.errored =true
                                    
                                    this.alerta.visible=true
                                    this.alerta.mensaje = response.data.descripcion
                                    this.alerta.tipo = 2
                                    this.alerta.color = 'error'
                                    
                                }else{
                                        this.errored =false
                                        this.alerta.mensaje = response.data.descripcion;
                                        this.alerta.tipo = 2;
                                        this.alerta.color = 'success';
                                        this.alerta.visible = true;
                                        
                                        this.event.id=response.data.data.id
                                        this.$emit('create',this.event,this.strcliente.nombre)
                                        this.close()
                                }
                                })
                                .catch(error => {
                                    this.errored = true
                                })
                    }
            } catch (error) {
                console.log(error)   
            }
        },
        editar(){
            let finTime=parseInt($('#finTime').val())
            let startTime=parseInt($('#startTime').val())
            let start=new  Date($('#start').val())
            let end=new  Date($('#fin').val())
           if ((finTime<=startTime) && (start>end)){
                this.errored =false
                this.alerta.mensaje = 'La fecha de fin no puede ser menor a la fecha de inicio.'
                this.alerta.tipo = 2;
                this.alerta.color = 'error';
                this.alerta.visible = true;
               
                this.alerta.titulo="Mensaje del sistema. :("
                this.alerta.subtitulo=''
                this.alerta.body=
                this.alerta.c
                $('.alerta').alerta()
                
            }else{
                this.end=$('#fin').val()
                this.endTime=$('#finTime').val()
                this.start=$('#start').val()
                this.startTime=$('#startTime').val()
                let params={'titulo':this.strtitulo,'detalle':this.strdetalle,'start':this.start+' '+this.startTime,'end':this.end+' '+this.endTime,
                            'apellido':this.strcliente.nombre, 'cliente_id':this.strcliente.id,'user_id':this.struser.id}

                axios.put('home/Shion/Turnos/data/'+this.event.id, params)
                        .then(response => {
                            
                        if (response.data.status!=0){
                                this.errored =false
                                this.alerta.mensaje = response.data.descripcion;
                                this.alerta.tipo = 2;
                                this.alerta.color = 'error';
                                this.alerta.visible = true;
                                $("#start").prop("disabled", false)
                                $("#startTime").prop("disabled", false)
                                $("#fin").prop("disabled", false)
                                $("#finTime").prop("disabled", false)
                                $('.alerta').alerta()
                        }else{
                                this.errored =false
                                this.alerta.mensaje = response.data.descripcion;
                                this.alerta.tipo = 2;
                                this.alerta.color = 'success';
                                this.alerta.visible = true;
                                $('.alerta').alerta()
                               
                                let eventEdit={
                                    'startStr':this.start+'T'+this.startTime,
                                    'endStr':this.end+'T'+this.endTime,
                                    'title':this.strcliente.nombre,
                                }
                                  
                                console.log(eventEdit)
                               
                                this.$emit('update',this.event,eventEdit)
                                this.close()
                                
                        }
                        })
                        .catch(error => {
                            this.errored = true
                        })
                        .finally(() => this.loading = false)
            }
        },
        borrar(d){
           if(d==''){
                axios.delete('home/Shion/Turnos/data/'+this.event.id)
                    .then(response => {
                        
                        if (response.data.status!=0){
                            this.errored =false
                            this.alerta.mensaje = response.data.descripcion;
                            this.alerta.tipo = 2;
                            this.alerta.color = 'error';
                            this.alerta.visible = true;
                            $('.alerta').alerta()
                        
                        }else{
                            
                            this.errored =false
                            this.alerta.mensaje = response.data.descripcion;
                            this.alerta.tipo = 2;
                            this.alerta.color = 'success';
                            this.alerta.visible = true;
                            this.$emit('delete',this.event.id)
                            this.close()
                        }
                    })
                    .catch(error => {
                        this.errored = true
                    })
                    .finally(() => this.loading = false)
            }
        },
        close(){
            setTimeout(function()
            {
                this.alerta.visible=false
                this.alerta.id++
                $('#exampleModal').modal('hide')
                
            }.bind(this), 800);
            
        },
        formatDate:function(value,h,f){
            try {
            
            let date=new Date(value)
          
            var dia=String(date.getDate());
            var mes=String(date.getMonth()+1);
          

            (dia.length==1)?dia='0'+dia:dia;
            (mes.length==1)?mes='0'+mes:mes;

            if (h==true){
                var hora=String(date.getHours());
                var minuto=String(date.getMinutes());
                var segundo=String(date.getSeconds());
                (hora.length==1)?hora='0'+String(hora):hora;
                (minuto.length==1)?minuto='0'+String(minuto):minuto;
                (segundo.length==1)?segundo='0'+String(segundo):segundo;
                return dia + '/' + mes + '/' + date.getFullYear() +' '+ hora +':'+ minuto +':'+ segundo;
            }else{
                if (f==2)
                    return mes + '/' + String(date.getFullYear()).substr(-2,2)
                else
                   
                    return  date.getFullYear() + '-' + mes + '-' + dia;
            }
            } catch (error) {
                console.log(error)
            }
            
        },
        formatTime:function(value,count){
            
                let date=new Date(value)
          
                var hora=String(date.getHours());
                var minuto=String(date.getMinutes());
                var segundo=String(date.getSeconds());
                (hora.length==1)?hora='0'+String(hora):hora;
                (minuto.length==1)?minuto='0'+String(minuto):minuto;
                (segundo.length==1)?segundo='0'+String(segundo):segundo;
                if (count==0){
                    return  hora +':00:00';
                }else{
                    
                    return  hora;
                }
                
        },
        keycontrol:function(key){
            if($.isNumeric(key)){

            }else{
                this.hora.startTime
            }
        },
        sumadate:function(val,index){
            
            let date1=new Date(val)
           
            let dias=0
            if (index!=0){
                dias=7
            }else{
                dias=8
            }
            

            let date2= new Date(date1.setDate(date1.getDate() + 7));

            var day_as_milliseconds = 86400000;
            var diff_in_millisenconds = date2 - date1;
            var diff_in_days = diff_in_millisenconds / day_as_milliseconds;

            console.log( diff_in_millisenconds );

            var dia=String(date2.getDate());
            var mes=String(date2.getMonth()+1);
            var año=String(date2.getFullYear());
          
            return año + '-' + mes + '-' + dia;
        },
        selturno : function (e) {
            if (e.id!=0){
                return e.turno
            }else{
                return this.turno
            }
        },
        keyrestrict(e){
            if($('#finTime').val()==''){
                $('#finTime').val('00')
            }
            let finTime=parseInt($('#finTime').val())
        
            if (finTime<0 || finTime>23){

                $('#finTime').val(finTime.toString().substring(0,1))
            }

            if($('#startTime').val()==''){
                $('#startTime').val('00')
            }
            let startTime=parseInt($('#startTime').val())
        
            if (startTime<0 || startTime>23){

                $('#startTime').val(startTime.toString().substring(0,1))
            }
            
        },
        selectpaciente(params){
            console.log(params)
            axios.get('home/Shion/Cliente/search',  {params} )
                .then(response => {
                    if (response.data.data.status!=0){
                        
                        this.clientes=response.data.data.data
                    }else{
                      
                    }
                })
                .catch(error => {
                    this.errored = true
                })
        },
        selectmedico(params){
            console.log(params)
            axios.get('home/Shion/Users/search',  {params} )
                .then(response => {
                            
                    if (response.data.data.status!=0){
                     
                        this.user=response.data.data.data
                    }else{
                        
                    }
                })
                .catch(error => {
                            this.errored = true
                })
        },
        seleccionar(item,tipo){
            switch (tipo) {
                case 'medico':
                    this.struser.id= item.id
                     this.struser.nombre= item.name
                    $('#SelectMed').html(item.name+'&nbsp<i class="fas fa-search"></i>')
                    break;
                case 'paciente':
                     this.strcliente.id= item.id
                     this.strcliente.nombre= item.apellidonombre
                    $('#SelectProd').html(item.apellidonombre+'&nbsp<i class="fas fa-search"></i>')
                    break;
                
            }
           
        }
    },
}

</script>
<style >
    .disponible{
        line-height: 3;
        background-color: #42b983;
        color: white;
    } 
    .nodisponible{
        line-height: 3;
        background-color: #b94642;
        color: white;
    }
    .widthtotal{
        width: 100%;
    }
    
    
</style>