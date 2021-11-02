<template>
    <Red></Red>
</template>
<script>
import Red from './Red.vue'
export default {
    props: ['show','tipo','permiso','user','empresa'],
    data() {
        return {
            
        }
    },
    components:{
        Red
    }
}
</script>