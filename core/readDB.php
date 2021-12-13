<?php
function readDb($dbName)
{
	//$dbName = 'RentingDatabase';
	$conn = @mysqli_connect(
		'localhost',  // MySQL主機名稱 
		'root',       // 使用者名稱 
		'',  // 密碼
		$dbName
	);  // 預設使用的資料庫名稱

	mysqli_query($conn, "SET NAMES 'utf8'");
	if (!mysqli_select_db($conn, $dbName))
		die("無法開啟 $dbName 資料庫!<br/>");

	return $conn;
}
function mysqlQuery($sql){
	include_once $_SERVER['DOCUMENT_ROOT'] . '/core/readDB.php';
	$conn = readDb("RentingDatabase");
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	$result = mysqli_query($conn, $sql);

	return $result;
}