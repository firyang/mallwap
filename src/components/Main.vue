<template>
    <div class="main">
        <router-view></router-view>
        <TabBar :currentNav="currentNav"></TabBar>
    </div>    
</template>
<script>
  import TabBar from './TabBar'

  export default {    
    components:{ TabBar },
    data(){
        return {
            currentNav: 1
        }        
    },
    beforeMount(){
        this.changeNavState(this.$route.path);
    },
    updated(){
        this.changeNavState(this.$route.path);
    },
    methods: {
       changeNavState(pathStr){
           let num = 1;
           if(pathStr == '/'){
               num = 1;
           }
           if(/\/pro/.test(pathStr)){
               num = 2;
           }
           if(pathStr == '/cart'){
               num = 3;
           }
           if(pathStr == '/member'){
               num = 4;
           }
           this.currentNav = num;
        } 
    }
  };
</script>
