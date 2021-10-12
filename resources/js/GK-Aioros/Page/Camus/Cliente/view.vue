<template ref="ctacte_cliente">
    <v-row justify="center" id="modalMenu" >
      <v-container fluid>
        <v-card>
          <v-toolbar class="sau-dataTable__title white--text" dark>
            <v-btn icon dark @click="closeModal">
              <v-icon >mdi-close</v-icon>
            </v-btn>
            <v-toolbar-title>Clientes </v-toolbar-title>
            <v-spacer></v-spacer>
            <clientenuevo v-if="permiso.nuevo" :tipo="'Nuevo'"  @refresh="toUpdate"  ></clientenuevo>
          </v-toolbar>

          <v-list three-line subheader class="sau-dataTable__background">
            <br />
            <!-- aqui -->
            <div class="sau__busqueda-superior">
              <div class="sau__busqueda-superior__title">Listado de Clientes</div>
    
              <!-- <v-spacer></v-spacer> -->
              <compBusqueda :param="filter" @objeto="filtrado" ></compBusqueda>
            </div>
            <!-- fin aqui -->
            <v-list-item>
              <v-list-item-content>
                <vuetable
                  ref="vuetable"
                  :fields="fields"
                  :api-mode="false"
                  :data="object"
                  
                  pagination-path=""
                  :css="css.table"
                  :show-sort-icons="true"
                  :sort-order="sortOrder"
                  :data-manager="getSortParam"
                  id="mytable"
                  class="mb-5 bg-white rounded"
                  @vuetable:row-clicked="onRowCLicked"
                
                  
                >
                  <template slot="accion" slot-scope="props">
                    <v-card-actions>
                      <div class="text-center row">
                        <div class="col-6">
                            <clientenuevo v-if="permiso.modificar" :cliente="props.rowData" :tipo="'Modificando'" @refresh="toUpdate" ></clientenuevo>

                        </div>
                        
                        <div class="col-6"  >
                          
                          <template >
                            <v-btn
                              class="mx-2 " 
                              :title="'Pago Rapido'" 
                              :color="'teal lighten-3'"
                              fab  
                              outlined 
                              x-small 
                            @click="openrapipago(props.rowData)"
                            >
                              <v-icon >mdi-cash-plus</v-icon>
                            </v-btn>
                          </template>
                        
                        </div>
                        
                      </div>
                    </v-card-actions>
                  </template>
                  <template slot="Atrasado" slot-scope="props">
                        <v-alert v-if="props.rowData.Atrasado"
                          type="warning"
                          dense
                          outlined
                          
                        > Atrasado</v-alert>
                        <v-alert v-else
                          type="success"
                          dense
                          outlined
                        
                        > Al Día</v-alert>
                  </template>
                  <template slot="Estado" slot-scope="props">
                        <div v-if="props.rowData.Estado == 1" class="text-success"
                        >• Activo</div>
                        <div v-else class="text-danger"
                        >• Inactivo</div>
                  </template>
                </vuetable>
                <pagination ref="pagination" :data="object" @click="pagination">
                </pagination>
              </v-list-item-content>
            </v-list-item>
          </v-list>
          <rapipago  :cliente="cliente" :option="modalrapipago" @refresh="toUpdate"  :permisopago="permiso"></rapipago>
          <!-- <v-divider></v-divider> -->
          <v-list three-line subheader>
          
                    <!-- aqui -->
  <!-- titulo inferior -->
  
                <div class="sau-dataTable__title white--text v-sheet theme--dark v-toolbar">

                  <v-toolbar-title class="sau_titulo-inferior__title ">Productos Adquiridos por el Cliente </v-toolbar-title>
                  <!-- <v-spacer></v-spacer> -->
                  <div class="text-right sau_titulo-inferior__button" v-if="permiso.asociar">
                    

                      <contrato
                          
                          :show="tipoModal.altaproducto"
                          :cliente="cliente"
                          :productos="prod"
                          :tipo="'nuevo'"
                          :idCtacte="0"
                          @refresh="toUpdate"
                          @cerrarmodal="cerrarcontrato"
                        >
                        </contrato>
                  </div>
                </div>
         
  <!-- fin titulo inferior -->
                              <!-- fin aqui -->
            <v-list-item class="sau-dataTable__background">
              <div class="row">
                <detalleproducto 
                          ref="refreshctacte" 
                          :cliente="cliente"  
                          :permisopago="permiso"
                          :permisomodificar="permiso.modificarasociado"></detalleproducto>
              </div>
            </v-list-item>
          </v-list>
        </v-card>
      </v-container>
      <loader :load="load"></loader>
    </v-row>
  
</template>
<script>
import detalleproducto from "../Producto/detalle_producto2";
import contrato from "../Contrato/alta";
import rapipago from "../Contrato/pagorapido";
import clientenuevo from "../Cliente/nuevo";



export default {
  name: "Cliente",
  props: ["show","permiso"],
  data() {
    return {
      on:'',
      load:false,
      attrs:'',
      css: CssVuetable,
      modalrapipago: {show : false},
      tipoModal: { altaproducto: false },
      dialog: this.show,
      notifications: false,
      filter: {
        page: "home/Camus/util/cliente/filtrado",
        msj: "",
      },
      sound: true,
      widgets: false,
      object: [],
      cliente: [],
      prod: [],
      page: "home/Camus/cliente/data/",
      orden: '',
      sortOrder:[
        {
          field: 'Nombre_Apellido',
          direction: 'asc'
        }
      ],
      fields: [
        {
          name: "id",
          title: "Cod. Cliente",
          dataClass: "text-dark",
          visible: true,
        },{
          name: "Nombre_Apellido",
          title: "Nombre y Apellido",
          visible: true,
          sortField: 'Nombre_Apellido'  
        },{
          name: "Dni",
          title: "DNI",
          visible: true,
        },
        {
          name: "email",
          title: "Email",
          visible: false,
        },
        {
          name: "nombre",
          title: "Zona",
          visible: true,
          sortField: 'nombre'  
        },
        
        {
          name: "Orden",
          title: "Orden",
          visible: true,
          sortField: 'Orden'  
        },
        {
          name: "Celular",
          title: "Celular",
          visible: true,
        },
        {
          name: "Domicilio",
          title: "Direccion",
          visible: true,
        },{
          name: "Atrasado",
          title: "Deudor",
          width: '50px',
          visible: true,
          formatter(value){
              return (value)?'Sí':'No'
          }
        },
        {
          name: "Estado",
          title: "Estado",
          visible: true,
          formatter(val){
            return  (val == 1)?'Activo':'Inactivo'
            
          }
        },
        {
          name: "accion",
          title: "#",
          visible: true,
        },
      ],
    };
  },
  components: {
    detalleproducto,
    contrato,
    clientenuevo,
    rapipago
  },
 
  mounted() {
    this.permiso = JSON.parse(this.permiso.permisoscamus.cliente)
    this.index(this.page,'');
    this.productos();
  },
  methods: {
    
    index(page,id) {
      
      try {
        this.load=true
        axios
          .get(page)
          .then((response) => {
            
            if (response.data.status == 0) {
              if (id == ''){
                  this.object = response.data.data
                  
              }else{
                  
                  this.object = [response.data.data]
                  this.cliente= response.data.data
                  $('[item-index="'+0+'"]').css('background-color','#1976d25e')
              }
            } else {
              console.log("error");
            }
            this.load=false
          })
          .catch((error) => {
            
            this.load=false
          })
          .finally(() => this.load=false);
      } catch (error) {
        console.log('error');
      }
    },
    productos() {
      try {
        axios
          .get("home/Camus/producto/comboproducto")
          .then((response) => {
            this.prod = response.data;
            
          })
          .catch((error) => {
            console.log(error);
          })
          .finally(() => console.log(""));
      } catch (error) {
        console.log(error);
      }
    },
    clientecomboproducto(){
      try {
        axios
          .get("home/Camus/cliente/comboproducto")
          .then((response) => {
            this.prod = response.data;
            
          })
          .catch((error) => {
            console.log(error);
          })
          .finally(() => console.log(""));
      } catch (error) {
        console.log('error');
      }
    },
    openrapipago(row){
      this.onRowCLicked(row) 
      this.modalrapipago.show = true
      
    },
    /*Colocamos el color de la Fila */
    onRowCLicked(row) {
      if (row.data){
        $('[item-index]').css('background-color','transparent')
        $('[item-index="'+row.index+'"]').css('background-color','#1976d25e')
        //this.index(row.data.id)
        this.cliente = row.data;
      }
     
    },
    toUpdate:function(r){
      
      switch (r[0]) {
        
        case 'clientenuevo':
          
          this.index(this.page+ this.cliente.id  + this.orden,this.cliente.id,this.cliente.id)

        case 'cliente':
          this.index(this.page + this.cliente.id  + this.orden,this.cliente.id)
          
          break
        case 'refrescarcuenta':
          /* Refresca las ctascte modificada con el pago rapido */
          this.index(this.page+r[1],r[1]);
          break

        case 'ctacte':
          
          this.index(this.page + this.cliente.id,'')
          this.cliente = this.cliente 
          break;
      }
    },
   
    pagination(url, tableid) {
      /*-pagination : [traela url de la paginacion y el id de la vue table] */
      this.page = url
      this.orden = this.orden.replace('?','');
      this.index(this.page ,'');
    },
    filtrado(f) {
      this.object = f;
    },
    abrir(m) {
      switch (m) {
        case "altaproducto":
          this.tipoModal.altaproducto = true;
          break;

        default:
          break;
      }
    },
    closeModal: function () {
      this.$emit("close", false);
    },
    opencontrato(){
      this.tipoModal.altaproducto = true
      console.log(this.tipoModal.altaproducto)
    },
    cerrarcontrato(){
      this.tipoModal.altaproducto = false
    },
    getSortParam(sortOrder, currentPage, perPage) { 
      
      if (perPage){

      }else{
          this.orden = '?&orderby='+sortOrder[0].field+'&ordenar='+sortOrder[0].direction
      }
      
      this.index(this.page + this.orden,'')
    }
  },
};
</script>

