<?php

session_start();
include('./header.php');
$page_flag = 0;
// openDB
include_once "readdb_php.php";
$conn = readDb("RentingDatabase");
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}
// flag
if (isset($_POST["submit"])) {
	foreach (array_keys($_POST) as $key) {
		$post[$key] = $_POST[$key];
	}
	$error = validation($post);
	if (empty($error)) {
		$page_flag = 1;
	}
}
?>

<!-- error -->
<?php if (!empty($error)) : ?>
	<ul class="error_list">
		<?php foreach ($error as $value) : ?>
			<li><?php echo $value; ?></li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>

<?php if ($page_flag == 0) : ?>

	<!DOCTYPE html>
	<html>

	<head>
		<title>租借教室</title>
	</head>

	<body>
		<form class="cmxform" id="search_form" action="" method="POST" accept-charset="utf-8">
			<fieldset>
				<ul>
					<li class="rentTime">
						<label for="rentTimeFrom">使用日時 自<label>
								<input type="datetime-local" name="rentTimeFrom" />
								<label for="rentTimeTo">至</label>
								<input type="datetime-local" name="rentTimeTo" />
					</li>
					<li class="classroom">
						<label for="classroom">借用場地</label>
						<?php
						$selctClassroom = "SELECT * From classroom";
						mysqli_query($conn, "SET NAMES 'utf8'");
						$classroom_list = mysqli_query($conn, $selctClassroom);
						echo "<select name=\"classroom\" class=\"classroom\">";
						echo "<option value=\"NULL\">不借場地</option>";
						for ($i = 1; $i <= mysqli_num_rows($classroom_list); $i++) {
							$rs = mysqli_fetch_row($classroom_list);
							echo "<option value=\"" . $rs[0] . "\">" . $rs[1] . "</option>";
						}
						echo "</select>";
						?>
					</li>
					<li>
						<fieldset>
							<legend>選擇器材</legend>
							<div id="rent_items">
								<?php
								$selctEquipment = "SELECT * From equipment";
								mysqli_query($conn, "SET NAMES 'utf8'");
								$equipment_list = mysqli_query($conn, $selctEquipment);

								for ($i = 1; $i <= mysqli_num_rows($equipment_list); $i++) {
									$rs = mysqli_fetch_row($equipment_list);
									echo "<input type=\"checkbox\" name=\"equipment[]\" value=\"" . $rs[0] . "\">" . $rs[1];
								}

								?>
							</div>
						</fieldset>
					</li>
					<li><input id="search_submit" type="submit" name="submit" value="送出">
					</li>
				</ul>
			</fieldset>
		</form>
	</body>

	</html>
	<!-- 送出sql -->
<?php elseif ($page_flag == 1) : ?>

	<?php
	//借教室的部分
	//搜尋
	//if(isset($_GET['classroomName'])){
	//	$keyword_where  = " name like '%".$_GET['classroomName']."%' //and ";
	//}

	$date = new DateTime();
	$dateToday = $date->format('Y/m/d');
	//將資料庫中rID選出最大者
	$sql0 = "SELECT MAX(rID) from Rental_Agreement ";
	$rIDResult = mysqli_query($conn, $sql0);
	$rIDArray = mysqli_fetch_row($rIDResult);
	$Insert_rID = (int)$rIDArray[0] + 1; //流水號+1，不過不知為何永遠是2
	$rIDDigits = strlen($Insert_rID); //rID位數
	for ($i = 0; $i < 7 - $rIDDigits; $i++) {
		$Insert_rID = "0" . $Insert_rID;
	}



	//新增租借教室

	//Rental_Agreement 
	if ($_POST["classroom"] != "NULL") {
		$sql = "INSERT INTO Rental_Agreement VALUES ('" . $Insert_rID . "', '" . $_SESSION['ID'] . "', '" . $_POST["classroom"] . "', '" . $dateToday . "', '" . $_POST['rentTimeFrom'] . "', '" . $_POST['rentTimeTo'] . "',NULL,NULL,NULL)";
		$result = $conn->query($sql);
		if ($result === TRUE) {
			echo "教室租借成功<br>";
		} else {
			echo "教室租借失敗<br>";
		}
	} else { //不借教室
		$sql = "INSERT INTO Rental_Agreement VALUES ('" . $Insert_rID . "', '" . $_SESSION['ID'] . "',NULL, '" . $dateToday . "', '" . $_POST['rentTimeFrom'] . "', '" . $_POST['rentTimeTo'] . "',NULL,NULL,NULL)";
		$result = $conn->query($sql);
		if ($result === TRUE) {
			echo "租借表建立成功<br>";
		} else {
			echo "租借表建立失敗<br>";
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
			echo $sql1;
			$result = $conn->query($sql1);
			if ($result === TRUE) {
				echo getEquipmentName($equipment[$i]) . "租借成功<br>";
			} else {
				echo getEquipmentName($equipment[$i]) . "租借失敗<br>";
			}
		}
	}


	?>
<?php endif; ?>

<?php
function validation($post)
{
	include_once "readdb_php.php";
	$conn = readDb("RentingDatabase");
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

	$error = array();

	$rentTimeFrom = $post["rentTimeFrom"];
	$rentTimeTo = $post["rentTimeTo"];
	$rentClassroom = $post["classroom"];
	if (!empty($post["equipment"])) {
		$rentEquipments = $post["equipment"];
	} else {
		$rentEquipments = "NULL";
	}


	if (empty($rentTimeFrom)) {
		$error[] = "請輸入開始使用日時。";
	}
	if (empty($rentTimeTo)) {
		$error[] = "請輸入使用結束日時。";
	}
	if ($rentClassroom == "NULL" and $rentEquipments == "NULL") {
		$error[] = "請選擇教室或至少一項的設備。";
	}
	$date = date_create($post["rentTimeFrom"]);
	$dateFrom  = date_format($date, 'U');
	$date = date_create($post["rentTimeTo"]);
	$dateTo  = date_format($date, 'U');

	if ($post["classroom"] != "NULL") {
		$sql = "SELECT rDateTimeFrom,rDateTimeTo From Rental_Agreement WHERE rApproval = '1' and cID = '" . $post["classroom"] . "'";
		mysqli_query($conn, "SET NAMES 'utf8'");
		$dateFromTo = mysqli_query($conn, $sql);
		for ($i = 1; $i <= mysqli_num_rows($dateFromTo); $i++) {
			$rs = mysqli_fetch_row($dateFromTo);
			$date = date_create($rs[0]);
			$uDataFrom = date_format($date, 'U');
			$date = date_create($rs[1]);
			$uDataTo = date_format($date, 'U');
			if (($uDataFrom < $dateFrom and $dateFrom < $uDataTo) or ($uDataFrom < $dateTo and $dateTo < $uDataTo)) {
				$error[] = "此時段已被租借。";
				return $error;
			}
		}
	}
	return $error;
}

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

<style type="text/css">
	form.cmxform {
		margin: 1em 0;
		padding: 0;
	}

	form.cmxform fieldset li {
		list-style: none;
		clear: both;
		margin: 0;
		padding: 5px 5px 7px 7px;
		background: url(/content/img/css/cmxform-divider.gif) left bottom repeat-x;
	}

	.error_list {
		background: #fff0f3;
		width: 100%;
		padding: 10px 30px;
		color: #ff2e5a;
		font-size: 86%;
		border: 1px solid #ff2e5a;
		border-radius: 5px;
		position: absolute;
		bottom: 0;
	}
</style>