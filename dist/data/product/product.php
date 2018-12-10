<?php
    require('../init.php');
    $output = [];
    $sku_id = $_REQUEST['sku_id'];

    $sql = "select a.spu_id,a.spu_name,slogan,featrue,service_desc,brand_name,c.sku_id,sku_name,sku_no,sku_attr,price,is_discount,dis_price,stock,details,packlist,service from goods_spu a,goods_brand b,goods_sku c,goods_spu_desc d where a.bid=b.bid and a.spu_id=d.spu_id and a.spu_id=c.spu_id and c.sku_id=$sku_id";
    $result = mysqli_query($conn,$sql);
    $output['data'] = mysqli_fetch_assoc($result);

    $sql = "select sm,lg,is_default from goods_spu_pic where spu_id=(select spu_id from goods_sku where sku_id=$sku_id)";
    $result = mysqli_query($conn,$sql);
    $output['pic'] = mysqli_fetch_all($result,1);

    $sql = "select a.name,b.content from goods_params a,goods_spu_params b where b.spu_id=(select spu_id from goods_sku where sku_id=$sku_id)";
    $result = mysqli_query($conn,$sql);
    $output['params'] = mysqli_fetch_all($result,1);

    $sql = "select distinct a.attr_id,c.name,a.av_id,d.value from goods_sku_attr a,goods_sku b,goods_attr c,goods_attr_value d where a.sku_id=b.sku_id and a.av_id=d.av_id and a.attr_id=c.attr_id and b.spu_id=(select spu_id from goods_sku where sku_id=$sku_id) order by c.f_id,a.attr_id,a.av_id";
    $result = mysqli_query($conn,$sql);
    $output['attr'] = mysqli_fetch_all($result,1);

    $sql = "select b.sku_id, attr_id,av_id from goods_sku_attr a,goods_sku b where a.sku_id=b.sku_id and b.spu_id=(select spu_id from goods_sku where sku_id=$sku_id)";
    $result = mysqli_query($conn,$sql);
    $output['attrlist'] = mysqli_fetch_all($result,1);

    $sql = "select sku_id, sku_attr from goods_sku where spu_id=(select spu_id from goods_sku where sku_id=$sku_id)";
    $result = mysqli_query($conn,$sql);
    $output['skulist'] = mysqli_fetch_all($result,1);

    echo json_encode($output);
?>