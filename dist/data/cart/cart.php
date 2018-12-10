<?php
    require('../init.php');
    $output = [];
    $uid = $_REQUEST['uid'];

    $sql = "select iid,sm,b.sku_id,sku_name,price,dis_price,count,is_checked from mall_shoppingcart_item as a,goods_sku as b,goods_spu_pic as c where a.sku_id=b.sku_id and b.spu_id=c.spu_id and uid=$uid";
    $result = mysqli_query($conn,$sql);
    $output['data'] = mysqli_fetch_all($result,1);

    $sql = "select * from mall_receiver_address where uid=$uid";
    $result = mysqli_query($conn,$sql);
    $output['addr'] = mysqli_fetch_all($result,1);

    echo json_encode($output);
?>