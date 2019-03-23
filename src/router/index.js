import Vue from 'vue'
import Router from 'vue-router'
import store from '../store'
import Main from '@/components/Main'
import Index from '@/components/Index'
import Products from '@/components/Products'
import ShoppingCart from '@/components/ShoppingCart'
import ShoppingCartLogin from '@/components/ShoppingCartLogin'
import Login from '@/components/Login'
import Member from '@/components/Member'
import ConfirmOrder from '@/components/ConfirmOrder'
import Details from '@/components/Details'
import NotFound from '@/components/NotFound'
import Demo from '@/components/demo/Demo'

Vue.use(Router)

const router =  new Router({
  routes: [
    {
      path: '',
      component: Main,
      children: [
        {
          path: '/',
          name: 'index',
          component: Index,
          meta:{
            title:'首页'
          }
        },
        {
          path: '/pro',
          name: 'products',
          component: Products,
          meta:{
            title:'产品中心'
          }
        },
        {
          path: '/pro/:cid',
          name: 'products-c',
          component: Products,
          meta:{
            title:'产品分类列表'
          }
        },
        {
          path: '/cart',
          name: 'cart',
          component: ShoppingCart,
          meta:{
            title:'购物车'
          }
        },
        {
          path: '/c2l',
          name: 'cart2login',
          component: ShoppingCartLogin
        },
        {
          path: '/member',
          name: 'member',
          component: Member,
          meta:{
            title:'会员中心'
          }
        }
      ]
    },
    {
      path: '/cforder',
      name: 'cforder',
      component: ConfirmOrder,
      meta:{
        title:'确认订单'
      }
    },
    {
      path: '/cforder/:id',
      name: 'buynow',
      component: ConfirmOrder,
      meta:{
        title:'确认订单'
      }
    },
    {
      path: '/details/:id',
      name: 'details',
      component: Details,
      meta:{
        title:'产品详情'
      },
      beforeEnter(to,from,next){        
        let path = from.fullPath;
        if(['/','/pro','/cart','/cforder'].indexOf(path)!=-1){
          localStorage.setItem("backPath",path);
        }        
        next();
      }

    },
    {
      path: '/login',
      name: 'login',
      component: Login,
      meta:{
        title:'登录'
      }
    },
    {
      path: '*',
      name: 'notfound',
      component: NotFound,
      meta:{
        title:'NotFound Page'
      }
    },
    {
      path: '/demo',
      name: 'Demo',
      component: Demo,
      meta:{
        title:'Demo Page'
      }
    }
  ]
});

router.beforeEach((to,from,next)=>{
  // to: Route: 即将要进入的目标, 路由对象
  // from: Route: 当前导航正要离开的路由
  // next: Function: 一定要调用该方法来 resolve 这个钩子. 执行效果依赖 next 方法的调用参数

  // 动态修改页面title
  document.title = to.meta.title;

  const nextRoute = ['cart','cforder','buynow','member'];

  store.dispatch('CheckLoginState').then(()=>{
    // 未登录状态, 当路由到nextRoute指定页时, 跳转至login
    if(nextRoute.indexOf(to.name) >= 0){
      if(!store.getters.isLoggedIn){
        let url = '';
        to.name=='buynow'?(url=from.fullPath):(url=to.fullPath);
        next({
          path: '/login',
          query: {redirect: url} //// 将跳转的路由path作为参数，登录成功后跳转到该路由
        })
      }else{
        next();
      }  
    }else{
      next();
    }

    // 已登录状态, 当路由到login时, 不进行跳转
    if(to.name === 'login'){
      if(store.getters.isLoggedIn){
        router.push(from.fullPath);
      }
    }
  });  
});

export default router;
