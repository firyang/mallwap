<?php
    require('../init.php');
    $output = [];

    $sql = "SELECT sku_id,sku_sub_name,price,spu_name,(SELECT lg FROM goods_spu_pic WHERE spu_id=a.spu_id AND is_default=1) lg FROM goods_sku a,goods_spu b,goods_category c WHERE a.spu_id=b.spu_id AND c.cid=b.cid AND c.f_id=1 limit 4";
    $result = mysqli_query($conn,$sql);
    $output['machine'] = mysqli_fetch_all($result,1);

    $sql = "SELECT sku_id,sku_sub_name,price,spu_name,(SELECT lg FROM goods_spu_pic WHERE spu_id=a.spu_id AND is_default=1) lg FROM goods_sku a,goods_spu b,goods_category c WHERE a.spu_id=b.spu_id AND c.cid=b.cid AND c.f_id=2 limit 4";
    $result = mysqli_query($conn,$sql);
    $output['parts'] = mysqli_fetch_all($result,1);

    echo json_encode($output);
?>