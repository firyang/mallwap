<?php
    require_once("../init.php");
    $output = ["code"=>200,"msg"=>"登录成功"];
    $uname = $_REQUEST["uname"] or die('{"code":401,"msg":"username required"}');
    $upwd = $_REQUEST["upwd"] or die('{"code":401,"msg":"password required"}');

    session_start();

    $sql = "SELECT uid FROM mall_user WHERE uname='$uname' AND binary upwd='$upwd'";
    $result = mysqli_query($conn,$sql);
    if(!$result){
        echo('{"code":500, "msg":"db execute err"}');
    }else{
        $row = mysqli_fetch_assoc($result);
        if($row===null){
            echo('{"code":201, "msg":"用户名或密码错误"}');
        }else{
            $_SESSION['loginUname'] = $uname;
            $_SESSION['loginUid'] = $row['uid'];
			$user['uid'] = $row['uid'];
			$user['uname'] = $uname;
			$output['user'] = $user;
            echo json_encode($output);
        }
    } 