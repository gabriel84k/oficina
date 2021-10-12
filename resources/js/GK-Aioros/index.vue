<template>
    <v-app >
        <v-navigation-drawer app >
          <!-- -->
            <v-list-item>
              <v-list-item-content>
                <v-list-item-title class="title">
                  GK-Ticket 
                </v-list-item-title>
                <v-list-item-subtitle>
                  Sistema Técnico para la Realización de Ticket
                </v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
            
            <v-divider></v-divider>
            <v-list
                dense
                nav
              >
                <div  
                  v-for="item in items"
                  :key="item.title">
                      <!-- Esto es Sub Menú -->
                      <div v-if="item.visible" link>
                        <v-list-group
                          :value="false"
                          :prepend-icon="item.icon"
                          @click="openModal(item)"
                          v-if="item.submenu"
                        >
                          <template v-slot:activator>
                              <v-list-item-title >{{ item.title }}</v-list-item-title>
                          </template>
                          <v-list-group
                            :value="false"
                            no-action
                            sub-group
                            v-for="subitem in item.submenu" :key="subitem.title" 
                          >
                            <template v-slot:activator>
                              <v-list-item-content>
                                <v-list-item-title @click="openModal(subitem)">{{ subitem.title }}</v-list-item-title>
                              </v-list-item-content>
                            </template>
                          </v-list-group>
                        </v-list-group>
                      <div v-else>
                              <v-list-item>
                                <v-list-item-icon>
                                  <v-icon>{{item.icon}}</v-icon>
                                </v-list-item-icon>

                                <v-list-item-title @click="openModal(item)">{{ item.title }}</v-list-item-title>
                              </v-list-item>
                        </div>
                      </div>
                      
                  
            
                </div>
            </v-list>
           
        </v-navigation-drawer>

        <v-app-bar app >
          <!-- -->
          <crud v-if="true" 
                :tipo="'Nuevo'" 
                :nota="[]" 
                :isrt="isroot"></crud>
          <v-spacer></v-spacer>
          <headeruser :user="user" ></headeruser>  
        
        </v-app-bar>

        <!-- Sizes your content based upon application components -->
        <v-main>
             
              <!-- Provides the application the proper gutter -->
              <v-container fluid heigth="100%">
               
                <component 
                          v-if="modal.permiso"  
                          v-bind:is="modal.modal"  
                          @close="closeModal"  
                          :permiso="metodo_permiso(modal)" 
                          :user="user" :empresa="empresa"
                          >
                </component>
                
                <!--If using vue-router 
                <router-view>preunsdnakdjadjalskdj</router-view>-->
              </v-container>
        </v-main>

        <v-footer app >
          <!-- -->
          footer:  <div></div>
        </v-footer>
    </v-app>
</template>

<script>

/* Proyecto aioros */
import Usuario from './Usuario/view'
import headeruser from './Usuario/header'
import Configuracion from './Configuracion/view'


/* Proyecto Aldebarán */
import Ticket from './Page/Aldebaran/Ticket/view'
import Cliente from './Page/Aldebaran/Clientes/view'

/* Proyecto Shion */
import Calendario from './Page/Shion/Agenda/Turnos.vue'
import Header from './Usuario/header.vue'

/* Proyecto Camus */
import Ctacte_Productos from './Page/Camus/Producto/view'
import Ctacte_Reportes from './Page/Camus/Reporte/view'
import Ctacte_Administracion from './Page/Camus/Cliente/view'
import Ctacte_Conf from './Page/Camus/Configuración/view'

/* Proyecto MU */
import Presupuesto from './Page/MU/view'

/* Proyecto Shura */
import Notas from './Page/Shura/view'
import crud from './Page/Shura/crud'

/* Proyecto Ikki */
import Galeria from './Page/Ikki/albun.vue'

/* Tablero */
import Estadistica from './Estadistica/view.vue'

/* constantes */


export default {
  props:['user','cliente','permiso','permisoCamus','empresa'],
  name: 'index',
 
  data() {
    return {
      
      
      items: [
          { visible:true , title: 'Index', icon: 'mdi-view-dashboard', modal:'Estadistica',permiso:this.permiso.usuario},
          { visible:false, title: 'Ticket', icon: 'mdi-image',modal:'Ticket',permiso:this.permiso.ticket},
          { visible:false, title: 'Usuarios', icon: 'mdi-account',modal:'Usuario',permiso:this.permiso.usuario},
          { visible:false, title: 'Clientes', icon: 'mdi-account-supervisor',modal:'Cliente',permiso:this.permiso.cliente},
          { visible:false, title: 'Calendario', icon: 'mdi-calendar-clock',modal:'Calendario',permiso:this.permiso.usuario},
          { visible:false, title: 'CtaCte', icon: 'mdi-briefcase',
            submenu:[ {visible:true, title: 'Administrar',modal:'Ctacte_Administracion', icon: 'mdi-help-box',permiso:this.permiso},
                      {visible:true, title: 'Producto', modal:'Ctacte_Productos', icon: 'mdi-help-box',permiso:this.permiso},
                      {visible:true, title: 'Reporte', modal:'Ctacte_Reportes', icon: 'mdi-help-box',permiso:this.permiso},
                      {visible:true, title: 'Conf.', modal:'Ctacte_Conf', icon: 'mdi-help-box',permiso:this.permiso}
                    ]
          },
          { visible:false, title: 'Presupuesto', icon: 'mdi-help-box',modal:'Presupuesto',permiso:this.permiso.usuario},
          { visible:false, title: 'Notas', icon: 'mdi-microsoft-onenote',modal:'Notas',permiso:this.permiso.usuario},
          { visible:false, title: 'Galeria', icon: 'mdi-image-outline',modal:'Galeria',permiso:this.permiso.usuario},
          { visible:true, title: 'Ayuda', icon: 'mdi-help-box',modal:'Ayuda',permiso:this.permiso.usuario},
        ],
        right: null,
        
        isroot:true
    }
  },
  components:{
    headeruser,
    Usuario,
    Ticket,
    Configuracion,
    Cliente,
    Calendario,
    Header,
    Ctacte_Administracion,
    Ctacte_Productos,
    Ctacte_Reportes,
    Ctacte_Conf,
    Presupuesto,
    Notas , crud,
    Estadistica,
    Galeria
    // Modal
  },
  computed: {
    modal () {
        
        return this.$store.state.a.modal
    },
    getPermiso(){
            
        return this.$store.state.a.permiso
    },
    getUsuario(){
      return this.$store.state.a.usuario
    },
    userPermiso(){
      
        return this.$store.state.a.permiso
    }
  },
  mounted() {
    
    
    this.$store.commit('setUsuario', this.user)
    this.$store.commit('setPermiso', this.permiso)
    this.config()
   
  },
  methods: {
    metodo_permiso(m){
      console.log(m.modal)
      if ((m.modal != 'Configuracion')&&(m.modal != 'Ctacte_Administracion') ){
          return JSON.parse(m.permiso)
      }else{
          return m.permiso
      }
    },
    openModal:function(m){
     
      this.$store.commit('showComponent', m)
      //this.$store.dispatch('showComponent', m)
    },
    closeModal:function(m){
     this.$store.commit('showComponent', m)
      
    },
    config(){
      
      let menu = JSON.parse(this.getPermiso.menu)
      this.items[1].visible = menu.ticket
      this.items[2].visible = menu.usuario
      this.items[3].visible = menu.cliente
      this.items[4].visible = menu.calendario
      this.items[5].visible = menu.ctacte
      this.items[6].visible = menu.presupuesto
      this.items[7].visible = menu.nota
      this.items[8].visible = menu.galeria
      

    },
    salir:function(){
        axios.post('/logout').then(response => {
                window.location.href = '/login';
        })
        .catch(error => {
                window.location.href = '/login';
        });
    },
  },
}


</script>
<style scoped>
#modalMenu{
  margin: 0 !important;
  width: 100%;

}
</style>