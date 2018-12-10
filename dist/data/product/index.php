<?php
    require('../init.php');
    $output = [];

    $sql = "SELECT sku_id,sku_sub_name,price,dis_price,(SELECT lg FROM goods_spu_pic WHERE spu_id=a.spu_id AND is_default=1) lg FROM goods_sku a WHERE is_discount=1 LIMIT 5";
    $result = mysqli_query($conn,$sql);
    $output['discount'] = mysqli_fetch_all($result,1);

    $sql = "SELECT sku_id,sku_sub_name,price,spu_name,(SELECT lg FROM goods_spu_pic WHERE spu_id=a.spu_id AND is_default=1) lg FROM goods_sku a,goods_spu b WHERE a.spu_id=b.spu_id AND a.is_hot=1 LIMIT 6";
    $result = mysqli_query($conn,$sql);
    $output['hot'] = mysqli_fetch_all($result,1);

    $sql = "SELECT sku_id,sku_sub_name,price,spu_name,(SELECT lg FROM goods_spu_pic WHERE spu_id=a.spu_id AND is_default=1) lg FROM goods_sku a,goods_spu b WHERE a.spu_id=b.spu_id AND a.is_recommend=1 LIMIT 12";
    $result = mysqli_query($conn,$sql);
    $output['recommend'] = mysqli_fetch_all($result,1);

    $sql = "SELECT sku_id,sku_sub_name,price,spu_name,(SELECT lg FROM goods_spu_pic WHERE spu_id=a.spu_id AND is_default=1) lg FROM goods_sku a,goods_spu b,goods_category c WHERE a.spu_id=b.spu_id AND c.cid=b.cid AND c.f_id = 1 limit 6";
    $result = mysqli_query($conn,$sql);
    $output['machine'] = mysqli_fetch_all($result,1);

    $sql = "SELECT sku_id,sku_sub_name,price,spu_name,(SELECT lg FROM goods_spu_pic WHERE spu_id=a.spu_id AND is_default=1) lg FROM goods_sku a,goods_spu b,goods_category c WHERE a.spu_id=b.spu_id AND c.cid=b.cid AND c.f_id = 2 limit 8";
    $result = mysqli_query($conn,$sql);
    $output['parts'] = mysqli_fetch_all($result,1);

    $sql = "SELECT cid,category_name,sm,f_id FROM goods_category";
    $result = mysqli_query($conn,$sql);
    $output['category'] = mysqli_fetch_all($result,1);

    echo json_encode($output);
?>