<template>
  <div class="index">
    <SearchBox></SearchBox>
    <Slider></Slider>
    <ul class="category">
      <li v-for="(tem,index) in category" :key="index">
        <router-link :to="'pro/'+tem.cid">
          <img :src="require('../'+tem.sm)">
          <p>{{tem.category_name}}</p>
        </router-link>
      </li>
    </ul>
    <div class="title">推荐产品</div>
    <ul class="recommend">
      <li v-for="(tem,index) in recommend" :key="index">
        <router-link :to="'details/'+tem.sku_id">
          <img :src="require('../'+tem.lg)">
          <h2>{{tem.sku_sub_name}}</h2>
          <p><em>￥{{tem.price}}</em><s>￥{{tem.price}}</s></p>
        </router-link>
          <!-- <i class="iconfont icon-gouwuche"></i> -->
      </li>
    </ul>
    <div class="title">热销产品</div>
    <ul class="hot">
      <li v-for="(tem,index) in hot" :key="index">
        <router-link :to="'details/'+tem.sku_id">
          <img :src="require('../'+tem.lg)">
          <h2>{{tem.sku_sub_name}}</h2>
          <p><em>￥{{tem.price}}</em><s>￥{{tem.price}}</s></p>
        </router-link>
          <!-- <i class="iconfont icon-gouwuche"></i> -->
      </li>
    </ul>    
  </div>    
</template>

<script>
  import SearchBox from './SearchBox'
  import Slider from './Slider'

  export default {
    components: {
      SearchBox,
      Slider
      // TabBar: require('./TabBar').default
    },
    data: () => ({
      category: [],
      recommend:[],
      hot:[]
    }),
    created(){
      axios.get(this.GLOBAL.localServer+'data/product/index.php')
      .then(res=>{
        // console.log(res.data);
        var data = res.data;
        var category = [],
            recommend = [];
        for(let item of data.category){
          if(['3','12','14','9'].indexOf(item.cid)!=-1){
            category.push(item);
          }
        }
        this.category = category;

        for(let item of data.recommend){
          if(['1','4','9','12'].indexOf(item.sku_id)!=-1){
            recommend.push(item);
          }
        }
        this.recommend = recommend;

        this.hot = data.hot;
      })
    },
    methods: {
      
    }
  };
</script>

<style lang="less" scoped>
  @import '../assets/css/basic.less';
.index{
  .category{
    width: 100%;
    overflow: hidden;
    display: flex;
    justify-content: space-between;
    flex-wrap: nowrap;
    background: #fff;
    padding-bottom: @pd;
    li{
      width: 25%;
      text-align: center;
      a{
        p{
          font-size: @md;
        }
      }
      img{
        width:80%;
      }
    }
  }
  .title{
    padding: @pd;
    text-align: center;
    font-size: @lg;
    background: #f6f6f6;
    margin: 8px 0;
  }
  .recommend{
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
