
<template>
    <div>
        <br />
        <div ><h4 class="sau-centrado">Administración</h4></div>
        <div class="row col-sm-12">
            <!-- Clientes -->

            <div v-if="(permisomenu.cliente == true)" class="sau-card-dashboard sau-border-card sau-border-card sau-border-card-producto">
                <div class="sau-card-dashboard__section">
                    <div class="sau-card-dashboard__section__title h2">
                        Clientes

                    </div>
                    <div class="sau-card-dashboard__section__icons">
                    <div class="sau-card-dashboard__section__icons__container sau-centrado">
                        <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
                <div class="sau-card-dashboard__section__description">
                    Alta y Administración del Personal

                </div>
                <div @click="openModal('cliente')" text class="sau-buttons">
                    Ingresar

                </div>
            </div>

                        <!-- Productos-->

            <div v-if="(permisomenu.producto == true)" class="sau-card-dashboard sau-border-card sau-border-card sau-border-card-producto">
                <div class="sau-card-dashboard__section">
                    <div class="sau-card-dashboard__section__title h2 sau-centrado">
                        Productos

                    </div>
                    <div class="sau-card-dashboard__section__icons">
                    <div class="sau-card-dashboard__section__icons__container sau-centrado">
                        <i class="fas fa-toolbox"></i>
                        </div>
                    </div>
                </div>
                <div class="sau-card-dashboard__section__description">
                    Administración de productos

                </div>
                <div @click="openModal('producto')" text class="sau-buttons">
                    Ingresar
                    
                </div>
            </div>

            <!-- Estadisticas-->

            <div v-if="(permisomenu.reporte == true)" class="sau-card-dashboard sau-border-card sau-border-card sau-border-card-producto">
                <div class="sau-card-dashboard__section">
                    <div class="sau-card-dashboard__section__title h2 sau-centrado">
                        Reportes

                    </div>
                    <div class="sau-card-dashboard__section__icons">
                    <div class="sau-card-dashboard__section__icons__container sau-centrado">
                        <i class="fas fa-info-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="sau-card-dashboard__section__description">
                    Reportes y Estadísticas

                </div>
                <div @click="openModal('reporte')" text class="sau-buttons">
                    Ingresar
                    
                </div>
            </div>
        </div>

        <br />

        <div><h4 class="sau-centrado">Configuración del Sistema</h4></div>
        <div class="row col-sm-12">
        
            <!-- Usuarios-->

            <div v-if="(permisomenu.usuario == true)" class="sau-card-dashboard__2 sau-border-card sau-border-card sau-border-card-producto">
                <div class="sau-card-dashboard__section">
                    <div class="sau-card-dashboard__section__title h2 sau-centrado">
                        Usuarios

                    </div>
                    <div class="sau-card-dashboard__section__icons">
                    <div class="sau-card-dashboard__section__icons__container sau-centrado">
                        <i class="fas fa-user"></i>
                        </div>
                    </div>
                </div>
                <div class="sau-card-dashboard__section__description">
                    Adminitración de Usuarios del Sistema

                </div>
                <div @click="openModal('usuario')" text class="sau-buttons">
                    Ingresar
                    
                </div>
            </div>

            <!-- Configuracion del sistema-->

            <div v-if="(permisomenu.config == true)" class="sau-card-dashboard__2 sau-border-card sau-border-card sau-border-card-producto">
                <div class="sau-card-dashboard__section">
                    <div class="sau-card-dashboard__section__title h2 sau-centrado">
                        Configuracion
                    </div>
                    <div class="sau-card-dashboard__section__icons">
                    <div class="sau-card-dashboard__section__icons__container sau-centrado">
                        <i class="fas fa-tools"></i>
                        </div>
                    </div>
                </div>
                <div class="sau-card-dashboard__section__description ">
                    Administra los parametros del sistema

                </div>
                <div @click="openModal('config')" text class="sau-buttons">
                    Ingresar
                    
                </div>
            </div>

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