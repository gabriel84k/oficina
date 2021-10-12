<template>
  <div >
    <div class='demo-app' >
          <div class='demo-app-sidebar row'>
            <div class='demo-app-sidebar-section col-sm-2'>
              <label>
                <input  type='checkbox' :checked='calendarOptions.weekends' @change='handleWeekendsToggle'/>
                Fines de semana
              </label>
            </div>
            <div class='demo-app-sidebar-section col-sm-3'>
              Total de eventos ({{ currentEvents.length }})
              <!--
              <ul>
                <li v-for='event in currentEvents' :key='event.id'>
                  <b>{{ event.startStr }}</b>
                  <i>{{ event.title }}</i>
                </li>
              </ul>
              -->
            </div>
            <div v-if="false" class='demo-app-sidebar-section row col-sm-7'>
                <div class="col-sm-5">
                    Seleccionar Calendario de Médico: 
                </div>
                <div clas="col-sm-7" style="width:50%">
                  <div class="dropdown input-group-prepend">
                      <button class="btn  btn-sm dropdown-toggle " type="button" id="filtromedico" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                          Todos &nbsp<i class="fas fa-search"></i>
                      </button>
                      <div class="dropdown-menu " aria-labelledby="SelectProd">
                          
                          <input id="medico" type="text" class="form-control " @keyup="selectmedico(struser.nombre)" v-model="struser.nombre" placeholder="Nombre y Apellido" aria-label="Nombre y Apellido" aria-describedby="basic-addon2">
                          <button class="dropdown-item " type="button" @click="filtrar(null,'todos')">Todos los Médicos</button>
                          <button v-for="(item) in medicos" :key="item.id" class="dropdown-item " type="button" @click="filtrar(item,'medico')">{{item.name}}</button>
                      </div>
                      <div class="input-group-append">
                          
                      </div>
                  </div>
                </div>
            </div>
          </div>
    </div>
    
      <FullCalendar id="cal" ref="calendar" :options="calendarOptions" :key="calendarOptions.event">
        <template v-slot:eventContent='arg'>
          <b>{{ arg.timeText }}</b>
          <i>{{ arg.event.title }}</i>
        </template>
      </FullCalendar>
      <Newturno :event="newevent.evento" 
                :disabled="newevent.disabled" 
                :tipo="newevent.tipo" 
                :autoedit="newevent.autoedit" 
                @create="crear" 
                @delete="eliminar"
                @update="modificar">
      </Newturno>
  </div>   
  
</template>

<script>
import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import timeGridPlugin from '@fullcalendar/timegrid'
import core from '@fullcalendar/core'
import listPlugin from '@fullcalendar/list'
import esLocale from '@fullcalendar/core/locales/es'

import Newturno from './ABM'


export default {
  
  props:[],
  data: function() {
    return {
      calendarOptions: {
          eventTimeFormat:{ 
            hour: '2-digit',
            minute: '2-digit',
            meridiem: false,
            hour12:false
          },
          slotDuration: '00:30' , // se divide la hora cada 30 minutos
          slotLabelFormat: [
            {hour:'2-digit', minute:'2-digit',second:'2-digit',hour12:false }, // top level of text
            { weekday: 'short' },// lower level of text
           
          ],
          
          plugins: [
            dayGridPlugin,
            timeGridPlugin,
            listPlugin,
            interactionPlugin // needed for dateClick
          ],
          /* Aquí se puede colocar un pie de pagina*/
          /*
          footerToolbar:{
            left: '',
            center: 'custom1',
            right: ''
          },
          */
          /*Aquí se pueden personalizar botones para usar en los encabezados o pie de pagina */
          /*
          customButtons: {
            custom1: {
              text: 'custom 1',
              click: function() {
                this.prueba()
              }
          }},
          */
          headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
          },
          initialView: 'dayGridMonth', /*Se inicia el calendario en el dia o semana o mes  */
          locale: esLocale,   /*Traduccion al español */
          themeSystem: 'bootstrap',
          slotMinTime: '08:00', /* Apertura */
          slotMaxTime: '20:00',/*  Cierre */
          expandRows: true,
         
     
          dayMaxEvents: 3, /* Cantidad de eventos que se muestran en la ventana de mes */
          /* Aquí mostramos un popover con los demas eventos que no entran en  dayMaxEvents*/
          views: {
            timeGrid: {
              dayMaxEventRows: 6 // adjust to 6 only for timeGridWeek/timeGridDay
            }
          },
          editable: true, /*Drag and Drop */
          selectable: true,
          selectMirror: true,
          
          weekends: false, /* fines de semanas */
          select: this.handleDateSelect,
          eventClick: this.handleEventClick,
          
          eventsSet: this.handleEvents,
          eventContent:this.content,
          eventDidMount: this.eventdidmount,
          refetchResourcesOnNavigate: true,
          eventChange:this.handleEventClick,
          /* you can update a remote database when these fire:
          eventAdd:
          
          eventRemove:
          */
          navLinks: true,  /* Convierte en link los titulos de la semana lunes, martes, miercoles, etc... */
          height: 'auto',
          contentHeight:600,
          aspectRatio: 2,
          events: '/home/Shion/Turnos/data',//this.initial_events,
          eventColor: '#41b3f9',
          eventTextColor:'black',
          
         
          
       },
      currentEvents: [],
      eventGuid:this.id,
      medicos:[],
      struser:{id:0,nombre:''},
      newevent:{
        evento:[],
        disabled:false,
        detalle:'',
        tipo:'nuevo',
        autoedit:false
      }
      
    }
  },
  components:{
    FullCalendar,
    Newturno
  },
  mounted() {
   
  },
 
  methods: {
    
    content(event){
     
    },
    eventdidmount(info) {
      
      /*
      console.log(info)
      $('.'+info.el.classList[0]).tooltip({ trigger: 'hover',
                                            title: info.event.extendedProps.description,
                                            placement: 'top'})
      var tooltip = new Tooltip(info.el, {
        title: info.event.extendedProps.description,
        placement: 'top',
        trigger: 'hover',
        container: 'body'
      });*/
    },
    InitialEvents(params){
    
            axios
                .get("/home/Shion/Turnos/data", params)
                .then((response) => {
                  
                  if (response.data.status == 0) {
                      
                      return response.data.data
                  } else {
                    
                  }
                })
                .catch((error) => {
                  console.log(error.response.data.errors);
                  let err = {};
                  err.data = "";
                  err.descripcion = "Error al Crear el Paciente";
                  $.each(error.response.data.errors, function (i, val) {
                    err.data += val + " - ";
                  });
                  this.alerts("error", err);
                })
                .finally(() => (this.loading = false));
     
    },
    selectmedico(params){
        console.log(params)
        axios.get('home/Shion/Users/search',  {params} )
            .then(response => {
                        
                if (response.data.data.status!=0){
                    console.log(response.data)
                    this.medicos=response.data.data.data
                }else{
                    console.log(response.data.detalle)
                }
            })
            .catch(error => {
                        this.errored = true
            })
    },
    filtrar(item,tipo){
      let calendar=this.$refs.calendar.getApi();
      switch (tipo) {
        case 'medico':
          $('#filtromedico').html(item.name + " &nbsp<i class='fas fa-search'></i>")
          this.calendarOptions.events= '/home/Shion/Turnos/data?filtro='+item.id
         
          break;
      
        default:
          $('#filtromedico').html("Todos los Medicos &nbsp<i class='fas fa-search'></i>")
          this.calendarOptions.events= '/home/Shion/Turnos/data'
          break;
      }
      console.log(calendar)
      calendar.render()
    },
    eliminar(id){
        let calendar=this.$refs.calendar.getApi();
        console.log(calendar)
        let event=calendar.getEventById(id)
        event.remove()
    },
    crear(c,title){
        let calendarApi= c.view.calendar
        calendarApi.unselect() // clear date selection
        if (title) {
          let res= calendarApi.addEvent({
            id: c.id,
            title:title,
            start: c.startStr,
            end: c.endStr,
            allDay: c.allDay
          })
        }
        
    },
    modificar(c,eventEdit){
      console.log('modificar')
      console.log(c._context.calendarApi)

      let calendarApi= c._context.calendarApi
      let calendar=this.$refs.calendar.getApi();
      let event=calendar.getEventById(c.id)
      event.remove()

      
      calendarApi.unselect() // clear date selection
      
      if (eventEdit.title) {
        
        let res= calendarApi.addEvent({
          id: c.id,
          title:eventEdit.title,
          start: eventEdit.startStr,
          end: eventEdit.endStr,
          allDay: c.allDay
        })
      }
    },
    handleWeekendsToggle() {
      this.calendarOptions.weekends = !this.calendarOptions.weekends // update a property
    },
    handleDateSelect(selectInfo) {
      //let title = prompt('Please enter a new title for your event')
      
      this.newevent.evento = selectInfo
      this.newevent.disabled = 'disabled'
      this.newevent.tipo = 'Nuevo'
      $('#newturno').modal('show')
      /*
      let calendarApi= selectInfo.view.calendar
      calendarApi.unselect() // clear date selection
      if (title) {
       let res= calendarApi.addEvent({
          id: this.eventGuid++,
          title:title,
          start: selectInfo.startStr,
          end: selectInfo.endStr,
          allDay: selectInfo.allDay
        })
        this.new(res)
      }
      */
    },

    handleEventClick(clickInfo) {
      
      this.newevent.evento = clickInfo.event
      this.newevent.disabled = ''
      this.newevent.tipo = 'Editar'
      if (clickInfo.el){
        this.newevent.autoedit=false
        $('#newturno').modal('show')
      }else{
        this.newevent.autoedit=true
        $('#newturno').modal('hide')
      }
      
      let calendar=this.$refs.calendar.getApi();
      let event=calendar.getEventById(clickInfo.event.id)
      
      calendar.render()
      
    },
    handleEvents(events) {
      console.log(events)
      this.currentEvents = events
    },
 
    close(value){
        this.$emit('show',value)
    },
  }
}
</script>
<style lang='scss'>
// you must include each plugins' css
// paths prefixed with ~ signify node_modules

.demo-app {
  font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
  font-size: 14px;
}
.demo-app-top {
  margin: 0 0 3em;
}
.demo-app-calendar {
  margin: 0 auto;
  max-width: 900px;
}
.fc-event{
  background-color: #38c2bf !important;
  color:black;
  text-align: initial;
}
.fc-toolbar{
  background-color: #38c2bf !important;
}
.fc-timegrid-event-harness{
    font-size: 12px;
    height: 26px;
}
</style>