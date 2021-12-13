<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once $_SERVER['DOCUMENT_ROOT'] . '/parts/head.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/core/readDB.php';
// $conn = readDb("RentingDatabase");
// if (!$conn) {
//     die("Connection failed: " . mysqli_connect_error());
// }

$sql = "DELETE FROM `member` WHERE `member`.`mID` = '".$_SESSION['ID']."'";
if (mysqlQuery($sql)) {
    echo "刪除成功!!";
    $_SESSION = array();
    @session_destroy();
    header("refresh:1;url='../'"); 
} else {
    echo "重試";
}
?>