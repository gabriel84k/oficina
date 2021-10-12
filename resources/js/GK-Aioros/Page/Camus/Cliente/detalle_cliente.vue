<template>
  <v-banner two-line style="width:100% " >
    <br>
    <!-- SECCION DETALLE PRODUCTO -->
    <div class="d-flex flex-wrap justify-space-between detalle_producto__botones">
        <filtradobotones :page="'home/Camus/util/ctacte/filtradocliente'" :msj="filter.msjbotones" :id="idproducto" @objeto="filtrado" class="detalle_producto__botones"></filtradobotones>
        <!-- <v-spacer></v-spacer> -->
        
        <compBusqueda :param="filter" :id="idproducto" @objeto="filtrado">
        </compBusqueda>
   
    </div>
    <br>
    <!-- <v-divider></v-divider> -->
    <div class="row ">
        
        <v-expansion-panels >
            <div  v-for="(itemcliente,indexcliete) in cli" :key="indexcliete"  class="col-12 ">
                <v-expansion-panel v-if="itemcliente.ctacte.length > 0"  class="sau-border-card-producto">
                    <v-expansion-panel-header>
                        Cliente: <b> {{itemcliente.Nombre_Apellido}}</b>
                    </v-expansion-panel-header>
                    <v-expansion-panel-content >
                        <div  v-for="(items,index) in itemcliente.ctacte" :key="index" >
                                <v-card class="mx-2 " outlined >
                                    <p class="col ">Producto: <b>{{NombreProducto}}</b></p>


      <!-- lista vieja -->
      <!-- fin lista vieja -->
                                                          <v-list-item three-line>
                  <v-card-text >
                      <div class="row">
                          <p class="h6"> Cod. del Producto</p> 
                          <v-spacer></v-spacer> 
                          <p class="h6 grey--text">{{items.id}}</p> 
                      </div>
                      <div class="row">
                          <p class="h6">Valor del Producto</p> 
                          <v-spacer></v-spacer> 
                          <p class="h6 grey--text"> ${{items.Total}}</p> 
                      </div>
                  
                      <div class="row ">
                          <p class="h6">Resto de la Deuda</p> 
                          <v-spacer></v-spacer> 
                          <p class="h6 grey--text">${{items.Resto}}</p>
                      </div>
                      <div class="row ">
                          <p class="h6">Cuotas financiadas</p> 
                          <v-spacer></v-spacer> 
                          <p class="h6 grey--text">{{items.Cuotas}}</p>
                      </div>
                      <div class="row ">
                          <p class="h6">Cuotas restantes</p> 
                          <v-spacer></v-spacer> 
                          <p class="h6 grey--text">{{items.Resto_Cuotas}}</p>
                      </div>

                                            <div class="row ">
                          <p class="h6">Porcentaje</p> 
                          <v-spacer></v-spacer> 
<!-- 
                                                                                      <v-progress-linear
                                                                    :value="items.Porcentaje">
                                                            </v-progress-linear> -->
                      </div>

                                            <div class="row ">
                          <p class="h6">Estado</p> 
                          <v-spacer></v-spacer> 
                                                            <v-alert
                                                                dense
                                                                text
                                                                :type="estadoctacte(items,'tipo')">
                                                                {{estadoctacte(items,'texto')}}
                                                            </v-alert> 
                      </div>
                                                                  <div class="row ">
                          <p class="h6">Acción</p> 
                          <v-spacer></v-spacer> 
                                                            <v-btn 
                                                                class="ma-2"
                                                                outlined
                                                                color="indigo"  
                                                                text
                                                                @click="modalPagoOpen(true, items.id)">
                                                                + Pago 
                                                            </v-btn>
                      </div>
                  </v-card-text>
<!-- fin yo  -->
                                    </v-list-item>




                                </v-card>
                            </div>
                    </v-expansion-panel-content>
                </v-expansion-panel>
             </div>
        </v-expansion-panels>
       
    </div>
    <br>
    <v-divider></v-divider>
    <modalpago :show="modalPagos" @closeModalPago="modalPagoOpen" :id="modalPagos.idItems" @refresh="toUpdate"></modalpago>
  </v-banner>
</template>
<script>
import filtradobotones from '../Otros/filtrobotones'
import modalpago from "../Contrato/pagos";
export default {
  props: ["cliente",'idproducto',"permisopago","NombreProducto"],
  data() {
    return {
      estadopago:{estado:'info',texto:'En Proceso'},
      modalPagos: { dialog: false, idItems:0, idCliente:this.cliente.id},
      cli: {},
      filter:{
        page: 'home/Camus/util/ctacte/filtradocliente',
        msj:'',
        msjbotones:''
      
      },
    };
  },
   components: {
    modalpago,
    filtradobotones
  },
  watch:{
        cliente(val){
          this.cli=val
        }
  },
  methods: {
    
    modalPagoOpen(e,idItems) {
      
      this.modalPagos.dialog = e
      this.modalPagos.idItems = idItems
      this.modalPagos.idCliente = this.cliente.id
    },
    filtrado(f){
      
      this.cli = f.data
    },
    
    listctacte(id){
      try {
        axios
          .get("home/Camus/cliente/"+id)
          .then((response) => {
            
            
            this.cli.ctacte = response.data.data.ctacte;
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
      
      
       
    }
    
  },
};
</script>