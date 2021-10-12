<template>

  <div style="width:100%">
    
        <div v-if="msj.tipo==1">
           
            <v-alert v-if="msj.visible"
              text 
              dense
              color="teal"
              icon="mdi-clock-fast"
              border="left"
            >
           
              {{msj.mensaje}}
            </v-alert>
            
        </div>
        <div v-else>
            <v-alert v-if="msj.visible"
              text 
              dense
              type="error"
              icon="mdi-cloud-alert"
              border="left"
              color="red"
            >
            error
              {{msj.mensaje}}
            </v-alert>
        </div>
    </div>
</template>

<script>
  
  export default {
    props :['msj'], 
    data() {
      return {
       m:this.msj
      }
    },
    watch:{
      msj(v) {
          this.m=v 
      }
    },
    mounted() {
      this.m=this.msj
    },
  }
  
</script>

