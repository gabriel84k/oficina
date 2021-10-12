<template>
  <div class="text-center">
    
    <v-dialog
      v-model="dialog"
      hide-overlay
      persistent
      width="300"
    >
      <v-card
        color="primary"
        dark
      >
        <v-card-text>
          Por favor Aguarde un momento, procesando....
          <v-progress-linear
            indeterminate
            color="white"
            class="mb-0"
          ></v-progress-linear>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
  export default {
    props:['load'],
    data () {
      return {
        dialog: false,
      }
    },

    watch: {
      load (val) {
          this.dialog = val
        
      },
    },
  }
</script>