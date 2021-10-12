<template >
  <div class="">
    <v-dialog v-model="dialog" width="100%" persistent>
      <template v-slot:activator="{ on, attrs }">
          <v-btn
                class="mx-2" 
                text
                v-bind="attrs"
                v-on="on"
                dark
                color="deep-white accent-4"
          >
              Asociar Producto al Cliente
               
          </v-btn>
      </template>
      <v-card>
        <v-card-title class="blue lighten-1 text-white">
            Asociar Producto al cliente [{{cliente.Nombre_Apellido}} - {{cliente.id }}]
        </v-card-title>

        <v-card-text>
          <template>
            <v-form v-model="valid">
              <v-container>
                <v-row style="ali">
                  <v-col cols="9" md="9" >
                    <!-- Se selecciona el Producto -->
                    <v-container fluid>
                      <v-combobox
                        :items="productos"
                        :search-input.sync="search"
                        hide-selected
                        hint=""
                        label="Busqueda de Producto"
                        :allow-overflow="false"
                        :return-object="true"
                        persistent-hint
                        small-chips
                        @change="selectproducto"
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
                    </v-container>
                  </v-col>
                  <v-col cols="3" md="3">
                      <nuevoProducto  :cliente="cliente" @refresh="toUpdate" :tipo="'_Nuevo'"></nuevoProducto>
                  </v-col>
                </v-row>
                <v-divider></v-divider>
                <v-row>
                  <v-col cols="12" md="3">
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
                          label="Fecha de compra"
                          prepend-icon="mdi-calendar"
                          readonly
                          hint="MM/DD/YYYY format"
                          persistent-hin
                          v-bind="attrs"
                          v-on="on"
                        ></v-text-field>
                        
                      </template>
                      <v-date-picker
                        v-model="obj.Fecha_Compra"
                        no-title
                        @input="menu2 = false"
                      ></v-date-picker>
                    </v-menu>
                  </v-col>
                 
                  <v-col cols="12" md="3">
                    <v-text-field
                      v-model="obj.Cuotas"
                      :rules="Rules.numberRules"
                      label="Cantidad de Cuotas"
                      required
                      @keyup="calculacuota"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" md="3">
                    <v-text-field
                      v-model="obj.MontoCuota"
                      :rules="Rules.decimalRules"
                      label="Monto de la Cuota"
                      required
                      prefix="$"
                      @keyup="calcularXmcontocuota"
                    ></v-text-field>
                  </v-col>
                  
                  <v-col cols="12" md="3">
                    <v-text-field
                      v-model="obj.Total"
                      :rules="Rules.decimalRules"
                      label="Precio de la Financiacion"
                      required
                      prefix="$"
                      @keyup="calculacuota"
                    ></v-text-field>
                  </v-col>
                  
                  <v-col cols="12" md="3">
                    <v-text-field
                      v-model="obj.Entrega"
                      :rules="Rules.decimalRules"
                      label="Entrega"
                      required
                      prefix="$"
                      @keyup="calculacuota"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" md="3">
                    <v-text-field
                      v-model="MontoTotal"
                      :rules="Rules.decimalRules"
                      label="Total"
                      readonly
                      
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" md="3">
                    <v-combobox
                      v-model="obj.Financiacion"
                      :items="itemFinanciacion"
                      label="Financiación"
                      outlined
                      dense
                    ></v-combobox>
                  </v-col>
                  <v-col cols="12" md="3">
                        <v-combobox
                          :items="itemVendedor"
                          :search-input.sync="search"
                          hide-selected
                          hint=""
                          label="Busqueda de Vendedores"
                          :allow-overflow="true"
                          :return-object="true"
                          persistent-hint
                          small-chips
                          @change="selectvendedor"
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
                  </v-col> 
               
                </v-row>
                 
                
                <v-row> </v-row>
              </v-container>
            </v-form>
          </template>
        </v-card-text>

        <v-divider></v-divider>
       
        <v-card-actions>
          <v-spacer></v-spacer>
          <msjAlerta :msj="alerta"></msjAlerta>
          <v-btn color="primary" text @click="closealert()"> Salir </v-btn>
          <v-btn v-if="tipo=='nuevo'" color="primary" text @click="guardar()"> Asociar </v-btn>
          <v-btn v-if="tipo=='modificar'" color="primary" text @click="modificar(idCtacte.id)"> Modificar </v-btn>
        </v-card-actions>
      </v-card>
      <loader :load="load"></loader>
    </v-dialog>
  </div>
</template>
<script>
import nuevoProducto from '../Producto/nuevo'
export default {
  name:'contrato',
  props: ["show", "cliente", "productos","tipo","idCtacte"],
  data() {
    return {
      dialog: false,
      menu: false,
      load:false,
      search: "",
      page: "/home/Camus/ctacte/data",
      alerta: { mensaje: "", visible: false, tipo: 0 },

      obj: {
        Fecha_Compra: new Date().toISOString().substr(0, 10),
        Total: 0,
        Resto: 0,
        Cuotas: 0,
        Entrega: 0,
        MontoCuota: 0,
        Resto_Cuotas:0,
        Financiacion: "Semanal",
        Porcentaje: 0,
        producto_id: "",
        cliente_id: "",
        user_id: "",
      },
      MontoTotal:0,
      valid: false,
      itemFinanciacion: ["Día", "Semanal", "Mensual", "Anual"],
      itemVendedor: [],
      on:'',
      attrs:'',
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
    };
  },
  computed:{
    Fecha_Compracomputada(){
      return this.formatDate(this.obj.Fecha_Compra)
    }
  },
  components:{
    nuevoProducto
  },
  watch:{
    
    dialog(v){
      
      if (this.tipo != 'nuevo'){
          this.obj = this.idCtacte
      }
    }
  },
  created() {
    this.listVendedor()
  },
    
  methods: {
    selectproducto(p) {
      this.obj.producto_id = p.value;
    },
    selectvendedor(v) {
      this.obj.user_id = v.value;
    },
    guardar() {
      this.obj.cliente_id = this.cliente.id;
      this.obj.Resto = this.obj.Total;
      this.obj.Resto_Cuotas = this.obj.Cuotas
      let param = this.obj;
      try {
        this.alerta.mensaje=''
        this.load=true
        axios
          .post(this.page, param)
          .then((response) => {
            
            if (response.data.status == 0) {
              /*alerta */
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
                                    .replace('id',' ')
                                    .replace('{','')
                                    .replace('}','')
                                    .split(',')
                errors.forEach(element => {
                    this.alerta.mensaje += element + ' - '       
                });
              }
              this.alerta.tipo = 9;
              this.alerta.visible = true;
              this.refresh()
            }
          })
          .catch((error) => {
            
            this.load=false
          })
          .finally(() => this.load=false);
      } catch (error) {
        console.log(error);
      }
    },
    modificar(id){
      this.obj.cliente_id = this.cliente.id;
      this.obj.Resto = this.obj.Total;
      let param = this.obj;
      try {
        this.alerta.mensaje=''
        this.load=true
        axios
          .put(this.page+'/'+id, param)
          .then((response) => {
            
            if (response.data.status == 0) {
              /*alerta */
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
                                    .replace('id',' ')
                                    .replace('{','')
                                    .replace('}','')
                                    .split(',')
                errors.forEach(element => {
                    this.alerta.mensaje += element + ' - '       
                });
              }
              this.alerta.tipo = 9;
              this.alerta.visible = true;
              this.refresh()
            }
          })
          .catch((error) => {
            
            this.load=false
          })
          .finally(() => this.load=false);
      } catch (error) {
        console.log(error);
      }
    },
    
    closealert() {
      this.dialog = false
    
      this.alerta = { mensaje: "", visible: false, tipo: 0 };
      this.obj = {
        Fecha_Compra: new Date().toISOString().substr(0, 10),
        Total: 0,
        Cuotas: 0,
        Financiacion: "Semanal",
        Porcentaje: 0,
        producto_id: "",
        cliente_id: "",
      };
      
    },
    toUpdate:function(r){
      
      switch (r) {
        case 'producto':
          this.listProductos()
          break;
      }
    },
    listProductos() {
      try {
        axios
          .get("/home/Camus/producto/comboproducto")
          .then((response) => {
            this.productos = response.data;
            
          })
          .catch((error) => {
            console.log(error);
          })
          .finally(() => console.log(""));
      } catch (error) {
        console.log(error);
      }
    },
    listVendedor(){
      try {
        axios
          .get("home/Camus/Users/combovendedor")
          .then((response) => {
            this.itemVendedor = response.data;
            
          })
          .catch((error) => {
            console.log(error);
          })
          .finally(() => console.log(""));
      } catch (error) {
        console.log(error);
      }
    },
    refresh(){
          this.$emit('refresh',['cliente'])
    },
    formatDate(d){
     
      var fecha = d.split('-')
      return fecha[2]+'/'+fecha[1]+'/'+fecha[0]
    },
    calculacuota(key){
      if (this.obj.Cuotas >= 0 && this.obj.Total >=0){
        this.obj.MontoCuota = (this.obj.Total / this.obj.Cuotas).toFixed(2)
        this.MontoTotal = (parseFloat(this.obj.Total) + parseFloat(this.obj.Entrega)).toFixed(2)
      }
    },
    calcularXmcontocuota(key){
      if (this.obj.Cuotas >= 0 || this.obj.MontoCuota >= 0){
        this.obj.Total = (this.obj.MontoCuota * this.obj.Cuotas).toFixed(2)
        this.MontoTotal = (parseFloat(this.obj.Total) + parseFloat(this.obj.Entrega)).toFixed(2)
      }

    }
  },
  
};
</script>