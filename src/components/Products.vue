<template>
  <div class="product">
    <div class="head"><h1>产品中心<i class="iconfont icon-chanpinzhongxin1"></i></h1></div>
    <SearchBox></SearchBox>
    <div class="title">
      <span :class="{selected:num==0}" @click="reOrder(0)">综合<i :class="{iconfont:true, 'icon-jiantou_xiangshang_o':this.orderMethods[0]=='ASC', 'icon-jiantou_xiangxia_o':this.orderMethods[0]=='DESC'}" v-if="orderArrow[0]"></i></span>
      <span>人气</span>
      <span  :class="{selected:num==1}" @click="reOrder(1)">销量<i :class="{iconfont:true, 'icon-jiantou_xiangshang_o':this.orderMethods[1]=='ASC', 'icon-jiantou_xiangxia_o':this.orderMethods[1]=='DESC'}" v-if="orderArrow[1]"></i></span>
      <span :class="{selected:num==2}" @click="reOrder(2)">价格<i :class="{iconfont:true, 'icon-jiantou_xiangshang_o':this.orderMethods[2]=='ASC', 'icon-jiantou_xiangxia_o':this.orderMethods[2]=='DESC'}" v-if="orderArrow[2]"></i></span>
      <i :class="{iconfont:true, 'icon-liebiao':!isList, 'icon-chanpinzhongxin':isList,btn:true}" @click="toggleClass"></i></div>
    <ul :class="{recommend:!isList, hot:isList}">
      <li v-for="(tem,index) in list" :key="index">
        <a href="javascript:;" @click.prevent="toDetails(tem.sku_id)">
          <img :src="require('../'+tem.lg)">
          <h2>{{tem.sku_sub_name}}</h2>
          <p><em>￥{{tem.price}}</em><s>￥{{tem.price}}</s></p>
        </a>
        <!-- <i class="iconfont icon-gouwuche"></i> -->
      </li>
    </ul>
  </div>
</template>
<script>
  import SearchBox from './SearchBox'

  export default {
    components:{
      SearchBox
    },
    data: () => ({
      isList:false,
      cid:null,
      kw:'',
      list:[],
      orderKW:'',
      num:0,
      orderArrow: [false,false,false],
      orderMethods:['ASC','ASC','ASC'],
    }),
    created () {
      this.cid = this.$route.params.cid;
      
      this.$bus.on('myEvent',msg=>{
        this.kw = msg;
      })
    },
    watch: {
      cid: function(){
        var cid = this.cid;
        this.loadProList({cid});
      },
      kw: function(){
        var kw = this.kw;
        this.loadProList({kw});
      }
    },
    methods: {
      loadProList({cid,kw,orderKW,orderMethods}){
        axios.get(this.GLOBAL.localServer+'data/product/listapp.php',{params:{cid,kw,orderKW,orderMethods}})
        .then(res=>{
          // console.log(res.data);
          this.list = res.data.data;
        })
      },
      toDetails:function(id){
        this.$router.push('/details/'+id);
      },
      toggleClass:function(){
        this.isList = !this.isList;
      },
      reOrder(n){
        this.num = n;
        switch(n){
          case 1:
          this.orderKW = 'sale';
          break;
          case 2:
          this.orderKW = 'price';
          break;
          default:
          this.orderKW = 'sku_id';
        }
        
        for(var i=0;i<this.orderMethods.length;i++){
          if(i!=n){
            this.orderMethods[i] = 'ASC';
          }
        }
        this.orderMethods[n]=='ASC'?(this.orderMethods[n] = 'DESC'):(this.orderMethods[n] = 'ASC');

        this.orderArrow = [false,false,false];  
        this.orderArrow[n]=true;

        var cid = this.cid,
            kw = this.kw,
            orderKW = this.orderKW,
            orderMethods = this.orderMethods[this.num];
        this.loadProList({cid,kw,orderKW,orderMethods});
      }
    }
  };
</script>
<style lang="less" scoped>
  @import '../assets/css/basic.less';
.product{
  .schbox{
    position: relative;
  }
  .head{
    height:  @headh;
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
    a{
      display: block;      
      position: absolute;      
      line-height: @headh;
      top:0;
      right:8%;
      color:#999;
    }
  }
  .title{
    height: @titleh;
    line-height:  @titleh;
    text-align: center;
    font-size: @md;
    background: #fff;
    margin: 30px 0 14px;
    display: flex;
    justify-content: flex-start;
    text-align: center;
    position: relative;
    span{
      display: inline-block;
      width: 20%;
      cursor: pointer;
      i{
        margin-left: 3px;
        font-size: @md;
      }
    }
    span.selected{
      color:@color_normal;
    }
    i.btn{
      position: absolute;
      right:5%;
      font-size: @lg*1.1;
      cursor: pointer;
    }
  }
   .recommend{
    margin-bottom: @navh;
    padding: 0 8px;
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    margin-left: -2%;
    li{
      width: 48%;
      background: #fff;
      text-align: center;
      margin-left: 2%;
      margin-bottom: 2%;
      padding-bottom: @pd;
      position: relative;
      box-shadow: 0 0 3px #aaa;
      img{
        width: 80%;
      }
      h2{
        font-size: @md;
        padding: 0 1em;
        text-align: left;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
      }
      p{
        font-size: @md;
        text-align: left;
        padding: @pd 1em;
        em{ margin-right: 8px;}
        s{ font-size: @sm;}
      }
      i{
        position: absolute;
        bottom: 20px;
        right: 8%;
        background: @color_normal;
        color:#fff;
        font-size: 26px;
        width: 60px;
        height: 60px;
        line-height: 60px;
        border-radius: 50%;
        cursor: pointer;
      }
    }
  }
  .hot{
    margin-bottom: @navh;
    li::before{
      content: "";
      display: table;
    }
    li{
      width: 97%;
      padding-left: 3%;
      position: relative;
      background: #fff;
      border-bottom: 1px solid #ddd;
      img{
        width:36%;
      }
      h2{
        font-size: @md;
        padding-right: 1em;
        position: absolute;
        top:20%;
        left: 42%;
        overflow: hidden;
        text-align: left;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 3;
      }
      p{
        font-size: @md;
        position: absolute;
        bottom:20%;
        left: 42%;
        em{ margin-right: 8px;}
        s{ font-size: @sm;}
      }
      i{
        position: absolute;
        bottom: 60px;
        right: 8%;
        background: @color_normal;
        color:#fff;
        font-size: 26px;
        width: 60px;
        height: 60px;
        line-height: 60px;
        border-radius: 50%;
        text-align: center;
        cursor: pointer;
      }
    }
  }
}
</style>

