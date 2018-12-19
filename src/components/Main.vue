<template>
    <div class="main">
        <router-view></router-view>
        <TabBar :currentNav="currentNav" :arr="arr" :obj="obj"></TabBar>
    </div>    
</template>
<script>
  import TabBar from './TabBar'

  export default {    
    components:{ TabBar },
    data(){
        return {
            currentNav: 1,
            arr: [1,2,3],
            obj:{
                name:'jarrey',
                age:'23'
            }
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
