<template>
  <div class="cforder">
    <div class="head"><i class="iconfont icon-jiantou2" @click="handleBack"></i><h1>填写订单</h1></div>    
    <div class="address">
       <h2> {{receiver}} {{cellphone|hidePhone}}</h2>
       <p>{{address}}</p>
       <i class="iconfont icon-shouhuodizhi"></i>
    </div>
    <ul class="list">
      <li v-for="(tem,index) in list" :key="index">
        <a href="javascript:;">
          <img :src="require('../'+tem.sm)">
          <div class="title">
              <h2>{{tem.sku_name}}</h2>
              <p><em>￥{{tem.price}}</em><s>￥{{tem.price}}</s></p>
          </div>         
        </a>
        <div class="wraper-count">
            <p>购买数量</p>
            <div class="count">
            <span @click="modifyCount(tem.iid,tem.count,false)">-</span><input type="text" :value="tem.count"><span @click="modifyCount(tem.iid,tem.count,true)">+</span>
            </div>
        </div>        
      </li>
    </ul>    
    <div class="express">
       <div><p>支付方式</p><span>在线支付<i class="iconfont icon-bianji2"></i></span></div>
       <div><p>配送</p><span>TOYO商城合作快递</span></div>
       <div><p>发票</p><span>电子(商品明细-个人)<i class="iconfont icon-bianji2"></i></span></div>
    </div>
    <div class="total">
       <div><p>商品金额</p><span>￥{{totalAmount|addDecimal}}</span></div>
       <div><p>运费</p><span>+￥0.00</span></div>
    </div>
    <div class="btn">
       <p><small>￥</small>{{totalAmount|addDecimal}}</p>
       <a href="javascript:;">提交订单</a>
    </div>
  </div>    
</template>
<script>
  export default {
    data: () => ({
      list:[],
      totalAmount:0,
      sku_id:'',
      receiver:'',
      cellphone:'',
      address:''
    }),
    created () {
      var uid = this.uid;
      this.sku_id = this.$route.params.id;
      this.loadCart(uid);
    },
    computed:{
      uid: function(){
        return this.$store.state.uid;
      }
    },
    filters:{
      addDecimal: function(price){
        return price.toFixed(2);
      },
      hidePhone: function(cellphone){
        var arr = cellphone.trim().split('');
        arr.splice(3,4,'****');
        return arr.join('');
      }
    },
    methods: {
      loadCart(uid){
        this.list = [];
        this.addr = null;
        axios({
          method:'get',
          url:this.GLOBAL.localServer+'data/cart/cart.php',
          params:{uid}
        })
        .then(res=>{
          var list = res.data.data,
              addr = res.data.addr;

          this.totalAmount = 0;
          
          for(var i=0;i<list.length;i++){
            var tem = list[i];
            if(this.sku_id){
              if(tem.sku_id==this.sku_id){
                this.list.push(tem);
                this.totalAmount += parseInt(tem.price)*parseInt(tem.count);
                break;
              }
            }else{
              if(tem.is_checked==1){
                this.list.push(tem);
                this.totalAmount += parseInt(tem.price)*parseInt(tem.count);
              }
            }
          }
          for(var tem of addr){
            if(tem.is_default==1){
                this.receiver = tem.receiver;
                this.cellphone = tem.cellphone;
                this.address = tem.province+tem.city+tem.county+tem.address;
            }
          }
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
      },

      handleBack:function(){
          this.$router.go(-1);
      }
    }
  }
</script>
<style lang="less" scoped>
  @import '../assets/css/basic.less';
.cforder{
   background: #f9f9f9;
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
  .address{
    margin-top: @headh;
    padding: 1.2em 5%;
    background: #fff;
    margin-bottom: @pd;
    position: relative;
    h2{
      font-size: @lg;
    }
    p{
      padding-top: 5px;
      width: 80%;
    }
    i{
      position: absolute;
      right: 0;
      top:50%;
      transform: translateY(-50%);
      font-size: @lg*1.8;
      cursor: pointer;
      color: #aaa;
    }
  }
  .list{
    li::before{
      content: "";
      display: table;
    }
    li{
      width: 100%;
      position: relative;
      background: #fff;
      border-bottom: 1px solid #ddd;
      a{
        img{
          width:25%;
          padding: 0 @pd;
        }
        h2{
          font-size: @md;
          position: absolute;
          top:10%;
          left: 30%;
          padding-right: 1em;
          overflow: hidden;
          text-overflow: ellipsis;
          display: -webkit-box;
          -webkit-box-orient: vertical;
          -webkit-line-clamp: 3;
        }
        p{
          position: absolute;
          bottom:30%;
          left: 30%;
          font-size: @md;
          em{ margin-right: 6px;}
          s{ font-size: @sm;}
        }
      }
      .wraper-count{
          display: flex;
          justify-content: space-between;
          padding: @pd 5% 1em;
          font-size: @md;
          .count{
            position: absolute;
            right: 4%;
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
      }
    }
  }
  .express{
      background: #fff;
      line-height: 2.5em;
      padding: 1.2em 0;
      margin: @pd 0;
      div{
        width: 90%;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        font-size: @md;
        i{
            margin-left: 1.2em;
            font-size: 1.2em;
            color:#aaa;
            cursor: pointer;
            position: relative;
            top: 5px;
            cursor: pointer;
        }
      }
  }
  .total{      
      margin-bottom: @headh;
      background: #fafafa;
      line-height: 2em;
      padding: 1.2em 0;
      font-size: @md;
      div{
          width: 90%;
          margin: 0 auto;
          display: flex;
          justify-content: space-between;
      }
  }
  .btn{
    width: 100%;
    height: @headh;
    line-height: @headh;
    background: #f0f0f0;
    display: flex;
    justify-content: space-between;
    position: fixed;
    left: 0;
    bottom: 0;
    p{
      margin-left: 1em;
      font-size: @lg*1.2;
      color:@color_normal;
      small{
        font-size: @md;
      }      
    }
    a{
      display: block;
      width: 50%;
      line-height: @headh;
      background:@color_normal;
      color: #fff;
      text-align: center;
      font-size: @md;
    }
  }
}
</style>
