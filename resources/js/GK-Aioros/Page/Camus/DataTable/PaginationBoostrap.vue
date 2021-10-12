<template>

  <nav>
    
    <ul class='pagination'>
      <li :class="['page-item', {'disabled': false}]" data-li='ini'>
        <a class="page-link" @click.prevent="loadPage('ini')">
          <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-skip-backward" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M.5 3.5A.5.5 0 0 1 1 4v3.248l6.267-3.636c.52-.302 1.233.043 1.233.696v2.94l6.267-3.636c.52-.302 1.233.043 1.233.696v7.384c0 .653-.713.998-1.233.696L8.5 8.752v2.94c0 .653-.713.998-1.233.696L1 8.752V12a.5.5 0 0 1-1 0V4a.5.5 0 0 1 .5-.5zm7 1.133L1.696 8 7.5 11.367V4.633zm7.5 0L9.196 8 15 11.367V4.633z"/>
          </svg>
        </a>
      </li> 
      <li :class="['page-item', {'disabled': false}]" data-li='prev'>
        <a class="page-link" @click.prevent="loadPage('prev')">
          <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-caret-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M10 12.796L4.519 8 10 3.204v9.592zm-.659.753l-5.48-4.796a1 1 0 0 1 0-1.506l5.48-4.796A1 1 0 0 1 11 3.204v9.592a1 1 0 0 1-1.659.753z"/>
          </svg>
        </a>
      </li> 
      
      <template>
        
        <li v-for="n in totalPage" data-li='numeric' :key="n" :class="['page-item',{'ocultar':isCurrentPage(n)},{'active':isprimero(n)}]">
          <a class="page-link" @click.prevent="loadPage(n)" v-html="n"></a>
        </li>
      
      </template>
      
     
      <li :class="['page-item', {'disabled': false}]" data-li='next'>
        <a class="page-link" href="" @click.prevent="loadPage('next')">
          <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-caret-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M6 12.796L11.481 8 6 3.204v9.592zm.659.753l5.48-4.796a1 1 0 0 0 0-1.506L6.66 2.451C6.011 1.885 5 2.345 5 3.204v9.592a1 1 0 0 0 1.659.753z"/>
          </svg>
        </a>
      </li>
      <li :class="['page-item', {'disabled': false}]" data-li='fin'>
        <a class="page-link" href="" @click.prevent="loadPage('fin')">
          <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-skip-forward" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M15.5 3.5a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-1 0V8.752l-6.267 3.636c-.52.302-1.233-.043-1.233-.696v-2.94l-6.267 3.636C.713 12.69 0 12.345 0 11.692V4.308c0-.653.713-.998 1.233-.696L7.5 7.248v-2.94c0-.653.713-.998 1.233-.696L15 7.248V4a.5.5 0 0 1 .5-.5zM1 4.633v6.734L6.804 8 1 4.633zm7.5 0v6.734L14.304 8 8.5 4.633z"/>
          </svg>
        </a>
      </li>
    </ul>  
  </nav>
</template>

<script>
//import VuetablePaginationMixin from "vuetable-2/src/components/VuetablePaginationMixin";
const $ = require('jquery') //usamos jquery
window.$ = $;

export default {
  
  name:'pagination',
  props:['data','vuepableid'],
  data(){
    return {
        totalpage:[],
        pagina:'',
       
    }
  },
  computed: {
      totalPage(){
           return this.data === null
                  ? 0
                  : this.data.last_page
      }
  },
  mounted(){
      
  },
  methods: {
    loadPage:function(page){
      switch (page) {
        case 'ini':
              this.$emit('click',this.data.first_page_url,this.vuepableid)
              break;
        case 'next':
              this.$emit('click',this.data.next_page_url,this.vuepableid)
              break;
         case 'prev':
              this.$emit('click', this.data.prev_page_url,this.vuepableid)
              break;
        case 'fin':
              this.$emit('click', this.data.last_page_url,this.vuepableid)
              break;
        default:
              this.$emit('click',this.data.path+'?page='+page,this.vuepableid)
              break;
      }
      
    },
    isCurrentPage (page) {
      if (page>10){return true}
    },
    isprimero(page){
      if(page ==1){return true}
    }
   
  },
};

$(document).ready(function(){
  var v_min=2;
  var v_max=10;

  $(document).on('click','.page-item',function(){
    
    switch ($(this).data('li')) {
      case 'numeric':
        $('.page-item').removeClass('active')
        $(this).addClass('active')
        break;
      case 'prev':
        $.each($(this).parent().find('li'),function(i,v){
            if ($(v).hasClass('active')){
             
                if ($(v).prev().data('li')=='numeric'){  
                    $(v).prev().addClass('active')
                    $(v).removeClass('active')
                    if ($(v).prev().hasClass('ocultar')){
                        $(v).prev().removeClass('ocultar')
                        $(this).parent().find('li').eq(v_max+1).addClass('ocultar')
                        
                        
                        v_min--
                        v_max--
                       
                    }
                    return false
                }else{
                    return false
                }
            }
          });
        
          break;
      case 'next':
        $.each($(this).parent().find('li'),function(i,v){
           
            if ($(v).next().next().data('li')=='numeric' || $(v).next().next().data('li')=='next'){ 
              
              if ($(v).hasClass('active')){
                 
                  $(v).removeClass('active')
                  $(v).next().addClass('active')
                  
                  if ($(v).next().hasClass('ocultar')){
                      $(v).next().removeClass('ocultar')
                     
                      $(this).parent().find('li').eq(v_min-1).addClass('ocultar')
                      
                      v_min++;
                      v_max++;
                      
                      
                  }
                  $(v).removeClass('active')
                  return false
              }
              
            }else{
              return false
            }
        });
        break;
      case 'ini':
          $(this).parent().find('li:gt(11)').addClass('ocultar')
          $(this).parent().find('li:lt(12)').removeClass('ocultar')
          $(this).parent().find('li:gt(-3)').removeClass('ocultar')
          $(this).parent().find('li').removeClass('active')
          $(this).parent().find('li').eq(2).addClass('active')
          v_min=2
          v_max=10
        break;
      case 'fin':
         
          $(this).parent().find('li:lt(12)').addClass('ocultar')
          $(this).parent().find('li:gt(-13)').removeClass('ocultar')
          $(this).parent().find('li:lt(2)').removeClass('ocultar')
          $(this).parent().find('li').removeClass('active')
          $(this).parent().find('li:eq(-3)').addClass('active')
          
          v_max=$('.page-item').parent().find('li').length-4
          v_min=v_max-9
          break;
    }
  });
});
</script>
