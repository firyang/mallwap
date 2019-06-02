<template>
  <div class="cforder">
    <div class="head">
      <i class="iconfont icon-jiantou2" @click="handleBack"/>
      <h1>商品详情</h1>
    </div>
    <div ref="photostage" class="photo">
      <ul>
        <li v-for="(tem,index) in pic" :key="index">
          <img :src="require('../'+tem.lg)">
        </li>
        <li>
          <img src="../assets/img/product/lg/img_21_800_800.png">
        </li>
        <li>
          <img src="../assets/img/product/lg/CS-130.png">
        </li>
      </ul>
      <span>
        1
        <small>/6</small>
      </span>
    </div>
    <div class="desc">
      <p>{{ pro.sku_name }}</p>
      <p>
        <small>￥</small>
        {{ pro.price }}
      </p>
    </div>
    <div class="spec">
      <div>
        <p>已选</p>
        <p class="value">{{ selected }}件</p>
      </div>
      <i class="iconfont icon-iconfontgengduo" @click="showPannel"/>
    </div>
    <div class="details">
      <h2>详情</h2>
      <div>
        <!-- {{pro.details}} -->
        <p>
          <img v-if="pic && pic.length>0" :src="require('../'+pic[0].lg)">
        </p>
        <p>商品名称：{{ pro.spu_name }}</p>
        <p>规格型号：{{ spec }}</p>
        <p>销售单价：{{ pro.price }}元</p>
      </div>
    </div>
    <div :class="{'pannel-spec':true,avtived:isShow}">
      <div class="top">
        <img v-for="(tem,index) in pic" :key="index" :src="require('../'+tem.lg)">
        <div>
          <p>商品名称：{{ pro.spu_name }}</p>
          <p>
            <small>￥</small>
            {{ pro.price }}
          </p>
          <p>商品编码：{{ pro.sku_no }}</p>
        </div>
        <a href="javascript:;" class="close" @click="closePannel">
          <i class="iconfont icon-guanbi"/>
        </a>
      </div>
      <div class="content">
        <div class="speclist clear">
          <dl id="attr0" class="clear">
            <dt>{{  (skuattr && skuattr.length>0) && skuattr[0].name }}</dt>
            <dd
              v-for="(a,idx) in attr0"
              :key="idx"
              :class="{selected:(a.av_id==vid0)}"
              :data-attr0="a.attr_id+':'+a.av_id"
              @click="checkSku(a.attr_id+':'+a.av_id,1)"
            >{{ a.value }}</dd>
          </dl>
          <dl id="attr1" class="clear">
            <dt>{{  (skuattr && skuattr.length>1) && skuattr[1].name }}</dt>
            <dd
              v-for="(a,idx) in attr1"
              :key="idx"
              :class="{selected:(a.av_id==vid1),disabled:a.flag==0}"
              :data-attr1="a.attr_id+':'+a.av_id"
              @click="a.flag==1 && checkSku(a.attr_id+':'+a.av_id,0)"
            >{{ a.value }}</dd>
          </dl>
        </div>
        <div class="wraper-count">
          <p>购买数量</p>
          <div class="count">
            <span @click="modifyCount(false)">-</span>
            <input v-model="count" type="text">
            <span @click="modifyCount(true)">+</span>
          </div>
        </div>
      </div>
      <div class="foot">
        <span @click="closePannel">
          <i class="iconfont icon-jiantou2"/>返回
        </span>
        <a href="javascript:;" @click="addCart">加入购物车</a>
      </div>
    </div>
    <div :class="{mark:true,show:isShow}">&nbsp;</div>
    <div class="btn">
      <span @click="handleBack">
        <i class="iconfont icon-jiantou2"/>返回
      </span>
      <a href="javascript:;" class="addcart" @click="showPannel">加入购物车</a>
      <a href="javascript:;" class="buynow" @click="buyNow">立即购买</a>
    </div>
    <div v-if="popShow" class="layer" :style="popStyle">&nbsp;</div>
    <div v-if="popShow" class="box" :style="popStyle">
      <div class="pop">
        <p>{{ msg }}</p>
        <div>
          <a @click="toPage(0)">继续浏览</a>
          <a @click="toPage(1)">去结算</a>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data: () => ({
    isShow: false, // 规格面板状态
    sku_id: null,
    attr_id0: null, // 第一属性名ID
    vid0: null, // 第一属性值ID
    attr0: [], // 第一属性列表
    vid1: null, // 第二属性值ID
    attr1: [], // 第二属性列表
    pro: {
      sku_name: null,
      price: null,
      spu_name:null,
      sku_no:null
    }, // 商品信息
    pic: [], // 商品图片
    skuattr: null, // 商品属性标题
    skulist: null, // sku和属性对应列表
    attrlist: null, // sku属性名、值对应列表
    spec: "", // 商品规格
    count: 1, // 商品数量
    msg: "添加成功!",
    popShow: false,
    popStyle: {}
  }),
  computed: {
    selected: function() {
      return this.spec + " " + this.count;
    },
    uid: function() {
      return this.$store.getters.uid;
    }
  },
  watch: {
    sku_id: function() {
      this.loadProduct(this.sku_id);
    }
  },
  created() {
    var sku_id = this.$route.params.id;
    this.sku_id = sku_id;
    // console.log(this.urlArr);
  },
  updated() {
    this.touchEvents(".photo>ul");
  },
  methods: {
    touchEvents(selector) {      
      let slider = document.querySelector(selector),
        isScrolling, // 这个参数判断是垂直滚动还是水平滚动
        count = slider.children.length, // 图片数量
        imgWidth = slider.children[0].clientWidth, // 图片宽度
        index = 0,
        startOffsetLeft; // 每次滑动时，slider初始位置

      slider.style.height = slider.children[0].offsetHeight + 'px';

      let events = {
        startPos: null,
        endPos: null,
        handleEvent: function(event) {
          let type = event.type;
          switch (type) {
            case "touchstart":
              this.start(event);
              break;
            case "touchmove":
              this.move(event);
              break;
            case "touchend":
              this.end(event);
          }
        },
        start: function(event) {
          // console.log("start");
          let touch = event.targetTouches[0]; //touches数组对象获得屏幕上所有的touch，取第一个touch
          this.startPos = { x: touch.pageX, y: touch.pageY, time: +new Date() }; //取第一个touch的坐标值
          slider.style.transition = "none";
          startOffsetLeft =  slider.offsetLeft

          slider.addEventListener("touchmove", this, false);
          slider.addEventListener("touchend", this, false);
        },
        move: function(event) {
          // console.log("move");
          if (
            event.targetTouches.length > 1 ||
            (event.scale && event.scale !== 1)
          )
            return;

          let touch = event.targetTouches[0];

          this.endPos = { x: touch.pageX - this.startPos.x, y: touch.pageY - this.startPos.y };
          isScrolling = Math.abs(this.endPos.x) < Math.abs(this.endPos.y) ? 1 : 0; //isScrolling为1时，表示纵向滑动，0为横向滑动
          if (isScrolling === 0) {
            event.preventDefault(); //阻止触摸事件的默认行为，即阻止滚屏
            slider.style.left = startOffsetLeft + this.endPos.x + "px";
          }
        },
        end: function(event) {
          // console.log("end");
          slider.style.transition = "left 0.3s";
          if (Math.abs(this.endPos.x) > 20) {
            if (this.endPos.x > 0) {
              index > 0 && index--;
            } else {
              index < count - 1 && index++;
            }
          }

          slider.style.left = -index * imgWidth + "px";

          slider.removeEventListener("touchmove", this, false);
          slider.removeEventListener("touchend", this, false);
        }
      };

      //判断设备是否支持touch事件
      let isTouch = ('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch

      if(!!isTouch) slider.addEventListener("touchstart", events, false);
    },
    handleBack() {
      var path = localStorage["backPath"];
      this.$router.push(path);
    },
    showPannel() {
      this.isShow = true;
      document.documentElement.style.overflowY = "hidden";
    },
    closePannel() {
      this.isShow = false;
      document.documentElement.style.overflowY = "scroll";
    },
    loadProduct(sku_id) {
      this.attr0 = [];
      this.attr1 = [];
      axios
        .get(this.GLOBAL.localServer + "data/product/product.php", {
          params: { sku_id }
        })
        .then(res => {
          // console.log(res);
          var data = res.data;
          var pro = data.data;
          var pic = data.pic;
          var attr = data.attr;
          var skulist = data.skulist;
          var attrlist = data.attrlist;

          this.pro = pro;
          this.pic = pic;
          this.skulist = skulist;
          this.attrlist = attrlist;

          // 商品属性
          // 属性
          var skuattr = [attr[0]];
          var attr_id0 = attr[0].attr_id;
          this.attr_id0 = attr_id0;

          for (var i = 1; i < attr.length; i++) {
            if (attr[i].attr_id != attr_id0) {
              skuattr.push(attr[i]);
              break;
            }
          }

          this.skuattr = skuattr;

          // console.log(skuattr);

          var sku_attr = pro.sku_attr.replace(/\[|\]/g, "");
          var color_id = parseInt(
            sku_attr.slice(sku_attr.indexOf(":") + 1, sku_attr.indexOf(","))
          ); // 当前属性值1 ID
          var version_id = parseInt(
            sku_attr.slice(sku_attr.lastIndexOf(":") + 1)
          ); // 当前属性值2 ID

          this.vid0 = color_id;
          this.vid1 = version_id;

          // 根据属性ID 获取value 得到规格
          this.spec = "";
          for (var item of attr) {
            if ([color_id, version_id].indexOf(parseInt(item.av_id)) != -1) {
              this.spec += item.value + " ";
            }
          }

          var totalVersion = []; // 所有版本
          for (var v of attr) {
            if (v.attr_id == skuattr[0].attr_id) {
              totalVersion.push(parseInt(v.av_id));
            }
          }
          // console.log("totalVersion: "+totalVersion);

          var _arrColor = [];
          var _arrVersion = [];
          for (var item of skulist) {
            var itemattr = item.sku_attr.replace(/\[|\]/g, "");
            var cid = itemattr.slice(
              itemattr.indexOf(":") + 1,
              itemattr.indexOf(",")
            );
            var vid = itemattr.slice(itemattr.lastIndexOf(":") + 1);
            _arrColor.push(cid);
            _arrVersion.push(vid);
          }
          // console.log(_arrColor);
          // console.log(_arrVersion);

          var arrCid = []; // 所有颜色 ID
          var arrVid = []; // 颜色对应的版本 ID

          for (var i = 0, _arr = []; i < _arrColor.length; i++) {
            if (i == 0) {
              arrCid.push(parseInt(_arrColor[i]));
              _arr.push(parseInt(_arrVersion[i]));
              continue;
            } else {
              if (arrCid.indexOf(parseInt(_arrColor[i])) == -1) {
                arrCid.push(parseInt(_arrColor[i]));
              }
              if (_arrColor[i] == _arrColor[i - 1]) {
                _arr.push(parseInt(_arrVersion[i]));
                if (i == _arrColor.length - 1) {
                  arrVid.push(_arr);
                }
                continue;
              } else {
                arrVid.push(_arr);
                _arr = [];
                _arr.push(parseInt(_arrVersion[i]));
              }
            }
          }
          // console.log(arrCid);
          // console.log(arrVid);

          // 选中颜色下，对应的可用版本
          var usableVersion = arrVid[arrCid.indexOf(color_id)];
          // console.log(usableVersion);

          // 判断当前颜色是否存在所有版本,如不存在，flag标记为0，存在则标记为1
          for (var item of attr) {
            if (item.attr_id == attr_id0) {
              this.attr0.push(item);
            } else {
              if (usableVersion.indexOf(parseInt(item.av_id)) != -1) {
                item["flag"] = 1;
              } else {
                item["flag"] = 0;
              }
              this.attr1.push(item);
            }
          }
        });
    },
    checkSku(val, flag) {
      var colorAV = "";
      var versionAV = "";
      if (flag) {
        colorAV = val;
        versionAV = document.querySelector("#attr1>.selected").dataset.attr1;
      } else {
        colorAV = document.querySelector("#attr0>.selected").dataset.attr0;
        versionAV = val;
      }

      var skuAttr = "[" + colorAV + "," + versionAV + "]";
      var av_id = parseInt(colorAV.slice(colorAV.indexOf(":") + 1));

      var skuId;
      for (var item of this.skulist) {
        if (item.sku_attr == skuAttr) {
          skuId = item.sku_id;
        }
      }

      if (!skuId) {
        for (var attr of this.attrlist) {
          if (av_id == attr.av_id) {
            skuId = attr.sku_id;
            break;
          }
        }
      }
      this.sku_id = skuId;
    },
    modifyCount(isAdd) {
      if (isAdd) {
        this.count++;
      } else {
        if (this.count == 1) {
          return;
        }
        this.count--;
      }
    },
    addCart() {
      var uid = this.uid;
      var sku_id = this.sku_id;
      var count = this.count;

      if (uid) {
        axios({
          method: "get",
          url: this.GLOBAL.localServer + "data/cart/addcart.php",
          params: { uid, sku_id, count }
        }).then(res => {
          if (res.data.code == 200) {
            const scorllTop =
              document.body.scrollTop || document.documentElement.scrollTop;
            // console.log(scorllTop)
            this.popStyle = { top: scorllTop + "px" };
            this.popShow = true;
            document.documentElement.style.overflowY = "hidden";
          }
        });
      } else {
        this.$router.push({
          path: "/login",
          query: { redirect: this.$route.path }
        });
      }
    },
    buyNow() {
      var uid = this.uid;
      var sku_id = this.sku_id;
      var count = this.count;
      var is_checked = 1;

      if (uid) {
        axios
          .get(this.GLOBAL.localServer + "data/cart/addcart.php", {
            params: { uid, sku_id, count, is_checked }
          })
          .then(() => {
            this.$router.push("/cforder/" + sku_id);
          });
      } else {
        this.$router.push("/cforder/" + sku_id);
      }
    },
    toPage(n) {
      if (n == 1) {
        this.$router.push("/cart");
      }
      this.popShow = false;
      this.isShow = false;
      document.documentElement.style.overflowY = "scroll";
    }
  }
};
</script>
<style lang="less" scoped>
@import "../assets/css/basic.less";
.cforder {
  background: #f9f9f9;
  height: 100%;
  .head {
    width: 100%;
    height: @headh;
    text-align: center;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 9;
    background: #fff;
    border-bottom: 1px solid #ddd;
    line-height: @headh;
    h1 {
      font-size: @lg;
      margin: 0 auto;
    }
    i {
      font-size: @lg;
      position: absolute;
      left: 5%;
      cursor: pointer;
    }
  }
  .photo {
    margin-top: @headh;
    position: relative;
    background: #fff;
    width: 100%;
    overflow: hidden;
    ul {
      width: 300vw;
      position: relative;
      left: 0;
      li {
        width: 100vw;
        float: left;
        img {
          width: 100%;
        }
      }
    }
    span {
      font-size: @lg;
      display: block;
      padding: 0.1em 0.8em;
      background: #ddd;
      border-radius: 1em;
      color: #fff;
      position: absolute;
      right: 1em;
      bottom: 1em;
    }
  }
  .desc {
    line-height: 1.5em;
    background: #fff;
    padding: 0 5% 1em;
    font-size: @md;
    p:last-child {
      padding-top: @pd;
      color: @color_normal;
    }
  }
  .spec {
    padding: 0.8em 5%;
    margin: 0.5em 0;
    font-size: @md;
    display: flex;
    justify-content: space-between;
    background: #fff;
    div:first-child {
      p {
        display: inline-block;
        line-height: @lg*1.5;
      }
      .value {
        font-size: @md;
        font-weight: 600;
        margin-left: 1em;
      }
    }
    i {
      font-size: @lg*1.5;
      cursor: pointer;
    }
  }
  .details {
    margin-bottom: @headh;
    background: #fff;
    padding: 0.5em 5% 2em;
    h2 {
      font-size: @lg;
      width: 12%;
      padding: 0.3em 0;
      border-bottom: 2px solid @color_normal;
      text-align: center;
    }
    div {
      font-size: @md;
      line-height: 2em;
      p {
        img {
          position: relative;
          left: 50%;
          transform: translateX(-50%);
          width: 80%;
        }
      }
    }
  }
  .pannel-spec {
    width: 90%;
    height: 75%;
    padding: 0 5%;
    position: fixed;
    left: 0;
    bottom: 0;
    z-index: 99;
    background: #fff;
    font-size: @md;
    overflow: auto;
    transition: all 0.5 linear;
    display: none;
    .top {
      width: 100%;
      background: #fff;
      height: 120px;
      position: fixed;
      top: 25%;
      left: 0;
      img {
        width: 120px;
        float: left;
        margin: 0 2em 0 1em;
        vertical-align: bottom;
      }
      div {
        position: absolute;
        left: 160px;
        bottom: 20px;
        line-height: 1.5em;
        p:nth-child(2) {
          color: @color_normal;
        }
        p:nth-child(3) {
          font-size: @sm;
        }
      }
      .close {
        display: inline-block;
        width: 30px;
        height: 30px;
        position: absolute;
        top: 10px;
        right: 10px;
        text-align: center;
        i {
          font-size: @md;
        }
      }
    }
    .top:after {
      content: "";
      display: block;
      clear: both;
    }
    .content {
      margin: 130px 0 @headh*1.2;
      .speclist {
        dl {
          margin-top: 1em;
          line-height: 1.5em;
          dt {
            margin-bottom: 0.5em;
          }
          dd {
            font-size: @sm;
            float: left;
            background: #f5f5f5;
            padding: 0 1em;
            margin-right: 0.5em;
            margin-bottom: 0.5em;
            border: 1px solid transparent;
            cursor: pointer;
          }
          dd.selected {
            color: @color_normal;
            border-color: @color_normal;
          }
          dd.disabled {
            color: #ddd;
            cursor: default;
          }
        }
      }
      .wraper-count {
        display: flex;
        justify-content: space-between;
        margin-top: 1.2em;
        font-size: @md;
        .count {
          input {
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
          span {
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
    .foot {
      position: fixed;
      left: 0;
      bottom: 0;
      width: 100%;
      height: @headh;
      line-height: @headh;
      background: #f0f0f0;
      display: flex;
      justify-content: space-between;
      span {
        display: block;
        width: 30%;
        text-align: center;
        cursor: pointer;
        i {
          font-size: @lg;
          margin-right: 0.5em;
        }
      }
      a {
        display: block;
        width: 30%;
        line-height: @headh;
        background: @color_normal;
        color: #fff;
        text-align: center;
        font-size: @md;
      }
    }
  }
  .pannel-spec.avtived {
    display: block;
  }
  .mark {
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 89;
    background: #000;
    opacity: 0.5;
    display: none;
  }
  .mark.show {
    display: block;
  }
  .btn {
    position: fixed;
    left: 0;
    bottom: 0;
    width: 100%;
    height: @headh;
    line-height: @headh;
    background: #f0f0f0;
    display: flex;
    justify-content: space-between;
    font-size: @md;
    span {
      display: block;
      width: 30%;
      text-align: center;
      margin-right: 10%;
      cursor: pointer;
      i {
        font-size: @lg;
        margin-right: 0.5em;
      }
    }
    a {
      display: block;
      text-align: center;
      font-size: @md;
      width: 30%;
      color: #fff;
      line-height: @headh;
    }
    a.buynow {
      background: @color_dark;
    }
    a.addcart {
      background: @color_normal;
    }
  }
  .layer {
    width: 100vw;
    height: 100vh;
    position: absolute;
    z-index: 199;
    left: 0;
    top: 0;
    background: rgba(0, 0, 0, 0.8);
  }
  .box {
    width: 100%;
    height: 100vh;
    position: absolute;
    left: 0;
    top: 0;
    z-index: 299;
    .pop {
      width: 220px;
      height: 160px;
      border: 1px solid #e7e7e7;
      border-radius: 5px;
      background: #fff;
      position: absolute;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%);
      z-index: 9;
      i {
        display: block;
        width: 40px;
        height: 40px;
        line-height: 40px;
        text-align: center;
        position: absolute;
        z-index: 9;
        background: @color_normal;
        border-radius: 50%;
        color: #fff;
        top: -20px;
        right: -20px;
        cursor: pointer;
      }
      p {
        text-align: center;
        padding: 15% 40px;
        font-size: @md;
      }
      div {
        width: 100%;
        text-align: center;
        position: absolute;
        left: 0;
        bottom: 30px;
        z-index: 9;
        display: flex;
        justify-content: center;
        a {
          display: block;
          font-size: @md*0.8;
          margin: 0 1em;
          padding: 0 1em;
          height: 2em;
          line-height: 2em;
          border-radius: 3px;
          cursor: pointer;
          color: #fff;
          background: linear-gradient(to bottom, #40a9e3 0%, #2e8fdc 100%);
          border: 1px solid #2785cf;
          border-radius: 3px;
        }
      }
    }
  }
}
</style>
