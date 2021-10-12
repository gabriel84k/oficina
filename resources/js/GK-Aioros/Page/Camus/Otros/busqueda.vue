<template >
  <div class="d-flex flex-wrap justify-space-between sauce_width_auto">
      <v-icon color="blue"  > mdi-feature-search-outline </v-icon>
      &nbsp
      
      <v-text-field
        label="Escriba aquí para buscar"
        v-model="obj.msj"
        @change="buscar"
      ></v-text-field>
      <div v-if="fecha">
        <input type="date" name="" id="" v-model="obj.fdesde" @change="buscar">
        <input type="date" name="" id="" v-model="obj.fhasta" @change="buscar">
      </div>
  </div>
</template>
                
<script>
export default {
  props:['param','id','fecha'],
  data() {
    return {
      on:'',
      obj:{
        msj: this.param.msj,
        fdesde:this.param.fdesde,
        fhasta:this.param.fhasta,
        _id: this.id,
      },
      page: this.param.page
    };
  },
  methods: {
    
    buscar(v) {
      try {
        
        axios
            .get(this.page + "/?msj="+this.obj.msj+"&id="+this.id+"&fdesde="+this.obj.fdesde+"&fhasta="+this.obj.fhasta )
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