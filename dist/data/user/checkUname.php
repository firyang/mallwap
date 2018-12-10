<?php
 require_once("../init.php");
 $uname = $_REQUEST["uname"];

 $sql = "SELECT uid FROM mall_user WHERE uname='$uname'";
 $result = mysqli_query($conn,$sql); 
 $row = mysqli_fetch_assoc($result);
 if($row){
    echo('{"msg":"用户名已存在"}'); 
 }else{
    echo('{"msg":"ok"}'); 
 }