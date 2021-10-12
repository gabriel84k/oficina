<template>
  <div class="text-center">
    <v-dialog v-model="dialog" width="100%" persistent>
      <template v-slot:activator="{ on, attrs }" >
        <v-btn
          class="mx-2 " 
          :title="tipo" 
          fab  
          outlined 
          x-small 
          v-bind="attrs"
          v-on="on"
          :color="(tipo == 'Nuevo')?'withe':'cyan'"
          @click="listar"
        >
            <v-icon v-if="(tipo == 'Modificando')" dark> mdi-pencil </v-icon>
            <v-icon v-else >mdi-plus</v-icon>
          
        </v-btn>
      </template>

      <v-card>
        <v-card-title class="blue lighten-1 text-white"> {{tipo}} Cliente </v-card-title>

        <v-card-text>
          <template>
            <v-form v-model="valid">
              <v-container>
               <v-row>
                    <v-col cols="12" md="4">
                        <v-text-field
                            v-model="obj.Nombre_Apellido"
                            label="Nombre y Apellido del Cliente"
                            required
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-text-field
                            v-model="obj.Domicilio"
                            label="Domicilio del Cliente"
                            required
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-text-field
                            v-model="obj.Dni"
                            :rules="Rules.numberRules"
                            label="Dni"
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-row>
                    
                    <v-col cols="12" md="4">
                        <v-text-field
                            v-model="obj.Telefono"
                            :rules="Rules.numberRules"
                            label="Teléfono"
                        ></v-text-field>
                    </v-col>
                
                    <v-col cols="12" md="4">
                        <v-text-field
                            v-model="obj.Celular"
                            :rules="Rules.numberRules"
                            label="Celular"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-text-field
                            v-model="obj.Observaciones"
                            label="Observaciones"
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-row>    

                    <v-col cols="12" md="4">
                        
                        <v-combobox
                          :items="itemZona"
                          item-text="text"
                          item-value="value"
                          v-model="itemzonatext"
                          :search-input.sync="search"
                          hide-selected
                          hint=""
                         
                          label="Busqueda de Zona"
                          :allow-overflow="false"
                          :return-object="true"
                          persistent-hint
                          small-chips
                          @click="listZonas"
                          @change="selectzona"
                        >
                        <template v-slot:no-data>
                          <v-list-item>
                            <v-list-item-content>
                              <v-list-item-title>
                                No existen resultados "<strong>{{
                                  search
                                }}</strong
                                >"
                              </v-list-item-title>
                            </v-list-item-content>
                          </v-list-item>
                        </template>
                      </v-combobox>
                      </v-col>
                    <v-col cols="12" md="4">
                        <v-combobox
                          v-model="obj.dia"
                          :items="itemDia"
                          label="Seleccion de Día"
                          outlined
                          dense
                         
                        ></v-combobox>
                    </v-col>
                    <v-col cols="12" md="4" >
                        <v-combobox
                            :items="itemOrden"
                            :value="itemOrden[obj.Orden - 1]"
                            :search-input.sync="search"
                            hide-selected
                            
                            hint=""
                            label="Orden de visita (Antes de)"
                            :allow-overflow="false"
                            :return-object="true"
                            persistent-hint
                            small-chips
                            @change="selectOrden"
                        >
                        <template v-slot:no-data>
                          <v-list-item>
                            <v-list-item-content>
                              <v-list-item-title>
                                No existen resultados "<strong>{{
                                  search
                                }}</strong
                                >"
                              </v-list-item-title>
                            </v-list-item-content>
                          </v-list-item>
                        </template>
                      </v-combobox>

                    </v-col>
                    <v-col cols="12" md="4">
                        <v-container
                            class="px-0"
                            fluid
                        >
                            <v-switch
                            v-model="obj.Estado"
                            :label="`Estado: ${obj.Estado.toString()}`"
                            ></v-switch>
                        </v-container>
                    </v-col>
                    <v-col cols="12" md="4" >
                        <v-combobox
                            :items="itemCobrador"
                            v-model="id_cobrador"
                            item-text="name"
                            item-value="id"
                            :search-input.sync="search"
                            hide-selected
                            hint=""
                            label="Seleccionar Cobrador"
                            :allow-overflow="false"
                            :return-object="true"
                            persistent-hint
                            small-chips
                           
                        >
                        <template v-slot:no-data>
                          <v-list-item>
                            <v-list-item-content>
                              <v-list-item-title>
                                No existen resultados "<strong>{{
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
               
              </v-container>
            </v-form>
          </template>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <msjAlerta :msj="alerta"></msjAlerta>
          <v-btn color="primary" text @click="closealert()"> Salir </v-btn>
          <v-btn v-if="(tipo == 'Nuevo')" color="primary" text @click="guardar()"> Guardar </v-btn>
          <v-btn v-else color="primary" text @click="modificar()"> Modificar </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <loader :load="load"></loader>
  </div>
</template>
<script>
export default {
    props: ["cliente", 'tipo', 'show'],
    data() {
        return {
            itemCobrador:[],
            id_cobrador:{name:'',id:0},
            dialog: false,
            menu: false,
            search: "",
            load:false,
            page: "/home/Camus/cliente/data",
            alerta: { mensaje: "", visible: false, tipo: 0 },
            itemZona:[],
            itemOrden:[],
            itemzonatext:'',
            itemDia:['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'],
            obj: {
                Nombre_Apellido:'', 
                Domicilio:'', 
                Localidad:'', 
                Dni:0, 
                Telefono:0, 
                Celular:0, 
                Observaciones:'',
                dia:'',
                Estado: true,
                Orden:0,
                zona_id:0
            },
            valid: false,

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
                (v) => /^[0-9,]{1,16}$/.test(v) || "Valor no Valido",
                ],
            },
        };
    },
    watch:{
        dialog(val){
         
            if (val){
                if (this.cliente){
                    this.obj=this.cliente
                }
                
                this.listCobrador()
                this.listZonas()
            }
        }
    },
    created() {
        
    },
  
    methods: {
        selectzona(z) {
            this.obj.zona_id = z.value;
            this.listOrden()
        },
        selectOrden(o){
            this.obj.Orden = o.value;
        },
        listCobrador(){
            
            try {
                axios
                .get("home/Camus/Users/combocobrador")
                .then((response) => {
                    this.itemCobrador = response.data;
                    this.itemCobrador.forEach(element => {
                        
                        if (element.id == this.obj.user_id){
                            this.id_cobrador.id = element['id']
                            this.id_cobrador.name = element['name']
                        }
                    });
                })
                .catch((error) => {
                    console.log(error);
                })
                .finally(() => console.log(""));
            } catch (error) {
                console.log(error);
            }
            
        },
        listZonas(){
            try {
                axios
                .get("home/Camus/cliente/combozona")
                .then((response) => {
                    console.log('zona')
                    this.itemZona = response.data
                    response.data.forEach(element => {
                        if (element.value == this.obj.zona_id){
                            this.itemzonatext = element.text
                        }
                         
                    });
                 
                    this.itemOrden = []
                    
                })
                .catch((error) => {
                    console.log(error);
                })
                .finally(() => console.log(""));
            } catch (error) {
                console.log(error);
            }
        },
        listOrden(){
            try {
                axios
                .get("home/Camus/cliente/orden/"+this.obj.zona_id)
                .then((response) => {
                    this.itemOrden = response.data;
                    
                })
                .catch((error) => {
                    console.log(error);
                })
                .finally(() => console.log(""));
            } catch (error) {
                console.log(error);
            }
        },
        guardar() {
            this.obj.user_id = this.id_cobrador.id
            let param = this.obj;
           
            if (this.itemDia.indexOf(this.obj.dia) > -1){
                try {
                    this.load=true
                    axios
                    .post(this.page, param)
                    .then((response) => {
                            
                            this.alerta.mensaje=''   
                            if (response.data.status == 0) {
                                //alerta//
                                this.alerta.mensaje = response.data.descripcion;
                                this.alerta.tipo = 1;
                                this.alerta.visible = true;
                                
                                this.refresh('clientenuevo');
                                
                            } else {
                                if (response.data.descripcion != ""){
                                    this.alerta.mensaje = response.data.descripcion;
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
                        
                        this.load=false
                    })
                    .finally(() => this.load=false);
                } catch (error) {
                    console.log(error);
                } 
            }else{
                this.alerta.mensaje += 'día:[No Existe el día]' + ' - '  
                this.alerta.tipo = 9;
                this.alerta.visible = true;
            } 
            
        }, 
        modificar() {
            
            this.obj.user_id = this.id_cobrador.id
            let param = this.obj;
            try {
                this.load=true
                axios
                .put(this.page +'/'+ this.obj.id, param)
                .then((response) => {
      
                    if (response.data.status == 0) {
                        //alerta//
                            this.alerta.mensaje = response.data.descripcion;
                            this.alerta.tipo = 1;
                            this.alerta.visible = true;
                            this.refresh('cliente');
                            
                        } else {
                            this.alerta.mensaje = response.data.descripcion;
                            this.alerta.tipo = 9;
                            this.alerta.visible = true;
                            
                            
                    }
                })
                .catch((error) => {
                    console.log(error);
                })
                .finally(() =>  this.load=false);
            } catch (error) {
                console.log(error);
            }
            
        },
        closealert() {
            this.dialog = false;
            this.alerta = { mensaje: "", visible: false, tipo: 0 };
            
        },
        refresh(tipo){
           
            this.$emit('refresh',[tipo])
        },
        botoncolor(tipo){
            
            switch (tipo) {
                case 'nuevo':
                    return'withe'
                case 'modificando':
                    return 'cyan'
                case 'eliminar':
                    return 'red'
                default:
                    return 'cyan'
            }
        },
        listar(){
            this.listZonas()
            this.listOrden()
        }
       
    }
};
</script>