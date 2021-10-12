<template>
<div class="card">
        <div class="card-header">
            <b>Calendario</b>
            <button type="button" class="close" aria-label="Close" @click="close('index')">
                <span aria-hidden="true">&times;</span>
            </button>
            
        </div>
        
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3">
                     <h3 class="">Calendario</h3>
                </div>
            </div>
            
                <!--<p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>-->
                <hr class="">
                <div class="row">
                    <div class="col-lg-12">
                        <calendario ></calendario>
                    </div>
                </div>
        </div>
    </div>
</template>
<script>
import calendario from './Calendario'

export default {
 
  data: function() {
    return {
        initial_events: [],
        todayStr : new Date().toISOString().replace(/T.*$/, ''),
    }
  },
 
  mounted() {
    
  },
  components:{
      calendario
  },
  methods: {
   
    close(value){
        this.$emit('show',value)
    },
  }
}

</script>
<style lang='scss'>

</style>