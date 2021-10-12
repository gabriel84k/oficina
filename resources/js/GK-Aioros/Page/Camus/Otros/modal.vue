<template>
    <div class="text-center">
        <div v-if="modal != 0">
            
            <cliente v-if="modal == 'cliente'"
                    :show="tipoModal.show" 
                    @close='closeModal'
                    :permiso='p.cliente'
                    >
            </cliente>
            <producto v-if="modal == 'producto'"
                    :show="tipoModal.show" 
                    @close='closeModal'
                    :permiso='p.producto'>
            </producto>
            <usuario v-if="modal == 'usuario'"
                    :show="tipoModal.show" 
                    @close='closeModal'
                    :user="user"
                    :permiso='p.usuario'>
            </usuario>
            <reporte v-if="modal == 'reporte'"
                    :show="tipoModal.show" 
                    @close='closeModal'
                    :user="user"
                    :permiso='p.usuario'>
            </reporte>
            <config v-if="modal == 'config'"
                    :show="tipoModal.show" 
                    @close='closeModal'
                    :user="user"
                    :permiso='p.config'>
            </config>
           
        </div>
        
  </div>
</template>
<script>
import cliente from '../Cliente/view'
import producto from '../Producto/view'
import usuario from '../Usuario/view'
import reporte from '../reporte/view'
import config from '../Configuración/view'
export default {
    props:['modal','user','permiso'],
    data() {
        return {
             p:{cliente:JSON.parse(this.permiso.cliente),
                usuario:JSON.parse(this.permiso.usuario),
                producto:JSON.parse(this.permiso.producto)},
             tipoModal : {'tipo':this.modal, 'show':true},
             watchModal : this.modal,
        }
    },
    components:{
      cliente,
      producto,
      usuario,
      reporte,
      config
    },
    watch: {
      modal (val) {
           
          this.tipoModal.show = true
      },
    },
    mounted() {
        
    },
    methods: {
      closeModal:function(){
          this.$emit('close',false)
      },
    },
}
</script>