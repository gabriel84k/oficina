
<template>
  <div class="text-center">
    <v-dialog v-model="show.dialog" width="500" persistent>
      <v-card>
        <v-card-title class="headline blue lighten-2 text-white">
          Listado de Pagos
         
        </v-card-title>

        <v-card-text>
          <v-list-item-content>
            <vuetable
              ref="vuetablepagos"
              :fields="fields"
              :api-mode="false"
              :data="object"
              :show-sort-icons="true"
              pagination-path=""
              :css="css.table"
              id="vuetablepagos"
              class="shadow-lg mb-5 bg-white rounded"
              
            >
              <template slot="accion" slot-scope="props">
                
                <v-card-actions> 
                    <editarCtacte  v-if="permisos.editpago" :ctacteDetalle="props.rowData" @refresh="refresh()"></editarCtacte>
                 </v-card-actions>
              </template>
            </vuetable>
            <pagination ref="pagination" :data="object" @click="pagination">
            </pagination>
          </v-list-item-content>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn v-if="permisos.pago" color="primary" text @click="showcargarPago(true)"
            >Nuevo Pagar
          </v-btn>
          <v-btn color="primary" text @click="closeModal()"> Salir </v-btn>
        </v-card-actions>
      </v-card>
      <!-- Template para pagar -->
      <template>
        <div class="text-center">
          <v-dialog v-model="abrirpago" width="500">
            <v-card>
              <v-card-title class="headline blue lighten-2 text-white">
                Nuevo Pago
              </v-card-title>

              <v-card-text>
                <v-list-item-content>
                  
                  <v-menu
                    v-model="menu"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    transition="scale-transition"
                    offset-y
                    min-width="auto"
                  >
                    <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                          v-model="Fecha_Compracomputada"
                          label="Fecha de la Venta"
                          prepend-icon="mdi-calendar"
                          hint="MM/DD/YYYY format"
                          persistent-hin
                          v-bind="attrs"
                          v-on="on"
                      ></v-text-field>
                    </template>
                    <v-date-picker
                        v-model="obj.Fecha"
                        no-title
                        @input="menu = false"
                    ></v-date-picker>
                  </v-menu>
                  <v-text-field
                    v-model="obj.Pago"
                    :rules="Rules.decimalRules"
                    label="Precio del Producto"
                    required
                    prefix="$"
                  ></v-text-field>
                   <v-text-field
                    v-model="obj.Detalle"
                    label="Detalle del Pago"
                    required
                  ></v-text-field>
                  <v-combobox
                      v-if="true"
                      :items="itemCobrador"
                      v-model="id_cobrador"
                      item-text="name"
                      item-value="id"
                      :search-input.sync="search"
                      hide-selected
                      hint=""
                      label="Busqueda de Cobradores"
                      :allow-overflow="true"
                      :return-object="true"
                      persistent-hint
                      small-chips
                      @change="selectcobrador"
                    >
                    <template v-slot:no-data>
                      <v-list-item>
                        <v-list-item-content>
                          <v-list-item-title>
                            No existen resulstados "<strong>{{
                              search
                            }}</strong
                            >"
                          </v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>
                    </template>
                  </v-combobox>
                </v-list-item-content>
              </v-card-text>

              <v-divider></v-divider>

              <v-card-actions>
                <v-spacer></v-spacer>
                 <msjAlerta :msj="alerta"></msjAlerta>
                <v-btn color="primary" text @click="nuevo('home/Camus/ctactedetalle/data',show.idItems)"> Pagar </v-btn>
                <v-btn color="primary" text @click="showcargarPago(false)">Salir</v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </div>
      </template>
    </v-dialog>
    <loader :load="load"></loader>
  </div>
</template>
<script>
import editarCtacte from './amb/editar'
export default {
  props: ["show","id","cobrador","permisos"],
  data() {
    return {
      id_cobrador:{'name':'','id':0},
      on:'',
      attrs:'',
      search:'',
      menu: false,
      load:false,
      dialog: this.show.dialog,
      alerta: { mensaje: "", visible: false, tipo: 0 },
      object: [],
      itemCobrador:'',
      obj: {
        Fecha: new Date().toISOString().substr(0, 10),
        Pago: '',
        Detalle: '',
        ctacte_id: this.show.idItems,
        user_id: 0

      },
      Rules: {
        nameRules: [
          (v) => !!v || "Este Campo es requerido",
          (v) => v.length <= 10 || "Name must be less than 10 characters",
        ],
        numberRules: [
          (v) => !!v || "Solo Valores numéricos",
          (v) => /^[0-9]{1,16}$/.test(v) || "Valor no Valido",
        ],
        decimalRules: [
          (v) => !!v || "Solo Valores numéricos",
          (v) => /^[0-9.]{1,16}$/.test(v) || "Valor no Valido",
        ],
      },
      abrirpago: false,
      css: CssVuetable,
      page:"",
      fields: [
        {
          name: "id",
          title: "#",
          visible: true,
        },
        {
          name: "Fecha",
          title: "Fecha",
          visible: true,
          formatter: (value) =>this.formatDate(value)
        },{
          name: "cobrador.name",
          title: "Cobrador",
          visible: true,
          
        },       
        {
          name: "Pago",
          title: "Pago",
          visible: true,
        },
        {
          name: "accion",
          title: "Acción",
          visible: true,
        },
      ],
    };
  },
  components:{
    editarCtacte
  },
  watch:{
    id(val){

      this.id_cobrador.name = this.cobrador.name
      this.id_cobrador.id = this.cobrador.id
      this.index("/home/Camus/ctacte/data/"+this.show.idItems)
    }
  },
  computed:{
    Fecha_Compracomputada(){
      return this.formatDate(this.obj.Fecha)
    }
  },
  created() {
    //this.permisos = JSON.parse (this.permisos)
    this.listCobrador()
  },
  methods: {
    selectcobrador(v) {
      this.obj.user_id = v.value;
    },
    index(page) {
      try {
        this.load=true
        axios
          .get(page)
          .then((response) => {
            if (response.data.status == 0) {
              this.object = response.data.data.detallepago;
            } else {
              console.log("error");
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
    nuevo(page,idItems){
        try {
            this.load=true
            this.obj.ctacte_id = idItems
            this.obj.user_id = this.cobrador.id
            axios
            .post(page, this.obj)
            .then((response) => {
                if (response.data.status == 0) {
                    this.object = response.data.data;
                    this.alerta.mensaje = response.data.descripcion;
                    this.alerta.tipo = 1;
                    this.alerta.visible = true;
                    this.refresh()
                } else {
                    if (response.data.descripcion != ""){
                      this.alerta.mensaje =response.data.descripcion;
                    }else{
                      var errors = JSON.stringify(response.data.errors)
                                          .replace('_',' ')
                                          .replace('{','')
                                          .replace('}','')
                                          .split(',')
                      errors.forEach(element => {
                          this.alerta.mensaje += element + ' - '       
                      });
                    }
                    this.alerta.tipo = 9;
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
    refresh(){
        this.index("/home/Camus/ctacte/data/"+this.show.idItems)
        
        this.$emit('refresh','producto',this.show.idCliente)
    },
    listCobrador(){
      try {
        axios
          .get("home/Camus/Users/combocobrador")
          .then((response) => {
            this.itemCobrador = response.data;
            
          })
          .catch((error) => {
            console.log(error);
          })
          .finally(() => console.log(""));
      } catch (error) {
        console.log(error);
      }
    },
    showcargarPago(n) {
      this.abrirpago = n;
      this.alerta = { mensaje: "", visible: false, tipo: 0 };
      this.obj= {
        Fecha: new Date().toISOString().substr(0, 10),
        Pago: '',
        Detalle: '',
        ctacte_id: this.show.idItems,
        user_id: 0
      }
    },
    pagination(url, tableid) {
      /*-pagination : [traela url de la paginacion y el id de la vue table] */
   
      this.index(url);
    },
    closeModal: function () {
      this.$emit("closeModalPago", false, 0);
    },
    formatDate(d){
      var fecha = d.split('-')
      return fecha[2]+'/'+fecha[1]+'/'+fecha[0]
    }
  },
};
</script>