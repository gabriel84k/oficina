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
        <v-card-title class="blue lighten-1 text-white"> Imágenes </v-card-title>

        <v-card-text>
          <template>
            <v-form v-model="valid">
              <v-container>
                <v-row>    

                    <v-col cols="12" md="12">
                        
                        <v-file-input
                            v-model="itemImg"
                            counter
                            multiple
                            show-size
                            color="deep-purple accent-4"
                            label="Imágenes"
                            placeholder="Selecciones sus Imágenes"
                            outlined
                            prepend-icon="mdi-camera"
                            accept="image/png, image/jpeg, image/bmp"
                            truncate-length="30"
                            @change="selecionImagen"
                        >
                            <template v-slot:selection="{ index, text }">
                                <v-chip
                                    v-if="index < 2"
                                    color="deep-purple accent-4"
                                    dark
                                    label
                                    small
                                >
                                    {{ text }}
                                </v-chip>

                                <span
                                    v-else-if="index === 2"
                                    class="text-overline grey--text text--darken-3 mx-2"
                                >
                                    +{{ itemImg.length - 2 }} File(s)
                                </span>
                            </template>
                        </v-file-input>
                    </v-col>
                    
                </v-row>
                <v-row>    
                    <v-col v-for="n in itemImg" :key="n" class="d-flex child-flex" cols="2" >
                        <v-img
                            :src="convercion(n)"
                           
                            :lazy-src="n"
                            aspect-ratio="1"
                            class="grey lighten-2"
                        >
                            <template v-slot:placeholder>
                                <v-row
                                    class="fill-height ma-0"
                                    align="center"
                                    justify="center"
                                >
                                    <v-progress-circular
                                        indeterminate
                                        color="grey lighten-5"
                                    ></v-progress-circular>
                                </v-row>
                            </template>
                        </v-img>
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
    props: ['tipo','albun'],
    data() {
        return {
            dialog: false,
            menu: false,
            search: "",
            load:false,
            page: "/home/Ikki/Galeria/data",
            alerta: { mensaje: "", visible: false, tipo: 0 },
            itemImg:[],
            valid: false,
        };
    },
    methods: {
        
        convercion(img){
            const file = img;
            console.log(URL.createObjectURL(file));
            return URL.createObjectURL(file)
        },
        guardar() {
            
           
            if (this.itemImg.length > 0){
                let formData = new FormData();
                formData.append('albun', this.albun)
                this.itemImg.forEach((element,ind) => {
                    formData.append('imagen-'+ind, element)
                });
                
                try {
                    this.load=true
                    axios
                    .post(this.page, formData)
                    .then((response) => {
                            
                            this.alerta.mensaje=''   
                            if (response.data.status == 0) {
                                //alerta//
                                this.alerta.mensaje = response.data.descripcion;
                                this.alerta.tipo = 1;
                                this.alerta.visible = true;
                                //this.refresh('clientenuevo');
                                
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
        closealert() {
            this.dialog = false;
            this.alerta = { mensaje: "", visible: false, tipo: 0 };
            
        },
        refresh(tipo){
           
            this.$emit('refresh',[tipo])
        },
        
    }
};

</script>