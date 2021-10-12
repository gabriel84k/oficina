<template >
  <v-banner two-line style="width:100% " >
    <br> 
    <!-- SECCION DETALLE  CLIENTE-->

    <div class="d-flex flex-wrap justify-space-between detalle_producto__botones">
        <filtradobotones :page="'home/Camus/util/ctacte/filtrobotones/'" :msj="filter.msjbotones" :id="cliente.id" @objeto="filtrado" class="detalle_producto__botones"></filtradobotones>
        <!-- <v-spacer></v-spacer> -->
 
        <compBusqueda :param="filter" :id="cliente.id" @objeto="filtrado" @msj="combinado">
        </compBusqueda>

    </div>
     <br>
     <!-- <v-divider></v-divider> -->

    <div class="row ">
      <div :class="existeProducto(items) " v-for="(items,index) in cliente.ctacte" :key="index" >
          <!-- Clientes -->
          <v-card class="mx-2 px-3 sau-border-card-producto">
              <v-card-text>
                <!-- <br> -->
                <div class="row justify-center mt-2" >
                  <!-- <v-spacer></v-spacer>  -->
                 
                    <v-alert 
                        dense
                        text
                        :type="estadoctacte(items,'tipo')" 
                      >
                        {{estadoctacte(items,'texto')}}
                    </v-alert> 
                    <v-btn 
                      v-if="permisomodificar" 
                      class="ma-2"
                      outlined
                      color="indigo"  
                      text
                      @click="modalContrato(true, items)" 
                    >
                        <v-icon dark> mdi-pencil </v-icon>
                    </v-btn>
                 
                </div>
              </v-card-text>
<!-- 
              <v-divider></v-divider> -->
              <v-list-item three-line>
                  <v-card-text>
                      <div class="row">
                          <p class="h6"> Cod. Producto</p> 
                          <v-spacer></v-spacer> 
                          <p class="h6 grey--text"> {{items.Nro_Producto}}</p> 
                      </div>
                      <div class="row">
                          <p class="h6"> Nombre del Producto</p> 
                          <v-spacer></v-spacer> 
                          <p class="h6 grey--text"> {{items.producto.Nombre}}</p> 
                      </div>
                      
                      <div class="row ">
                          <p class="h6">Descripción del Producto</p> 
                          <v-spacer></v-spacer> 
                          <p class="h6 grey--text">ver mas...</p>
                      </div>
                  
                      <div class="row ">
                          <p class="h6">Valor del Producto</p> 
                          <v-spacer></v-spacer> 
                          <p class="h6 grey--text">${{items.Total}}</p>
                      </div>
                      <div class="row ">
                          <p class="h6">Valor de la cuota</p> 
                          <v-spacer></v-spacer> 
                          <p class="h6 grey--text">${{items.MontoCuota}}</p>
                      </div>
                      <div class="row ">
                          <p class="h6">Resto de la deuda</p> 
                          <v-spacer></v-spacer> 
                          <p class="h6 grey--text">${{items.Resto}}</p>
                      </div>
                      <div class="row ">
                          <p class="h6">Cantidad de cuotas financiadas</p> 
                          <v-spacer></v-spacer> 
                          <p class="h6 grey--text">{{items.Cuotas}}</p>
                      </div>
                      <div class="row ">
                          <p class="h6">Cantidad de cuotas restantes</p> 
                          <v-spacer></v-spacer> 
                          <p class="h6 grey--text">{{items.Resto_Cuotas}}</p>
                      </div>
                      <div class="row ">
                          <p class="h6">Entrega Realizada</p> 
                          <v-spacer></v-spacer> 
                          <p class="h6 grey--text">{{items.Entrega}}</p>
                      </div>
                      <div class="row text-danger" v-if="items.Atrasado">
                          <p class="h6">Atrasado en [{{items.deudaCuota}}-Cuotas]</p> 
                          <v-spacer></v-spacer> 
                          <p class="h6">$ {{items.deudaMonto}}</p>
                      </div>
                  </v-card-text>
              
              </v-list-item>
              <v-divider></v-divider>
              <v-card-actions>
                  <v-btn 
                     
                      class="ma-2"
                      outlined
                      color="indigo"  
                      text
                      @click="modalPagoOpen(true, items)" 
                  >
                     + Pago 
                  </v-btn>
                  <v-spacer></v-spacer>
                  <v-progress-linear
                        :value="items.Porcentaje"
                  ></v-progress-linear>
              </v-card-actions>
          
          </v-card>
      
      </div>
    </div>
    <loader :load="load"></loader>
     
    <modalpago :show="modalPagos" @closeModalPago="modalPagoOpen" :id="modalPagos.idItems" @refresh="toUpdate" :cobrador="this.cliente.cobrador" :permisos="permisopago"></modalpago>
    <contrato
            :show="modalEditContrato.dialog"
            :cliente="cliente"
            :productos="modalEditContrato.Item"
            :tipo="'modificar'"
            :idCtacte="modalEditContrato.idCtacte"
            @refresh="toUpdate"
            @cerrarmodal="cerrarcontrato"
          >
    </contrato>
  </v-banner>
</template>
<script>
import filtradobotones from '../Otros/filtrobotones'
import modalpago from "../Contrato/pagos";
import contrato from "../Contrato/alta";
export default {
  props: ["cliente","permisopago","permisomodificar"],
  data() {
    return {
      estadopago:{estado:'info',texto:'En Proceso'},
      
      modalPagos: { dialog: false, idItems:0, idCliente:this.cliente.id },
      modalEditContrato: { dialog: false, Item:[], idCtacte:0},
      cli: this.cliente,
      load:false,
      filter:{
        page: 'home/Camus/util/ctacte/filtrado',
        msj:'',
        msjbotones:''
      },
    };
  },
   components: {
    modalpago,
    filtradobotones,
    contrato
  },
  methods: {
    modalContrato(e,Items){
      

      this.modalEditContrato.dialog = e
      this.modalEditContrato.Item={'text': Items.producto.Nombre,'value' : Items.producto.id}
      this.modalEditContrato.idCtacte = Items
    },
    modalPagoOpen(e,Items) {
     
      this.modalPagos.dialog = e
      this.modalPagos.idItems = Items.id
      this.modalPagos.idCliente = this.cliente.id
    },
    filtrado(f){
      this.load=false
      this.cliente.ctacte = f.data
    },
    combinado(msj){
      this.filter.msjbotones=msj
    },
    existeProducto(p){
      if (p.producto){
        return 'col-md-4 producto'

      }else{
        return ''
      }
    },
    listctacte(id){
      try {
        axios
          .get("home/Camus/cliente/data/"+id)
          .then((response) => {
            this.cliente.ctacte = response.data.data.ctacte;
          })
          .catch((error) => {
            console.log(error);
          })
          .finally(() => console.log(""));
      } catch (error) {
        console.log(error);
      }
    },
    toUpdate(r,id){
      switch (r) {
        case 'producto':
          this.listctacte(id)
          break;
        
        case 'ctacte':
          //this.index(this.cliente.id)
          //this.cliente = this.cliente 
          break;
      }
    },
   
    estadoctacte(i,tipo){
      let estado = ""
      let texto = ""
      if(i.Resto == 0) {
        estado='success'
        texto='Completado'
      }else if(i.Resto > 0){
        estado='info'
        texto='En Proceso'
      }else if(i.Resto < 0){
        estado='warning'
        texto='En Proceso'
      }
      if (tipo == 'texto'){
        return texto
      }else{
        return  estado
      }
    },
    cerrarcontrato(){
      this.modalEditContrato.dialog = false
    },
  },
  
};
</script>