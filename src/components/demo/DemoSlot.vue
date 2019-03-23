<template>
  <div class="demo-slot">
    <div class="header">头部</div>
    <div slot></div>
  </div>
</template>
<script>
export default {
  
}
</script>
<style lang="less" scoped>
  .demo-slot{
    width: 300px;
    border: 1px solid #999;
    overflow: hidden;
    .header{
      line-height: 30px;
      background: #dddddd;
      border-bottom: 1px solid #999;
    }
  }
</style>


