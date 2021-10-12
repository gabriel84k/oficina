<template>
  <div class="text-center">
    <v-dialog v-model="dialog" width="100%" persistent>
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          dark 
          title="Nuevo Producto"
          class="ma-2"
          outlined
          x-small
          fab
          v-bind="attrs"
          v-on="on"
          :color="(tipo == 'Nuevo')?'withe':(tipo == '_Nuevo')?'cyan':'cyan'"
        >
          <v-icon v-if="(tipo != 'Modificando')" dark> mdi-plus  </v-icon>
          <v-icon v-else >mdi-pencil</v-icon>
        </v-btn>
      </template>

      <v-card>
        <v-card-title class="blue lighten-1 text-white"> {{tipo}} Producto </v-card-title>

        <v-card-text>
          <template>
            <v-form v-model="valid">
              <v-container>
                <v-row style="ali">
                  
                    <v-col cols="12" md="4">
                        <v-text-field
                            v-model="obj.Nombre"
                            label="Nombre del Producto"
                            required
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-text-field
                            v-model="obj.Descripcion"
                            label="Descripción del producto"
                            required
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-text-field
                            v-model="obj.Nro_Producto"
                            :rules="Rules.numberRules"
                            label="Numero Int. Producto"
                            required
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" md="4">
                        <v-text-field
                            v-model="obj.Precio"
                            :rules="Rules.decimalRules"
                            label="Precio del Producto"
                            required
                            prefix="$"
                        ></v-text-field>
                    </v-col>
                    
                    <template>
                    <v-col cols="12" md="4">
                        <v-container
                            class="px-0"
                            fluid
                        >
                            <v-switch
                            v-model="obj.Estado"
                            :label="'Estado'"
                            ></v-switch>
                        </v-container>
                    </v-col>
                    </template>
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
          <v-btn v-if="(tipo == 'Nuevo') || (tipo == '_Nuevo')" color="primary" text @click="guardar()"> Guardar </v-btn>
          <v-btn v-else color="primary" text @click="modificar()"> Modificar </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <loader :load="load"></loader>
  </div>
</template>
<script>
export default {
    props: ["producto", 'tipo'],
    data() {
        return {
        dialog: false,
        menu: false,
        search: "",
        page: "/home/Camus/producto/data",
        load:false,
        alerta: { mensaje: "", visible: false, tipo: 0 },
        obj: {
            Nombre: "",
            Descripcion: "",
            Nro_Producto: 0,
            Precio: 1,
            Estado: true,
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
    watch: {
        producto(val) {
            this.obj=val
        },
     },
    methods: {
        guardar() {
            this.load=true
            let param = this.obj;
            try {
                axios
                .post(this.page, param)
                .then((response) => {
                    this.alerta.mensaje =''
                    if (response.data.status == 0) {
                        //alerta//
                        this.alerta.mensaje = response.data.descripcion;
                        this.alerta.tipo = 1;
                        this.alerta.visible = true;
                        this.refresh();
                        
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
                            this.alerta.tipo = 9;
                            this.alerta.visible = true;
                        }
                    }
                })
                .catch((error) => {
                    console.log(error);
                    this.load=false
                })
                .finally(() => this.load=false);
            } catch (error) {
                console.log(error);
                this.load=false
            }
            
        },
        modificar() {
            let param = this.obj;
            try {
                this.load=true
                axios
                .put(this.page + "/" +this.obj.id , param)
                .then((response) => {
                    this.alerta.mensaje =''
                    if (response.data.status == 0) {
                        //alerta//
                        this.alerta.mensaje = response.data.descripcion;
                        this.alerta.tipo = 1;
                        this.alerta.visible = true;
                        this.refresh();
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
                            this.alerta.tipo = 9;
                            this.alerta.visible = true;
                            this.refresh();
                        }
                    }
                })
                .catch((error) => {
                    console.log(error);
                     this.load=false
                })
                .finally(() =>  this.load=false);
            } catch (error) {
                console.log(error);
                this.load=false
            }
            
        },
        closealert() {
            this.dialog = false;
            this.alerta = { mensaje: "", visible: false, tipo: 0 };
            this.obj = {
                Nombre: "",
                Descripcion: "",
                Nro_Producto: 0,
                Precio: 0,
                Estado: true,
            };
        },
        refresh(){
            this.$emit('refresh','producto')
        }
    }
};
</script>