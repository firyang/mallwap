<?php
 require_once("../init.php");
 $code = $_REQUEST["code"];

 session_start();
 $sessionCode = $_SESSION["code"];
 if(strtolower($code)===strtolower($sessionCode)){
    echo('{"code":200,"msg":"ok"}'); 
 }else{
    echo('{"code":400,"msg":"验证码不正确"}'); 
 }