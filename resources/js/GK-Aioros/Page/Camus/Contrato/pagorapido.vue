<template>
  <div class="text-center">
    <v-dialog
      v-model="option.show"
      persistent
      width="100%"
    >
      <v-card>
        <v-card-title class="headline blue lighten-2 text-white">
          Tarjeta de Pago Rápido - [ Cliente: {{cliente.Nombre_Apellido}} - Nro: {{cliente.id}}  ]
        </v-card-title>

        <v-card-text>
          <br>
          <v-row>
            <v-col cols="12" md="3">
                <v-combobox
                  :items="itemCobrador"
                  v-model="id_cobrador"
                  :search-input.sync="search"
                  hide-selected
                  hint=""
                  required
                  item-text="name"
                  item-value="id"
                  label="Busqueda de Cobrador"
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
              </v-col> 
          </v-row>
          <v-row>
              <v-col  cols="12" md="6">
                <v-card>
                  <v-card-text>
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>N° Producto</th>
                          <th>Producto</th>
                          <th>Fecha de Pago</th>
                          <th v-if="permisopago.pago">Monto del Pago</th>
                          <th>Acción</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-show="obj[index].visible" v-for="(item,index) in cli.ctacte" :key="index" :id="'tr-'+index"  >
                            <td >{{item.producto.Nro_Producto}}</td>
                            <td><b>{{item.producto.Nombre}}</b></td>
                            <td>
                            
                              <v-menu
                                  ref="menu"
                                  v-model="obj[index].menu"
                                  :close-on-content-click="false"
                                  :nudge-right="40"
                                  transition="scale-transition"
                                  offset-y
                                  min-width="auto"
                                >
                                <template v-slot:activator="{ on, attrs }">
                                      <v-text-field
                                        v-model="obj[index].Fecha"
                                        label="Fecha de la Venta"
                                        hint="MM/DD/YYYY format"
                                        :id="'fecha-'+index"
                                       
                                        persistent-hin
                                        v-bind="attrs"
                                        v-on="on"
                                        @focus="muestraDetalle(obj[index].ctacte_id)"
                                    ></v-text-field>
                                </template>
                                  <v-date-picker
                                      v-model="obj[index].Fecha"
                                      no-title
                                      @input="obj[index].menu = false"
                                  ></v-date-picker>
                              </v-menu>
                            </td> 
                            <td v-if="permisopago.pago">
                              <v-text-field
                                  v-model="obj[index].Pago"
                                  :rules="Rules.decimalRules"
                                  label="Cuota"
                                  :id="'cuota-'+index"
                                  required
                                  prefix="$"
                                  @keyup="keyEnter"
                                  @focus="muestraDetalle(obj[index].ctacte_id)"
                                ></v-text-field>
                            </td>
                            <td>
                              <v-row>
                                <v-icon v-if="obj[index].check">mdi-bookmark-check-outline</v-icon>
                                <v-icon v-if="obj[index].check != true">mdi-information-variant</v-icon>
                                <v-icon color="green" @click="muestraDetalle(obj[index].ctacte_id)">mdi-eye-settings</v-icon>
                              </v-row>
                            </td>
                        </tr>
                      </tbody>
                    </table>
                  </v-card-text>
                </v-card>
              </v-col>
              <v-col  cols="12" md="6">
               
                <registropago :ctacte_id="ctacte_id" :permisopago="permisopago"></registropago>
              </v-col>
          </v-row>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <msjAlerta :msj="alerta"></msjAlerta>
          <v-spacer></v-spacer>
          <v-btn
            v-if="permisopago.pago"
            color="primary"
            text
            id="guardar2"
            @click="pagartodos()"
          >
           Procesar Todo
          </v-btn>
          <v-btn
            color="primary"
            text
            id="guardar1"
            @click="limpiar()"
          >
           Nuevo Pago
          </v-btn>
          <v-btn
            color="primary"
            text
            @click="closeModal()"
          >
           salir
          </v-btn>
        </v-card-actions>
      </v-card>
      <loader :load="load"></loader>
    </v-dialog>
  </div>
</template>
<script>
import registropago from './registropagos' 
import detallecliente from "../Cliente/detalle_cliente";
export default {
  props:['cliente','option','permisopago'],
  data() {
    return {
      
      cli:[],
      itemCobrador:[],
      id_cobrador:{'name':'','id':0},
      indexfin:0,
      show : this.option.show,
      alerta: { mensaje: "", visible: false, tipo: 0 },
      load:false,
      ctacte_id:0,
      page:'home/Camus/ctactedetalle/data',
      fecha: new Date().toISOString().substr(0, 10),
      obj :[],
      search:'',
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
    }
  },
  components:{
    registropago,
    detallecliente

  },
  computed:{
   
    Fecha_Compracomputada(){
     
      return this.formatDate(this.fecha)
    }
  },
  watch:{
    
    cliente(cli){
      this.ctacte_id = 0
      if (cli){
        $('tbody > tr').css('background-color', 'white');
        
        this.alerta.mensaje = ''
        this.alerta.visible = false
        
        $('#cuota-0').focus()
        let arr= new Array()
        let f = this.fecha
        cli.ctacte.forEach(function(element,index) {
           
            if (element.Resto_Cuotas > 0){
             
              arr[index]={ctacte_id:element.id,Fecha:f,Pago:element.MontoCuota,menu:false,Detalle:'',check:false,visible:true}
            }else{
              arr[index]={visible:false}
            }
        });
        
        this.obj = arr
        this.id_cobrador.id = cli.cobrador.id//esto es el cobrador
        this.id_cobrador.name = cli.cobrador.name//esto es el cobrador
        this.cli=cli 
        this.listCobrador()
      }
        //this.show = this.option.show
    },
   
  },
  methods: {
    pagar(i){
         try {
            this.load=true
            this.obj[i].user_id = this.id_cobrador.id
            axios
            .post(this.page, this.obj[i])
            .then((response) => {
                if (response.data.status == 0) {
                   
                    this.obj[i].check = true
                    $("#cuota-"+i).prop('disabled', true);
                    $("#fecha-"+i).prop('disabled', true);
                    $("#tr-"+i).css('background-color', '#44ff001c');
                    this.alerta.mensaje = response.data.descripcion;
                    this.alerta.tipo = 1;
                    this.alerta.visible = true;
                    this.ctacte_id = 0
                    this.ctacte_id = this.obj[i].ctacte_id
                    
                    
                    this.$emit('refresh',['refrescarcuenta',this.cli.id])
                    
                } else {
                    this.obj[i].check = false
                    $("#cuota-"+i).prop('disabled', false);
                    $("#fecha-"+i).prop('disabled', false);
                    $("#tr-"+i).css('background-color', '#ff00000a');
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
    pagartodos(){
        
         try {
            this.load=true
            
            axios
            .post(this.page+'/PagoRapido/'+this.id_cobrador.id, this.obj)
            .then((response) => {
                if (response.data.status == 0) {
                    $("#cuota-").prop('disabled', true);
                    $("#fecha-").prop('disabled', true);
                    $("#tr-").css('background-color', '#44ff001c');
                    this.$emit('refresh',['refrescarcuenta',this.cli.id])
                    this.alerta.mensaje = response.data.descripcion;
                    this.alerta.tipo = 1;
                    this.alerta.visible = true;
                    
                } else {

                    $("#cuota-").prop('disabled', false);
                    $("#fecha-").prop('disabled', false);
                    $("#tr-").css('background-color', '#ff00000a');
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
    limpiar(){
      $('tbody > tr').css('background-color', 'white');
      $("input").prop('disabled', false);
      
      this.alerta.visible = false;
      this.alerta.mensaje = ''
    },
    keyEnter(key){
     
      if (key.keyCode == 13){
          let name_id=key.target.id.split('-')
          this.pagar(name_id[1])
        
          name_id[1]=parseInt(name_id[1])+1
          if ( $("#"+name_id[0]+'-'+name_id[1]).length > 0 ) {
            
            $("#"+name_id[0]+'-'+name_id[1]).focus()
          }else{
            
            $("#guardar1").focus()
          }
      }
    },
    muestraDetalle(id){
      this.ctacte_id = id
    },
    formatDate(d){
      var fecha = d.split('-')
      return fecha[2]+'/'+fecha[1]+'/'+fecha[0]
    },
    selectcobrador(c){
        //this.id_cobrador = c;
    },
    listCobrador(){
      try {
        axios
          .get("home/Camus/Users/combocobrador?zona="+this.cli.zona_id)
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
    closeModal(){
      this.option.show = false
    }
  },
}
</script>
<style scoped>

table>tbody>tr>td{
  white-space: nowrap;
  vertical-align: middle;
}

</style>