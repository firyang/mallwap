<?php
    require('../init.php');
    $output = [];
    $is_checked = $_REQUEST['is_checked'];

    $sql = "update mall_shoppingcart_item set is_checked=$is_checked";
    $result = mysqli_query($conn,$sql);
    $output['code'] = 200;
    echo json_encode($output);
?>