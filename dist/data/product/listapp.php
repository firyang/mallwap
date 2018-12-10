<?php
    require('../init.php');
    $output = [];
    @$cid = $_REQUEST["cid"];    
    @$kw = $_REQUEST["kw"];
	@$orderKW = $_REQUEST["orderKW"];
	@$orderMethods = $_REQUEST["orderMethods"];


    if(!$cid){
        $sql = "SELECT sku_id,sku_sub_name,price,dis_price,(SELECT lg FROM goods_spu_pic WHERE spu_id=a.spu_id AND is_default=1) lg FROM goods_sku a";
        if($kw&&$kw!='undefined'){
            $kwArr = explode(" ",$kw);
            for($i=0;$i<count($kwArr);$i++){
                $kwArr[$i] = " sku_name LIKE '%".$kwArr[$i]."%'";
            }
            $searchStr = implode(" AND ",$kwArr);
            $sql.=" WHERE ".$searchStr;
        }
    }else{
        $sql = "SELECT sku_id,sku_sub_name,price,dis_price,(SELECT lg FROM goods_spu_pic WHERE spu_id=a.spu_id AND is_default=1) lg FROM goods_sku a,goods_spu b WHERE a.spu_id=b.spu_id AND b.cid=$cid";
    }

	if($orderKW){
		$sql .= "  ORDER BY  $orderKW  $orderMethods";
	}
    
    $result = mysqli_query($conn,$sql);
    $output['data'] = mysqli_fetch_all($result,1);

    echo json_encode($output);
?>