<?php
    require('../init.php');
    $output = [];

    $sql = "delete from mall_shoppingcart_item where is_checked=1";
    $result = mysqli_query($conn,$sql);
    $output['code'] = 200;
    echo json_encode($output);
?>