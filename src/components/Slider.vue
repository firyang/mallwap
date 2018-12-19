<template>
    <!-- <div class="slider">
        <ul class="stage" :style="stageStyle">
            <li><img :src="require('../'+banners[banners.length-1].img)"></li>
            <li v-for="(tem,index) in banners" :key="index"><img :src="require('../'+tem.img)"></li>
            <li><img :src="require('../'+banners[0].img)"></li>
        </ul>
        <p class="direction">
          <i class="iconfont icon-jiantou2 left" @click="move(100,1)"></i>
          <i class="iconfont icon-jiantou right" @click="move(100,-1)"></i>
        </p>
        
    </div> -->
    <swiper class="swiper" :options="swiperOption" ref="mySwiper">
      <swiper-slide v-for="(tem,index) in banners" :key="index"><img :src="require('../'+tem.img)"></swiper-slide>
      <!-- <div class="swiper-button-prev" slot="button-prev"></div>
      <div class="swiper-button-next" slot="button-next"></div> -->
    </swiper>
</template>
<script>
  import 'swiper/dist/css/swiper.css'
  import { swiper, swiperSlide } from 'vue-awesome-swiper'

  export default {
    components:{
      swiper,
      swiperSlide
    },
    data: () => ({
      banners :[
        {img: 'assets/img/banner/banner01.jpg'},
        {img: 'assets/img/banner/banner03.jpg'},
        {img: 'assets/img/banner/banner02.jpg'},
        {img: 'assets/img/banner/banner04.jpg'}
      ],
      // distance:0,
      // count:0,
      swiperOption:{
        autoplay: {
          disableOnInteraction: false,
          delay:3000
        },
        loop:true,
        // prevButton: '.swiper-button-prev',
        // nextButton: '.swiper-button-next',

        slidesPerView:1
      }
    }),
    // created () {
    //   this.count = this.banners.length;
    // },
    // mounted (){
    //   let timer = setInterval(()=>{
    //     this.move(100,-1);
    //   },3000)
    // },
    // computed:{
    //   stageStyle: function(){
    //     return {transform:`translate3d(${this.distance}vw, 0, 0)`,width:`${100*(this.count+2)}vw`}
    //   }
    // },
    // methods: {
    //   move(offset,direction){
    //       var count = this.count;
    //       this.distance += offset * direction;
    //       if(this.distance<-offset*count){
    //         this.distance = -100;
    //       }

    //       if(this.distance>-100){
    //         this.distance = -offset*count;
    //       }
    //   }
    // }
  };
</script>
<style lang="less" scoped>
  @import '../assets/css/basic.less';
  .swiper{
    width: 100vw;
    img{
      width: 100%;
    }
  }
  // .slider{
  //   width: 100vw;
  //   overflow: hidden;
  //   position: relative;
  //   .stage{
  //     transition: all .5s linear;
  //     li{
  //       width: 100vw;
  //       float: left;
  //       img{
  //         width: 100%;
  //       }
  //     }
  //   }
    // .direction{
    //   i{
    //     width: 80px;
    //     height: 80px;
    //     line-height: 80px;
    //     text-align: center;
    //     border-radius: 50%;
    //     background: rgba(0, 0, 0, 0.3);
    //     font-size: 2em;
    //     color: #fff;
    //     position: absolute;
    //     top: 50%;
    //     z-index: 3;
    //     transform: translateY(-50%);
    //     cursor: pointer;
    //   }
    //   .left{
    //     left: 20px;
    //   }
    //   .right{
    //     right: 20px;
    //   }

    // }
  // }
</style>
