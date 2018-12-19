<template>
  <div class="cart">
    <div class="head"><h1>购物车<i class="iconfont icon-gouwuche1"></i></h1><a href="javascript:;" @click="toEdite">编辑</a></div>
    <ul class="hot">
      <li v-for="(tem,index) in list" :key="index">
        <i @click="checkItem(tem.iid,tem.is_checked)"
           :class="{iconfont:true,'icon-radio-copy':tem.is_checked==1,'icon-checkbox':tem.is_checked==0,checkbox:true}"></i>
        <router-link :to="'/details/'+tem.sku_id" tag="a">
          <img :src="require('../'+tem.sm)">
          <h2>{{tem.sku_name}}</h2>
          <p><em>￥{{tem.price}}</em></p>
        </router-link>
        <div class="count">
          <span @click="modifyCount(tem.iid,tem.count,false)">-</span><input type="text" :value="tem.count"><span @click="modifyCount(tem.iid,tem.count,true)">+</span>
        </div>
      </li>
    </ul>
    <div class="total">
       <i @click="checkAll(checkall)"
          :class="{iconfont:true,'icon-radio-copy':checkall,'icon-checkbox':!checkall,checkbox:true}"></i>
       <span>全选</span>
       <p :class="{none:!isShow}">合计: ￥{{totalAmount|addDecimal}}</p>
       <a href="javascript:;" @click="handleToCfOrder" :class="{topay:true,none:!isShow}">去结算({{totalCount}})</a>
       <a href="javascript:;" @click="delSelected" :class="{del:true,block:!isShow}">删除</a>
    </div>
  </div>    
</template>
<script>
  export default {
    data: () => ({
      isShow: true,
      list:null,
      checkall:false,
      totalAmount:0,
      totalCount:0
    }),
    beforeMount () {
      this.loadCart(this.uid);
    },
    computed:{
      uid: function(){
        return this.$store.getters.uid;
      }
    },
    filters: {
      addDecimal: function(price){
        return price.toFixed(2);
      }
    },
    methods: {
      loadCart(uid){
        axios.get(this.GLOBAL.localServer+'data/cart/cart.php',{params:{uid}})
        .then(res=>{
          this.list = res.data.data;
          // console.log(this.list);

          this.totalAmount = 0;
          this.totalCount = 0;

          for(var i=0,j=0;i<this.list.length;i++){
            var tem = this.list[i];
            if(tem.is_checked==1){
              this.totalAmount += parseInt(tem.price)*parseInt(tem.count);
              this.totalCount += parseInt(tem.count);
              j++;
            }
          }
          if(j==this.list.length){
            this.checkall = true;
          }else{
            this.checkall = false;
          }
        })
      },

      handleToCfOrder(){
        this.$router.push('/cforder');
      },

      toEdite:function(e){
        this.isShow = !this.isShow;
        if(this.isShow){
          e.target.innerHTML = '编辑';
        }else{
          e.target.innerHTML = '完成';
        }        
      },

      delSelected(){
        var uid = this.uid;
        axios.get(this.GLOBAL.localServer+'data/cart/delselect.php')
          .then(()=>{
            this.loadCart(uid);
          })
      },

      checkAll(is_checked){
        var uid = this.uid;
        is_checked==true?(is_checked=false):(is_checked=true);
        axios.get(this.GLOBAL.localServer+'data/cart/checkAll.php',{params:{uid,is_checked}})
          .then(()=>{
            this.loadCart(uid);
          })
      },

      checkItem(iid,is_checked){
        var uid = this.uid;
        is_checked==0?(is_checked=1):(is_checked=0);
        axios.get(this.GLOBAL.localServer+'data/cart/checkItem.php',{params:{uid,iid,is_checked}})
          .then(()=>{
            this.loadCart(uid);
          })
      },

      modifyCount(iid,count,flag){
        var uid = this.uid;       
        if(flag){
          count++;
        }else{
          if(count==1){
            return;
          }
          count--;
        }
        axios.get(this.GLOBAL.localServer+'data/cart/updateCount.php',{params:{uid,iid,count}})
          .then(()=>{
            this.loadCart(uid);
          })
      }
    }
  }
</script>
<style lang="less" scoped>
  @import '../assets/css/basic.less';
.cart{
  background: #fff;
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
    a{
      display: block;      
      position: absolute;      
      line-height: @headh;
      top:0;
      right:8%;
      color:#999;
      font-size: @md;
    }
  }
  .hot{
    margin-bottom: @navh+@headh;
    li::before{
      content: "";
      display: table;
    }
    li{
      width: 100%;
      position: relative;
      background: #fff;
      border-bottom: 1px solid #ddd;
      img{
        width:25%;
        position: relative;
        left: 11%;
        padding: 10px 0;
      }
      h2{
        width: 58%;
        font-size: @md;
        line-height: 1.2em;
        position: absolute;
        top:10%;
        left: 38%;
        padding-right: 1em;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
      }
      p{
        position: absolute;
        bottom:15%;
        left: 38%;
        font-size: @md;
        em{ margin-right: 6px;}
        s{ font-size: @sm;}
      }
      .count{
        position: absolute;
        right: 5%;
        bottom: 12%;
        input{
            margin: 0;
            padding: 0;
            width: 40px;
            text-align: center;
            outline: none;
            border: none;
            background: #f5f5f5;
            line-height: 26px;
            position: relative;               
            top: -1px;
            font-size: @md;
        }
        span{
            font-size: @lg;
            display: inline-block;
            width: 26px;
            line-height: 26px;
            text-align: center;
            cursor: pointer;
        }
      }
      .checkbox{
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        left: 4%;
        font-size: @lg;
        color: #ccc;
        cursor: pointer;
      }
      .icon-radio-copy{
        color:@color_normal;
      }     
    }
  }  
  .total{
    width: 100%;
    height: @headh;
    line-height: @headh;
    background: #f9f9f9;
    display: flex;
    justify-content: flex-start;
    position: fixed;
    left: 0;
    bottom: @navh;
    font-size: @md;
    i{
      padding-left: 4%;
      font-size: @lg;
      margin-right: 10px;
      cursor: pointer;
    }
    i.icon-radio-copy{      
      color: @color_normal;
    }
    p{
      margin-left: 18px;
      font-size: @lg*0.9;
    }
    a.topay{
      display: block;
      width: 30%;
      line-height: @headh;
      position: absolute;
      top: 0;
      right: 0;
      background:@color_normal;
      color: #fff;
      text-align: center;
      font-size: @md;
    }
    a.del{
      display: none;
      width: 100px;
      height: @headh*0.6;
      line-height: @headh*0.6;
      position: absolute;
      top: 50%;
      right:1em;
      transform: translateY(-50%);
      background:@color_normal;
      color: #fff;
      border-radius: 1em;
      text-align: center;
      font-size: @md;
    }
  }
}
</style>
