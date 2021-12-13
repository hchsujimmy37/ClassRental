<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/parts/head.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/core/readDB.php';

foreach ($_POST['applications'] as $datePriod) {
    $applications[] = explode('_', $datePriod,);
}

asort($applications); //排序

$error = array();

include_once $_SERVER['DOCUMENT_ROOT'] . '/core/readDB.php';

foreach ($applications as $application) {
    $appricationStart = $application[0] ." ". $priodsStart[$application[1]] . ":00";
    $appricationEnd = $application[0] ." ". $priodsEnd[$application[1]] . ":00";

    $sql = "SELECT rDateTimeFrom,rDateTimeTo From Rental_Agreement WHERE cID = '" . $_POST["classroom"] . "'";
    $result = mysqlQuery($sql);

    foreach ($result as $row) {

        if ((strtotime($appricationStart) <= strtotime($row['rDateTimeTo']) and strtotime($row['rDateTimeFrom']) <= strtotime($appricationEnd))) {
            echo "此時段已被租借。請重試一次。";
            header("refresh:5;url='../'", true, 301);
            exit;
        }

    }

    $date = new DateTime();
    $dateToday = $date->format('Y/m/d');
    //將資料庫中rID選出最大者
    $sql0 = "SELECT MAX(rID) from Rental_Agreement ";
    $rIDResult = mysqlQuery($sql0);
    $rIDArray = mysqli_fetch_row($rIDResult);
    $Insert_rID = (int)$rIDArray[0] + 1; //流水號+1，不過不知為何永遠是2
    $rIDDigits = strlen($Insert_rID); //rID位數
    for ($i = 0; $i < 7 - $rIDDigits; $i++) {
        $Insert_rID = "0" . $Insert_rID;
    }

    //新增租借教室

    //Rental_Agreement 
    if ($_POST["classroom"] != "NULL") {
        $sql = "INSERT INTO Rental_Agreement VALUES ('" . $Insert_rID . "', '" . $_SESSION['ID'] . "', '" . $_POST["classroom"] . "', '" . $dateToday . "', '" . $appricationStart . "', '" . $appricationEnd  . "',NULL,NULL,NULL)";
        $result =  mysqlQuery($sql);
        if ($result === TRUE) {
            // echo $application[0]." 第".$application[1]."節 :租借成功!<br>";
        } else {
            $error =  $application[0]." 第".$application[1]."節 :室租借失敗";
        }
    } else { //不借教室
        $sql = "INSERT INTO Rental_Agreement VALUES ('" . $Insert_rID . "', '" . $_SESSION['ID'] . "',NULL, '" . $dateToday . "', '" . $appricationStart . "', '" . $appricationEnd  . "',NULL,NULL,NULL)";
        $result =  mysqlQuery($sql);
        if ($result === TRUE) {
            // echo "租借表建立成功<br>";
        } else {
            $error = "租借表建立失敗";
        }
    }

    //Equipment_Renting
    if (!empty($_POST["equipment"])) {
        $rentEquipments = $_POST["equipment"];
    } else {
        $rentEquipments = "NULL";
    }
    if ($rentEquipments != "NULL") {
        $equipment = $_POST['equipment'];
        for ($i = 0; $i < count($equipment); $i++) {
            $sql1 = "INSERT INTO Equipment_Renting VALUES ('" . $Insert_rID . "', '" . $equipment[$i] . "')";
            $result = mysqlQuery($sql1);
            if ($result === TRUE) {
                // echo getEquipmentName($equipment[$i]) . " 租借成功!<br>";
            } else {
                $error = $application[0]." 第".$application[1]."節 :".getEquipmentName($equipment[$i]) . " 租借失敗<";
            }
        }
    }

}

if (!empty($error)){
        foreach ($error as $value){
            echo $value;
        }
}else{
    echo "租借成功!<br>";

}

header("refresh:1;url='../'", true, 301);
exit;

//$application[0].$priodsStart[$application[1]]." 00:00:00" //start
//$application[0].$priodsEnd[$application[1]]." 00:00:00" //end

function getEquipmentName($equipmentID)
{
	include_once "readdb_php.php";
	$conn = readDb("RentingDatabase");
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	$sql = "SELECT eName From equipment WHERE eID = '" . $equipmentID . "'";
	mysqli_query($conn, "SET NAMES 'utf8'");
	$equipmentName = mysqli_fetch_row(mysqli_query($conn, $sql));


	return $equipmentName[0];
}
?>

