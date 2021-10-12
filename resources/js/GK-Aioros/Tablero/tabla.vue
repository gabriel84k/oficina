<template>
    <vuetable
        :ref="ref"
        :fields="fields"
        :api-mode="false"
        :data="object"
        pagination-path=""
        :css="css.table"
        :show-sort-icons="true"
        id="mytable"
        class="mb-5 bg-white rounded"
    >
       
    </vuetable>
</template>
<script>
export default {
    props:['fields','object','ref'],
    data() {
        return {
            css: CssVuetable,
           
        }
    },
    
}
</script>
