<template>
  <div class="cart">
    <div class="head"><i class="iconfont icon-jiantou2" @click="handleBack"></i><h1>出错了</h1></div> 
    <div class="wraper">
        <i class="iconfont icon-icon-test2"></i>
        <p>您访问的页面不存在，或已删除！</p>
        <div><a href="javascript:;" @click="handleBack">返回上一页</a><router-link to="/" tag="a">返回首页</router-link></div>
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
      i{
          font-size: 10em;
          color:@color_normal;
      }
      p{
          padding: 1.2em 0;
          font-size: @md;
      }
      a{
          font-size: @md;
          display: inline-block;
          border: 1px solid #999;
          padding: 0.6em 1.6em;
          margin: 0 1em;
          border-radius: 2em;
      }
  }
}
</style>
