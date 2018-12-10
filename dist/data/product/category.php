<?php
    require('../init.php');
    $output = [];

    $sql = "SELECT cid,category_name,f_id FROM goods_category";
    $result = mysqli_query($conn,$sql);
    $output['category'] = mysqli_fetch_all($result,1);

    echo json_encode($output);
?>