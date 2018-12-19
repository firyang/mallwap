<template>
  <div class="cart">
    <div class="head"><i class="iconfont icon-jiantou2" @click="handleBack"></i><h1>购物车</h1></div> 
    <div class="wraper">
        <img src="../assets/img/cart1.jpg">
        <p>登录后可同步购物车中商品</p>
        <router-link to="/login" tag="a">登录</router-link>
    </div>
  </div>    
</template>
<script>
  export default {
    data: () => ({
      
    }),
    created () {
    },
    methods: {
        handleBack(){
            this.$router.go(-1);
        },
    }
  }
</script>
<style lang="less" scoped>
  @import '../assets/css/basic.less';
.cart{
  height: 100vh;
  background: #f6f6f6;
  .head{
    width: 100%;
    height: @headh;
    text-align: center;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 9;
    background: #FFF;
    border-bottom: 1px solid #ddd;
    line-height: @headh;
    h1{
      font-size: @lg;
      margin: 0 auto;
    }
    i{
      font-size: @lg;
      position: absolute;
      left: 5%;
      cursor: pointer;
    }
  }
  .wraper{
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      align-items: center;
      padding-top: 40%;
      img{
          width: 120px;
          margin: 0 auto;
          opacity: .6;
      }
      p{
          padding-top: 1.2em;
          font-size: @md;
      }
      a{
          margin-top: 1.2em;
          font-size: @md;
          display: block;
          background: @color_normal;
          color:#fff;
          padding: 0.6em 1.6em;
          border-radius: 2em;
      }
  }
}
</style>
