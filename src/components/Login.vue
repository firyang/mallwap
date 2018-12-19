<template>
  <div class="login">
    <div class="head"><i class="iconfont icon-jiantou2" @click="handleBack"></i><h1>登录</h1></div> 
    <div class="wraper">
        <form class="unamelogin" v-if="isUloign">            
            <label for="uname" class="uname">
                <input type="text" name="uname" v-model="uname" placeholder="用户名/邮箱/手机">        
            </label>
            <label for="upwd" class="upwd">
                <input :type="isHide?'password':'text'" name="upwd" v-model="upwd" placeholder="请输入密码">
                <p><i :class="{iconfont:true,'icon-yanjing':!isHide,'icon-guanbi-yanjing':isHide}" @click="showPwd"></i><span>|</span><a href="javascript:;">忘记密码</a></p>
            </label>
            <label for="" class="btn">
                <input type="button" value="登录" :class="{actived:isActive}" @click="isActive && login()">
            </label>
        </form>
        <form class="codelogin" v-if="!isUloign">
            <label for="phone" class="uname">
                <input type="text" name="phone" v-model="phone" placeholder="请输入手机号">
                <p><span>|</span><a href="javascript:;">获取验证码</a></p>        
            </label>
            <label for="upwd" class="code">
                <input type="text" name="code" v-model="verifycode" placeholder="请输入收到的验证码">
            </label>
            <label for="" class="btn">
                <input type="button" value="登录" :class="{actived:isActive}" @click="isActive && login()">
            </label>
        </form>
        <p class="togglelogin"><a href="javascript:;" class="loginmethods" @click="toggleLogin">{{isUloign?'短信验证码登录':'账号密码登录'}}</a><a href="javascript:;">手机快速注册</a></p>
        <div class="otherlogin">
            <p><span>其他登录方式</span><i class="line"></i></p>
            <ol>
                <li><a href="javascript:;"><i class="iconfont icon-qq"></i><span>QQ</span></a></li>
                <li><a href="javascript:;"><i class="iconfont icon-weixin1"></i><span>微信</span></a></li>
            </ol>
            <em>登录即代表已同意隐私政策</em>
        </div>
        <div class="layer" v-if="popShow">&nbsp;</div>
		<div class="box"  v-if="popShow"><div class="pop"><i class="iconfont icon-guanbi" @click="closePop"></i><p>{{msg}}</p><a @click="closePop">确定</a></div></div>
    </div>
  </div>    
</template>
<script>
  export default {
    data: () => ({
      isUloign: true,
      uname:'test@qq.com',
      upwd:'40fbe32a8a5789ea8f62f978c81d2ba7',
      phone:'',
      verifycode:'',
      isActive: false,
      isHide:true,
      msg:'登录成功',
      popShow: false,
      popState: false,
      skip:false
    }),
    created () {
    },
    watch:{
        uname: function(){
            this.checkInput(true);
        },
        upwd: function(){
            this.checkInput(true);
        },
        phone: function(){
            this.checkInput(false);
        },
        verifycode: function(){
            this.checkInput(false);
        },
        skip: function(){
            if(this.skip){
                this.$router.push(this.$route.query.redirect);
            }            
        }
    },
    methods: {
        handleBack(){
            this.$router.go(-1);
        },
        toggleLogin(){
            this.isUloign = !this.isUloign;
        },
        checkInput(flag){
            if(flag){                
                if(this.uname!=''&&this.upwd!=''){
                    this.isActive = true;
                }else{
                    this.isActive = false;
                }
            }else{
               if(this.phone!=''&&this.verifycode!=''){
                    this.isActive = true;
                }else{
                    this.isActive = false;
                } 
            }
        },
        showPwd(){
            this.isHide = !this.isHide;
        },
        login(){
            let params = {
                'uname': this.uname,
                'upwd' : this.upwd
            }
            this.$store.dispatch('Login', params)
                .then(res=>{
                    this.msg = res.data.msg;
                    this.popShow = true;                    
                    if(res.data.code==200){
                        this.popState = true;                        
                    }else{
                        this.popState = false;
                    }
                })
                .catch(error=>{
                    console.log(error.response);
                })
        },
        closePop(){
            if(this.popState){
                this.skip = true;
            }else{
                this.skip = false;
                this.popShow = false;
            }
            
        }
    }
  }
</script>
<style lang="less" scoped>
  @import '../assets/css/basic.less';
.login{
  height: 100vh;
  .head{
    width: 100%;
    height: @headh;
    text-align: center;
    position: relative;
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
      width: 90%;
      padding: 0 5%;
      form{
          label{
              input{
                font-size: @md;
                border: none;
                outline: none;
                width: 100%;
                padding: 1em 0;
                border-bottom: 1px solid #ddd;
                margin-top: 1.5em;
              }              
          }
          .uname{
              input{
                width: 100%;
              }
          }
          .upwd{
              position: relative;
              input{
                  width: 65%;
                  padding-right: 35%;
              }
              p{
                  position: absolute;
                  right:0;
                  top: 50%;
                  transform: translateY(-50%);      
                  i{
                      font-size: @md;
                      color: #999;
                      padding: 10px;
                  }
                  .icon-yanjing{
                      font-size: @md;
                  }
                  span{
                      margin: 0 0.5em 0 0.2em;
                      display: inline-block;
                      color: #ddd;
                  }
                  a{
                      font-size: @md;
                      display: inline-block;
                      padding: 1em 0.5em 1em 0;
                  }
              }
          }
          .btn{
              input{
                  border:none;
                  outline:none;
                  width: 100%;
                  background: @color_light;
                  color: #fff;
                  font-size: @md;
                  text-align: center;
                  padding: 0.8em 0;
                  border-radius: 2em;              
              }
              .actived{
                  background: @color_normal;
              }
          }
      }
      .codelogin{
          .uname{
              position: relative;
              input{
                  width: 70%;
                  padding-right: 30%;
              }
              p{
                  position: absolute;
                  right:0;
                  top: 50%;
                  transform: translateY(-50%);
                  span{
                      margin: 0 0.6em;
                      display: inline-block;
                      font-size: @md;
                      color: #ddd;
                  }
                  a{
                      font-size: @md;
                      display: inline-block;
                      padding: 1em 0.5em 1em 0;
                  }
              }
          }
      }
      .togglelogin{
          display: flex;
          justify-content: space-between;
          a{
              display: block;
              font-size: @md;
              padding: 1em 0;
              color: #999;
          }
      }
      .otherlogin{
          width: 100%;
          margin-top: 60px;
          font-size: @md;
          text-align: center;
          p{
              color: #999;
              position: relative;
              width: 100%;
              span{
                  background: #fff;
                  padding: 0 1em;
              }
              i{
                  display: inline-block;
                  width: 100%;
                  height: 1px;
                  border-top: 1px solid #ddd;
                  position: absolute;
                  left: 0;
                  top: 50%;
                  transform: translateY(-50%);
                  z-index: -1;
              }
          }
          ol{
              li{
                  display: inline-block;
                  margin: 2em 1em;
                  a{
                      i{
                          font-size: @lg*2;
                      }
                      .icon-qq{
                          color: #12B7F5; /*B2CFF7*/
                      }
                      .icon-weixin1{
                          color:#00D00B;
                      }
                      span{
                          display: block;
                          font-size: @md;
                          margin-top: 0.5em;
                          color: #999;
                      }
                  }
              }
          }
          em{
              color: #999;
          }
      }
      .layer{
            width: 100vw;
            height: 100vh;
            position: absolute;
            z-index: 3;
            left: 0;
            top: 0;
            background: rgba(0,0,0,.6);
      }        
        .box{
            width: 100%;
            height: 100%;
            position: absolute;
            left: 0;
            top: 0;
            z-index: 6;
            .pop{
                width: 220px;
                height: 160px;
                border: 1px solid #e7e7e7;
                border-radius: 5px;
                background: #fff;
                position: absolute;
                left: 50%;
                top: 50%;
                transform: translate(-50%,-50%);
                z-index: 9;
                i{
                    display: block;
                    width: 35px;
                    height: 35px;
                    line-height: 35px;
                    font-size: @sm;
                    text-align: center;
                    position: absolute;
                    background: @color_normal;
                    border-radius: 50%;
                    color: #fff;
                    top:-15px;
                    right: -15px;
                    cursor: pointer;
                }
                p{
                    text-align: center;
                    padding: 15% 40px;
                    font-size:@md;
                }
                a{
                    display: block;
                    font-size: @md*0.9;
                    text-align: center;
                    color: #fff;
                    width: 4em;
                    height: 2em;
                    line-height: 2em;
                    background: linear-gradient(to bottom,#40A9E3 0%,#2E8FDC 100%);
                    border: 1px solid #2785CF;
                    border-radius: 3px;
                    position: absolute;
                    z-index: 9;
                    left: 50%;
                    transform: translateX(-50%);
                    bottom: 30px;
                    cursor: pointer;
                }
            }
        }
  }
}
</style>
