<?php
 require_once("../init.php");
 $uname = $_REQUEST["uname"];
 $upwd = $_REQUEST["upwd"];
 
$sql = "INSERT INTO mall_user(uname,upwd) VALUES ('$uname','$upwd')";
$result = mysqli_query($conn,$sql);
$rows = mysqli_affected_rows($conn);
if($rows>0){
    echo('{"code":200,"msg":"注册成功"}');
}else{
    echo('{"code":201,"msg":"网络故障请检查"}');
};