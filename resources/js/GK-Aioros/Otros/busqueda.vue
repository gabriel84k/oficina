<template >
  <div class="row col-6" >
      <v-icon color="blue"  > mdi-feature-search-outline </v-icon>
      &nbsp
      
      <v-text-field
        
        label="Escriba aquí para buscar"
        v-model="obj.msj"
        @change="buscar"
      ></v-text-field>
      
  </div>
</template>
                
<script>
export default {
  props:['param','id'],
  data() {
    return {
      on:'',
      obj:{
        msj: this.param.msj,
        _id: this.id,
      },
      page: this.param.page
    };
  },
  methods: {
    
    buscar(v) {
      try {
        
        axios
            .get(this.page + "/?msj="+this.obj.msj+"&id="+this.id )
            .then((response) => {
              if (response.data.status == 0) {
                this.$emit('objeto',response.data.data)
                this.$emit('msj',this.obj.msj)
              } else {
                console.log("error");
              }
            })
            .catch((error) => {
              console.log(error);
            })
            .finally(() => console.log(""));
      } catch (error) {
        console.log(error);
      }
    },
  },
};
</script>