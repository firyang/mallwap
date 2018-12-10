<?php
    require('../init.php');
    $output = [];
    @$sku_id = $_REQUEST['sku_id'];
    @$count = $_REQUEST['count'];
    @$is_checked = $_REQUEST['is_checked'];
	if(!$is_checked){
		$is_checked = 0;
	}
    @$uid = $_REQUEST['uid'];
	$sql = "select iid from mall_shoppingcart_item where sku_id=$sku_id";
	$result = mysqli_query($conn,$sql);
	$row = mysqli_fetch_assoc($result);
	if($row){
		$iid = $row['iid'];
		$sql = "update mall_shoppingcart_item set count=count+$count,is_checked=$is_checked where iid=$iid";
	}else{
		$sql = "insert into mall_shoppingcart_item values(null,$uid,$sku_id,$count,$is_checked)";
	}
    $result = mysqli_query($conn,$sql);
    $output['code'] = 200;
    echo json_encode($output);
?>