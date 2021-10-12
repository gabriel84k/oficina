<template>

  <nav>
    <ul class='pagination' :key="this.totalpage">
        <div class="dropdown">
            Mostrar :
            <button class="btn dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 {{totalpage}}
            </button>
             x Pág.
            <div class="dropdown-menu" aria-labelledby="dropdownMenu2" >
                <button class="dropdown-item" type="button" @click.prevent="pageTotal(15)">15</button>
                <button class="dropdown-item" type="button" @click.prevent="pageTotal(30)">30</button>
                <button class="dropdown-item" type="button" @click.prevent="pageTotal(50)">50</button>
                <button class="dropdown-item" type="button" @click.prevent="pageTotal(100)">100</button>
            </div>
        </div>
    </ul>  
  </nav>
</template>

<script>


export default {
  
  name:'TotalPaginas',
  props:['data','vuepableid'],
  data(){
    return {
        totalpage:15,
        pagina:'',
    }
  },
  computed: {
      
  },
  mounted(){
     if (localStorage.getItem("totalpage")){
         this.totalpage=localStorage.getItem("totalpage")
     }else{
         this.totalpage=15
     }
     
  },
  methods: {
    pageTotal:function(total){
        localStorage.setItem("totalpage",total);
        this.totalpage=total
        
        this.$emit('totalpage',this.data.path+'?page='+this.data.current_page,this.totalpage)
      
    },
    localstorage(){
            if (localStorage.getItem("totalpage")){
                return localStorage.getItem("totalpage")
            }else{
                return 15
            }
    }
  
  },
};
</script>