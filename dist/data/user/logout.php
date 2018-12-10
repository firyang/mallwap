<?php
    require_once("../init.php");
    session_start();
    session_unset();  
    session_destroy();
    echo '{"code":200, "msg":"logout succ"}';