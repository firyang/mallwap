<?php
    header('Access-Control-Allow-Origin:http://192.168.0.104:8080');
	header('Access-Control-Allow-Credentials:true');
    header('Access-Control-Allow-Methods:GET,POST');
    header('Content-Type:application/json;charset=UTF-8');
    $conn = mysqli_connect("114.116.112.183","root","Tkxk6=Q1","toyomall",3306);
    mysqli_query($conn,"SET NAMES UTF8");