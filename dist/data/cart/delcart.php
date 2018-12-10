<?php
    require('../init.php');
    $output = [];
    $iid = $_REQUEST['iid'];

    $sql = "delete from mall_shoppingcart_item where iid=$iid";
    $result = mysqli_query($conn,$sql);
    $output['code'] = 200;
    echo json_encode($output);
?>