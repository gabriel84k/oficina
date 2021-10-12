<template ref="ctacte_reporte">
  <v-row justify="center" id="modalMenu" >
    <v-container fluid>
      <v-card class="sau-dataTable__background reporte_full reporte_background">
      
        <v-toolbar class="sau-dataTable__title white--text ">
          <v-btn icon dark @click="closeModal">
            <v-icon>mdi-close</v-icon>
          </v-btn>
          <v-toolbar-title>Reporte </v-toolbar-title>
          <v-spacer></v-spacer>
          
        </v-toolbar>


        <v-list three-line subheader class="sau-dataTable__background reporte_background">
          <br />

          <v-subheader >Listado de reportes
                <v-spacer></v-spacer>
          </v-subheader>

           <!-- :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: -->
<div class="reporte_main">
    <!-- <div class="reporte_container"> -->
        <div class="row col-sm-12 reporte_container">
        
            <!-- Clientes-->

            <div class="sau-card-dashboard__2 sau-border-card sau-border-card-producto card_reporte">
                <a class="sau-card-dashboard__section" href="http://localhost/home/Camus/PDF/listadocliente">
                    <div class="sau-card-dashboard__section__title h2 sau-centrado">
                        Clientes

                    </div>
                    <div class="sau-card-dashboard__section__icons">
                    <div class="sau-card-dashboard__section__icons__container sau-centrado">
                        
                        <i class="fas fa-user-plus"></i>
                        </div>
                    </div>
                </a>
                <!-- <div class="sau-card-dashboard__section__description">
                    Texto Texto

                </div> -->
            </div>

            <!-- Cobradores-->

            <div  class="sau-card-dashboard__2 sau-border-card sau-border-card-producto card_reporte">
              <a class="sau-card-dashboard__section" href="http://localhost/home/Camus/PDF/listadocobrador" >
                    <div class="sau-card-dashboard__section__title h2 sau-centrado">
                        Cobradores
                    </div>
                    <div class="sau-card-dashboard__section__icons">
                    <div class="sau-card-dashboard__section__icons__container sau-centrado">
                        
                        <i class="fas fa-address-card"></i>
                        </div>
                    </div>
              </a>
                <!-- <div class="sau-card-dashboard__section__description ">
                    Texto Texto

                </div> -->
            </div>
                        <!-- Cobranza-->

            <div class="sau-card-dashboard__2 sau-border-card sau-border-card-producto card_reporte">
              <a class="sau-card-dashboard__section" href="/home/Camus/PDF/listadocobranza" >
                  <div class="sau-card-dashboard__section__title h2 sau-centrado">
                      Cobranza

                  </div>
                  <div class="sau-card-dashboard__section__icons">
                    <div class="sau-card-dashboard__section__icons__container sau-centrado">
                      <i class="fas fa-money-check-alt"></i>
                    </div>
                  </div>
               
              </a>
            </div>
            <div class="sau-card-dashboard__2 sau-border-card sau-border-card-producto card_reporte">
                <div class="form-group">
                  Seleccione Cobrador : 
                  <select class="form-select form-control-sm" aria-label="todos" v-model="itemCobrador">
                      <option selected value="0">Todos</option>
                      <option v-for="(val, ind) in items" :key="ind" :value="val.id">{{val.name}}</option>
                  </select>
                    
                </div>
              <a class="sau-card-dashboard__section" :href="'/home/Camus/PDF/listadocxcobrador/' + itemCobrador" >
                  <div class="sau-card-dashboard__section__title h2 sau-centrado">
                     x Cobrador 
                  </div>
                  <div class="sau-card-dashboard__section__icons">
                    <div class="sau-card-dashboard__section__icons__container sau-centrado">
                      <i class="fas fa-money-check-alt"></i>
                    </div>
                  </div>
               
              </a>
            </div>
                <!-- <div class="sau-card-dashboard__section__description">
                    Texto Texto

                </div> -->
          

            <!-- Vendedor-->

            <div  class="sau-card-dashboard__2 sau-border-card sau-border-card-producto card_reporte">
                    <div class="row col-12"> 
                      <div class="col-6">
                        Fecha Desde<input type="date" v-model="fecha.desde">
                      </div>
                      
                      <div class="col-6">
                        Hasta<input type="date" v-model="fecha.hasta">
                      </div>
                    </div>
                    
                    <div class="sau-card-dashboard__section__title h2 sau-centrado">
                        <a class="sau-card-dashboard__section" :href="'/home/Camus/PDF/listadorentabilidad/'+fecha.desde+'/'+fecha.hasta" >
                          Rentabilidad
                        </a>
                    </div>
                    <div class="sau-card-dashboard__section__icons">
                      <div class="sau-card-dashboard__section__icons__container sau-centrado">
                        
                        <i class="fas fa-user-tie"></i>
                      </div>
                    </div>
              
                <!-- <div class="sau-card-dashboard__section__description ">
                    Texto Texto

                </div> -->
            </div>

        </div>
    <!-- </div> -->
    </div>
<!-- ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::fin -->
        </v-list>
        <v-divider></v-divider>
        
      </v-card>
    </v-container>
  </v-row>
</template>

<script>

export default {
  name: "Producto",
  props: ["show","permiso"],
  data() {
    return {
      on:'',
      attrs:'',
      fecha:{desde:'',hasta:''},
      dialog: this.show,
      items:[],
      itemCobrador:0,
      filter: {
        page: "home/Camus/util/producto/filtrado",
        msj: "",
      },
      page: "home/Camus/producto/data",
     
    };
  },
  components: {
   
  },
  created() {
    this.permiso = JSON.parse (this.permiso)
    this.listCobrador()
    this.combousuarios();
  },
  methods: {
      listCobrador(){
        try {
          axios
            .get("home/Camus/Users/combocobrador")
            .then((response) => {
              this.items = response.data;
              
            })
            .catch((error) => {
              console.log(error);
            })
            .finally(() => console.log(""));
        } catch (error) {
          console.log(error);
        }
      },
      combousuarios(){

      },
      printCobranzas(){
          alert('PDF cobranza')
      },
      closeModal: function () {
        this.$emit("close", false);
    },
  },
}
</script>
