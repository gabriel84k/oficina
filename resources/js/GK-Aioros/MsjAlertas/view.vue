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
        <div  v-if="msj.tipo==2"
          style="position: fixed; top: 0; left: 36%;"
        >
         
            <v-alert v-if="msj.visible"
                v-model="msj.visible"
                border="left"
                dismissible
                elevation="17"
                prominent
                :type="msj.color"
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
       m:this.msj,
       
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

