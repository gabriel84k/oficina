<template ref="ctacte_producto">
  <v-row justify="center" id="modalMenu" >
    <v-container fluid>
      <v-card>
      
        <v-toolbar class="sau-dataTable__title white--text">
          <v-btn icon dark @click="closeModal">
            <v-icon>mdi-close</v-icon>
          </v-btn>
          <v-toolbar-title>Productos </v-toolbar-title>
          <v-spacer></v-spacer>
          <producto v-if="permiso.nuevo" :tipo="'Nuevo'"  @refresh="toUpdate"></producto>
        </v-toolbar>


        <v-list three-line subheader class="sau-dataTable__background">
          <br />

          <!-- aqui -->
          <div class="sau__busqueda-superior">
            <div class="sau__busqueda-superior__title">Listado de Productos </div>
                <v-spacer></v-spacer>
            <compBusqueda :param="filter" @objeto="filtrado" ></compBusqueda>
          </div>

          <v-list-item>
            <v-list-item-content>
              <vuetable
                ref="vuetable"
                :fields="fields"
                :api-mode="false"
                :data="object"
                :show-sort-icons="true"
                pagination-path=""
                :css="css.table"
                id="mytable"
                class="mb-5 bg-white rounded"
                @vuetable:row-clicked="onRowCLicked"
              >
                <template slot="accion" slot-scope="props">
                  <v-card-actions>
                    <div class="text-center"> 
                      <producto v-if="permiso.modificar" :producto="props.rowData" :tipo="'Modificando'" ></producto>
                    </div>
                  </v-card-actions>
                </template>
              </vuetable>
              <pagination ref="pagination" :data="object" @click="pagination">
              </pagination>
            </v-list-item-content>
          </v-list-item>
        </v-list>
        <v-list three-line subheader class="sau-dataTable__background">

          
          <div class="row">
              <v-toolbar class="sau-dataTable__title white--text px-4">
                <v-toolbar-title>Clientes que adquirieron los productos</v-toolbar-title>
                <!-- <v-spacer></v-spacer> -->

                <div class="text-right">
                  
                  <!--este boton me queda 
                      <contrato
                        v-if="permiso.asociar"
                        :show="tipoModal.altaproducto"
                        :cliente="cliente"
                        :productos="prod"
                        @refresh="toUpdate"
                      >
                      </contrato>
                  -->
                </div>
              </v-toolbar>
          </div>

<!-- aqui -->
          <v-list-item> 
            <div class="row">
              <detallecliente ref="listctacte"  :cliente="obcliente" :idproducto="producto_id"  :permisopago="permiso.asociar" :NombreProducto="this.producto_nombre"></detallecliente>
            </div>
          </v-list-item>
<!-- fin aqui -->
        </v-list>
        
      </v-card>
    </v-container>
    <loader :load="load"></loader>
  </v-row>
</template>
<script>

import detallecliente from "../Cliente/detalle_cliente";
import contrato from "../Contrato/alta";
import producto from "../Producto/nuevo";



export default {
  name: "Producto",
  props: ["show","permiso"],
  data() {
    return {
      on:'',
      attrs:'',
      css: CssVuetable,
      tipoModal: { altaproducto: true },
      dialog: this.show,
      notifications: false,
      filter: {
        page: "home/Camus/util/producto/filtrado",
        msj: "",
      },
      sound: true,
      widgets: false,
      object: [],
      obcliente: [],
      producto_id:0,
      producto_nombre:'',
      cliente_id:0,
      load:false,
      prod: [],
      page: "home/Camus/producto/data",
      fields: [
         {
          name: "id",
          title: "Cod Producto",
          visible: true,
        },
        {
          name: "Nombre",
          title: "Nombre",
          visible: true,
        },
        {
          name: "Descripcion",
          title: "Descripción",
          visible: true,
        },
        {
          name: "Nro_Producto",
          title: "Nro Producto",
          visible: true,
        },
        {
          name: "Precio",
          title: "Precio",
          visible: true,
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
    detallecliente,
    contrato,
    producto
  },
  created() {
    this.permiso = JSON.parse (this.permiso)
    this.index();
  },
  mounted() {
    
    
    this.index();
    this.productos();
  },
  methods: {
    index() {
      try {
        this.load=false
        axios
          .get(this.page)
          .then((response) => {
            if (response.data.status == 0) {
              
              this.object = response.data.data;
            } else {
              console.log("error");
            }
          })
          .catch((error) => {
            this.load=false
            console.log(error);
          })
          .finally(() =>  this.load=false);
      } catch (error) {
        this.load=false
        console.log(error);
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
    cliente(){
      try {
        axios
          .get("home/Camus/cliente/showproductocliente/"+this.producto_id+"/")
          .then((response) => {
            
            this.obcliente = response.data.data;
            
          })
          .catch((error) => {
            console.log(error);
          })
          .finally(() => console.log(""));
      } catch (error) {
        console.log(error);
      }
    },
    onRowCLicked(row) {
      if (row.data){
        $('[item-index]').css('background-color','transparent')
        $('[item-index="'+row.index+'"]').css('background-color','#1976d25e')
        this.producto_id = row.data.id;
        this.producto_nombre = row.data.Nombre;
        this.cliente()
      }
      
    },
    toUpdate:function(r){
      
      switch (r) {
        case 'cliente':
          this.index()
          this.obcliente = this.cliente 
          break;
      }
    },
    pagination(url, tableid) {
      /*-pagination : [traela url de la paginacion y el id de la vue table] */
      this.page = url;
      this.index();
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
  },
};
</script>
