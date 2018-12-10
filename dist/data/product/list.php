<?php
    require('../init.php');
    $output = [];
    @$cid = $_REQUEST["cid"];    
    @$kw = $_REQUEST["kw"];
    @$pageSize = $_REQUEST["pageSize"];
    if(!$pageSize){
        $pageSize = 10;
    }
    @$pno = $_REQUEST["pno"];
    if(!$pno){
        $pno = 1;
    }

    $pageStart = ($pno-1)*$pageSize;

    if(!$cid){
        $sqlCount = "SELECT COUNT(sku_id) FROM goods_sku";
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
        $sqlCount = "SELECT COUNT(sku_id) FROM goods_sku a,goods_spu b WHERE a.spu_id=b.spu_id AND b.cid=$cid";
        $sql = "SELECT sku_id,sku_sub_name,price,dis_price,(SELECT lg FROM goods_spu_pic WHERE spu_id=a.spu_id AND is_default=1) lg FROM goods_sku a,goods_spu b WHERE a.spu_id=b.spu_id AND b.cid=$cid";
    }
    $proCount = count(mysqli_fetch_all(mysqli_query($conn,$sql),1));
    $pageCount = ceil($proCount/$pageSize);

    $output["pageSize"] = $pageSize;
    $output["pno"] = $pno;
    $output["pageCount"] = $pageCount;

    $sql.=" LIMIT $pageStart, $pageSize";

    $result = mysqli_query($conn,$sql);
    $output['data'] = mysqli_fetch_all($result,1);

    echo json_encode($output);
?>