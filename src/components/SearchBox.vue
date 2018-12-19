<template>
  <div class="schbox">
    <input type="text" placeholder="关键词搜索" v-model="kw"/>
    <i class="iconfont icon-fangdajing" @click="handleSearch"></i>
  </div>
</template>
<script>
  export default {
    data(){
        return {
            kw:'',
            currentUrl:''
        }        
    },
    created(){
      this.currentUrl = location.href;
    },
    methods: {
       handleSearch(){
         this.$bus.$emit('myEvent',this.kw);
         if(/pro/.test(this.currentUrl)){
           return;
         }else{
           this.$router.push('/pro');
         }
       } 
    }
  };
</script>
<style lang="less" scoped>
  @import '../assets/css/basic.less';
  .schbox{
      width: 72%;
      position: fixed;
      top:12px;
      left: 50%;
      transform: translateX(-50%);
      border: 1px solid #ddd;
      border-radius: 70px; 
      z-index: 9;
      background:#fff;
      opacity: .9;    
      input{
          border: none;
          outline: none;
          padding: 8px 8% 8px 5%;
          width: 87%;
          background: transparent;
          font-size: @md;
          color:#555;
      }
      .iconfont{
          position: absolute;
          top:50%;
          right:18px;
          transform: translateY(-50%);
          font-size: @lg;
          border-radius: 70px;
          cursor: pointer;
      } 
  }
</style>
