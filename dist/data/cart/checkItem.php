<?php
    require('../init.php');
    $output = [];
    $iid = $_REQUEST['iid'];
    $is_checked = $_REQUEST['is_checked'];

    $sql = "update mall_shoppingcart_item set is_checked=$is_checked where iid=$iid";
    $result = mysqli_query($conn,$sql);
    $output['code'] = 200;
    echo json_encode($output);
?>