<template>
    <div class="tabbar">
        <div :class="{'item-container':true,selected:currentNav==1}" @click="toPage(1)"><i class="iconfont icon-shouye"></i>首页</div>
        <div :class="{'item-container':true,selected:currentNav==2}" @click="toPage(2)"><i class="iconfont icon-chanpinzhongxin1"></i>产品中心</div>
        <div :class="{'item-container':true,selected:currentNav==3}" @click="toPage(3)"><i class="iconfont icon-gouwuche"></i>购物车</div>
        <div :class="{'item-container':true,selected:currentNav==4}" @click="toPage(4)"><i class="iconfont icon-huiyuan"></i>会员中心</div>
  </div>
</template>
<script>
  export default {
    props:{
        currentNav:Number,
        arr:Array,
        obj:Object,
        propE:{
            type:Object,
            default:function(){
                return { msg: 'hello'}
            }
        }
    },
    data(){
        return {
          
        }        
    },
    updated(){
    //    console.log(this.arr) 
    //    console.log(this.obj) 
    //    console.log(this.propE) 
    },
    methods: {
        toPage(num){
            let url = "";
            switch(num){
                case 1:
                    url = '/';
                    break;
                case 2:
                    url = '/pro';
                    break;
                case 3:
                    url = '/cart';
                    break;
                case 4:
                    url = '/member';
                    break;
            }
            this.$router.push(url);
        }
    }
  };
</script>
<style lang="less" scoped>
  @import '../assets/css/basic.less';
  .tabbar{
      width: 100%;
      height: @navh;      
      background: #ffffff;
      border-top: 1px solid #ddd;
      display: flex;
      justify-content: space-between;
      position: fixed;
      bottom: 0;
      left: 0;
      .item-container {
        width: 25%;
        text-align: center;
        font-size:  @tbfs;
        cursor: pointer;
        .iconfont {
            display: block;
            margin:6px 0 3px;
            font-size: @tbfs_icon;
        }        
      }
      .selected{
          color: @color_dark;
      }
  }
</style>
