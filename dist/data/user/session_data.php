<?php
 require_once("../init.php");
 session_start();
 @$output['uid'] = $_SESSION["loginUid"];
 @$output['uname'] = $_SESSION["loginUname"];
 echo json_encode($output);