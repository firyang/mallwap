<template>
    <div class="member">
      <div class="head"><h1>会员中心<i class="iconfont icon-huiyuan"></i></h1></div>
      <p class="avatar"><img src="../assets/img/avatars.png"></p>
      <div class="order">
        <div class="top"><h2>我的订单</h2><a href="javascript:;">查看全部订单</a></div>
        <ul>
          <li><a href="javascript:;"><i class="iconfont icon-daifukuan"></i>待付款</a></li>
          <li><a href="javascript:;"><i class="iconfont icon-tubiaolunkuo-"></i>待收货</a></li>
          <li><a href="javascript:;"><i class="iconfont icon-daipingjia"></i>待评价</a></li>
          <li><a href="javascript:;"><i class="iconfont icon-tuihuo"></i>退换/售后</a></li>
        </ul>
      </div>
      <div class="custom"><h2>在线客服</h2><i class="iconfont icon-kefu1"></i></div>
      <div class="logout">
        <a href="javascript:;" @click="logout">退出登录</a>
      </div>
    </div>
</template>
<script>
  export default {
    data: () => ({
      isShow: false
    }),
    created () {
      
    },
    methods: {
      logout(){
        this.$store.dispatch('Logout')
          .then(res=>{
            this.$router.push('/');
          })
          .catch(error=>{
            console.log(error)
          })
      }
    }
  };
</script>
<style lang="less" scoped>
  @import '../assets/css/basic.less';
.member{
  h2{
    font-weight: bold;
  }
  .head{
    height: @headh;
    text-align: center;
    position: relative;
    border-bottom: 1px solid #ddd;
    h1{
      font-size: @lg;
      line-height: @headh;
      margin: 0 auto;
      i{
        margin-left: 16px;
        font-size: @lg;
      }
    }
  }
  .avatar{
    padding: @pd 5%;
    img{
      width: 80px;
    }
      
  }
  .order{
    padding: 0 5%;
    border:1px solid #ddd;
    .top{
      display: flex;
      justify-content: space-between;
      padding: 1.5em 0 1em;
      h2{
        font-size: @md;
      }
      a{
        color:#999;
        display: block;
        font-size: @sm;
        padding-top: 0px;
        position: relative;
        top:2px;
      }
    }
    ul{
      border-top: 1px solid #ddd;
      display: flex;
      justify-content: space-between;
      li{
          padding: 2em 0;
          line-height: 2.6em;
        a{
          text-align: center;
          font-size: @md;
          i{
            display: block;
            font-size: 2.2em;          
          }
        }
      }
    }
  }
  .custom{
    margin-bottom: @headh+@navh;
    padding: 0 5%;
    line-height: 4em;
    display: flex;
    justify-content: space-between;
    h2{
      font-size: @md;
    }
    i{
      font-size: 1.6em;
    }
  }
  .logout{
    width: 100%;
    a{
      display: block;
      width: 100%;
      height: @headh;
      line-height: @headh;
      font-size: @md;
      text-align: center;
      background: @color_light;
      color: #fff;
      position: fixed;
      left: 0;
      bottom: @navh;
    }
  }
}
</style>

