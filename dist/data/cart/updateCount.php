<?php
    require('../init.php');
    $output = [];
    $iid = $_REQUEST['iid'];
    $count = $_REQUEST['count'];
    /**
     * 图片
     * 名称
     * 价格
     * 数量
     */

    $sql = "update mall_shoppingcart_item set count=$count where iid=$iid";
    $result = mysqli_query($conn,$sql);
    $output['code'] = 200;
    echo json_encode($output);
?>