<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$_SESSION = array();
@session_destroy();

include_once $_SERVER['DOCUMENT_ROOT'] . '/parts/head.php';


echo "成功登出!<br>";


header("refresh:1;url='../'", true, 301);
// exit;
?>
