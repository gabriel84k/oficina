<template>
<div>
    <div cols="12" md="6">
        <Cuenta v-if="true" :tipo="'Modificando'" :user="user"   ></Cuenta>
    </div>
    <div cols="12" md="6">
        <a class="dropdown-item" href="#" @click="mostrar('cuenta')">
            Mi Perfil
        </a>
    </div>
    <a class="dropdown-item" href="#" @click="mostrar('conf')">
        Configuración
    </a>
    <a class="dropdown-item" href="#" @click="mostrar('consulta')">
        Consultas
    </a>
</div>
    
</template>
<script>
import Cuenta from './nuevo';
export default {
    props:['user'],
    data() {
        return {
            dialog:false,
           
        }
    },
    computed:{
        permiso(){
            return this.$store.state.a.permiso
        },
        
    },
    components:{
         Cuenta,
    },
    methods: {
        mostrar(m){
            switch (m) {
                case 'conf':
                    
                    this.$store.commit('showComponent', {visible:true, title: 'Configuraciones', icon: '', modal:'Configuracion',permiso: this.permiso })
                    break;

                default:
                    break;
            }
        }
    },
}
</script>