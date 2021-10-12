<template>
    <div>
        <br>
       
        <div class="row col-sm-12">
            <!-- Clientes -->
           
            <v-card v-if="(permisomenu.cliente == true)"  class="mx-2" max-width="344" outlined >
                <v-list-item  three-line >
                    
                    <v-list-item-content>
                        <div class="overline mb-4">
                            Administración
                        </div>
                        <v-list-item-title class="headline mb-1">
                            Clientes
                        </v-list-item-title>
                        <v-list-item-subtitle>Alta y Administración del Personal </v-list-item-subtitle>
                    </v-list-item-content>

                    <v-list-item-avatar tile size="80" color="grey" ></v-list-item-avatar>
                </v-list-item>
                <v-card-actions>
                   
                    <v-btn color="primary"  @click="openModal('cliente')" text> Ingresar </v-btn>
                    <v-spacer></v-spacer>
                </v-card-actions>
              
            </v-card>

            <!-- Productos -->
            <v-card v-if="(permisomenu.producto == true)" class="mx-2" max-width="344" outlined >
                <v-list-item three-line>
                <v-list-item-content>
                    <div class="overline mb-4">
                        Administración
                    </div>
                    <v-list-item-title class="headline mb-1">
                        Productos
                    </v-list-item-title>
                    <v-list-item-subtitle>Administración de productos</v-list-item-subtitle>
                </v-list-item-content>

                <v-list-item-avatar tile size="80" color="grey" ></v-list-item-avatar>
                </v-list-item>

                <v-card-actions>
                <v-btn outlined rounded text @click="openModal('producto')">
                    Ingresar
                </v-btn>
                </v-card-actions>
            </v-card>
            
            <!-- Estadisticas -->
            <v-card v-if="(permisomenu.reporte == true)" class="mx-2" max-width="344" outlined >
                <v-list-item three-line>
                <v-list-item-content>
                    <div class="overline mb-4">
                        Reportes y Estadisticas
                    </div>
                    <v-list-item-title class="headline mb-1">
                        Reportes
                    </v-list-item-title>
                    <v-list-item-subtitle>Reportes y Estadísticas</v-list-item-subtitle>
                </v-list-item-content>

                <v-list-item-avatar tile size="80" color="grey" ></v-list-item-avatar>
                </v-list-item>

                <v-card-actions>
                <v-btn outlined rounded text >
                    Ingresar
                </v-btn>
                </v-card-actions>
            </v-card>
        </div>
        <br>
        <div class="row col-sm-12">
            <!-- Usuarios -->
            <v-card v-if="(permisomenu.usuario == true)" class="mx-2" max-width="344" outlined >
                <v-list-item three-line>
                <v-list-item-content>
                    <div class="overline mb-4">
                        Administración
                    </div>
                    <v-list-item-title class="headline mb-1">
                        Usuarios
                    </v-list-item-title>
                    <v-list-item-subtitle>Adminitración de Usuarios del Sistema</v-list-item-subtitle>
                </v-list-item-content>

                <v-list-item-avatar tile size="80" color="grey" ></v-list-item-avatar>
                </v-list-item>
                <v-card-actions>
                   
                    <v-btn color="primary"  @click="openModal('usuario')" text> Ingresar </v-btn>
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>

            <!-- Configuracion del sistema -->
              <v-card v-if="(permisomenu.config == true)" class="mx-2" max-width="344" outlined >
                <v-list-item three-line>
                <v-list-item-content>
                    <div class="overline mb-4">
                        Configuracion del Sistema
                    </div>
                    <v-list-item-title class="headline mb-1">
                        Configuraciones
                    </v-list-item-title>
                    <v-list-item-subtitle>Adminitra los parametros del sistema</v-list-item-subtitle>
                </v-list-item-content>

                <v-list-item-avatar tile size="80" color="grey" ></v-list-item-avatar>
                </v-list-item>

                <v-card-actions>
                <v-btn outlined rounded text >
                    Ingresar
                </v-btn>
                </v-card-actions>
            </v-card>

        </div>
    </div>
</template>
<script>
  export default {
      props:['user','permiso'],
      data() {
          return {
               permisomenu:JSON.parse(this.permiso.menu),
          }
      },
      methods: {
          openModal(m){
              /* Devolver con emit el modal correspondiente para abrir*/
            
              this.$emit('openModal',m)
          }
      },
  }
</script>