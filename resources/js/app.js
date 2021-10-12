/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import Vuex from 'vuex/dist/vuex.js'
window.Vue.use(Vuex);

import Vuetify from 'vuetify';
window.Vue.use(Vuetify);



import CssVuetable from './GK-Aioros/StyleDataTable/DataTable_Nr';
window.CssVuetable = CssVuetable


import filtro from './GK-Aioros/Otros/filtrobotones.vue'
Vue.component('botonesFiltros',filtro)
import FiltroFecha from './GK-Aioros/Otros/filtroFecha.vue'
Vue.component('filtrofecha',FiltroFecha)
import Busqueda from './GK-Aioros/Otros/busqueda.vue'
Vue.component('compBusqueda',Busqueda)
import Vuetable from 'vuetable-2/src/components/Vuetable'
Vue.component('Vuetable',Vuetable)
import TotalPage from './GK-Aioros/DataTable/TotalPagina.vue'
Vue.component('TotalPage',TotalPage)
import pagination from './GK-Aioros/DataTable/PaginationBoostrap.vue'
Vue.component('pagination',pagination)
import msjAlerta from './GK-Aioros/MsjAlertas/view.vue'
Vue.component('msjAlerta',msjAlerta)
import loader from './GK-Aioros/Otros/load.vue';
Vue.component('loader',loader)
import index from './GK-Aioros/index'
Vue.component('index',index)

import CKEditor from '@ckeditor/ckeditor5-vue2';
Vue.component('ckeditor',CKEditor.component)

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/* Modulos */
const Aldebaran = {
  state: {
    flavor: '',
    modal:{title: '', icon: '', modal:'',permiso:'' },
    permiso:{},
    usuario:{},
    prioridad:{}
    
  },
  mutations: {
    showComponent(state, modal) {
      state.modal = modal
    },
    setPermiso(state,permiso){
      state.permiso = permiso
    },
    setUsuario(state,usuario){
      state.usuario = usuario
    },
  
  },
  getters:{
    getPrioridad: (p) =>{
        switch (p) {
          case 1:
              state.prioridad = 'Baja'
          case 2:
              state.prioridad = 'Media'
          case 3:
              state.prioridad = 'Alta'
          case 4:
              state.prioridad = 'Urgente'
          default:
              state.prioridad = p
        }
    },
    getEstado(e){

    }
  }
  
}

export const store = new Vuex.Store({
  modules: {
    a: Aldebaran
  }
  
})

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
   
    store,
    icons: {
        iconfont: 'mdi', // default - only for display purposes
      },
});

