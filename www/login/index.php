<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/parts/head.php';

$page_flag = 0;
?>

<?php if (isset($_SESSION['ID'])) : ?>
	<!-- SESSION中有ID -->

	<?php header('Location: ../', true, 301); ?>


<?php elseif (isset($_POST["login"])) : ?>

	<!-- 利用POST(登入按鈕)來的  -->
	<?php
	foreach (array_keys($_POST) as $key) {
		$post[$key] = $_POST[$key];
	}
	$error = validationForLogin($post); //檢查
	if (empty($error)) {
		$page_flag = 1;
	}
	?>
<?php elseif (isset($_POST["register"])) : ?>
	<?php

	foreach (array_keys($_POST) as $key) {
		$post[$key] = $_POST[$key];
	}
	$error = validationForRegister($post); //檢查
	if (empty($error)) {
		$page_flag = 1;
	}
	?>
<?php endif; ?>

<!-- error -->
<?php if (!empty($error)) : ?>
	<ul class="error_list_absolute">
		<?php foreach ($error as $value) : ?>
			<li><?php echo $value; ?></li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>

<?php if ($page_flag == 0) : ?>

	<div class="login-page">
		<div class="entryForm">
			<form class="registerForm" action='#!' method='POST'>
				<div class='grid'>
					<span class='lName required'>姓:</span>
					<input type="text" name="lName" class="required" placeholder="姓" <?php isset($_POST['lName']) ? print "value='" . $_POST['lName'] . "'" : NULL ?> />
					<span class='fName required'>名:</span>
					<input type="text" name="fName" class="required" placeholder="名" <?php isset($_POST['fName']) ? print "value='" . $_POST['fName'] . "'" : NULL ?> />
					<span class='grade'>年級:</span>
					<input type="number" name="grade" min='1' placeholder="年級" <?php isset($_POST['grade']) ? print "value='" . $_POST['grade'] . "'" : NULL ?> />
					<span class='major'>主修:</span>
					<input type="text" name="major" placeholder="主修" <?php isset($_POST['major']) ? print "value='" . $_POST['major'] . "'" : NULL ?> />
					<span class='required'>電話號碼:</span>
					<input type="text" name="phoneNumber" class="required" placeholder="電話號碼" <?php isset($_POST['phoneNumber']) ? print "value='" . $_POST['phoneNumber'] . "'" : NULL ?> />
					<span class='required'>帳號:</span>
					<input type="text" name="ID" class="required" placeholder="帳號(ID)" <?php isset($_POST['ID']) ? print "value='" . $_POST['ID'] . "'" : NULL ?> />
					<span class='required'>密碼:</span>
					<input type="password" name="password" class="required" placeholder="密碼(Password)" />
					<span class='required'>確認密碼:</span>
					<input type="password" name="rePassword" class="required" placeholder="確認密碼">

					<input type='submit' name='register' value='註冊' id='register'>
				</div>

				<p class="message">已經有帳號? <a href="#">登入</a></p>
			</form>
			<form class="loginForm" action='#' method='POST'>
				<input type="text" name='ID' placeholder='帳號(ID)' />

				<input type="password" name='password' placeholder='密碼(Password)' />
				<label>
					身分:
					<select name='identity'>
						<option selected='true' value='member'>會員</option>
						<option value='approver'>管理者</option>
					</select>
				</label>
				<input type='submit' name='login' value='登入' id='login'>
				<p class="message">沒有帳號? <a href="#">註冊</a></p>
			</form>
		</div>
	</div>


<?php elseif ($page_flag == 1) : ?>
	<?php
	header('Location: ../', true, 301);
	exit;
	?>
<?php endif; ?>

<?php
function validationForLogin($post)
{

	include_once $_SERVER['DOCUMENT_ROOT'] . '/core/readDB.php';

	// $conn = readDb("RentingDatabase");
	// if (!$conn) {
	// 	die("Connection failed: " . mysqli_connect_error());
	// }
	$id = $post["ID"];
	$password = $post["password"];
	$identity = $post["identity"];
	$error = array();
	if (empty($id)) {
		$error[] = "請輸入帳號。";
	} else {
		$sql = "SELECT * From " . $identity;
		$result = mysqlQuery($sql);
		for ($i = 1; $i <= mysqli_num_rows($result); $i++) {
			$rs = mysqli_fetch_row($result);
			if ($rs[0] == $id) {
				break;
			}
			if ($i == mysqli_num_rows($result)) {
				$error[] = "帳號不正確。";
			}
		}
	}
	if (empty($password)) {
		$error[] = "請輸入密碼。";
	}
	if (empty($error)) {

			$sql = "SELECT * From ".$identity;
			$result = mysqlQuery($sql);
			for ($i = 1; $i <= mysqli_num_rows($result); $i++) {
				$rs = mysqli_fetch_row($result);
				if ($rs[0] == $id and $rs[1] == $password) {
					$_SESSION['ID'] = $id;
					$_SESSION['Identity'] = $identity;
					$_SESSION['UserName'] = $rs[3] . $rs[2];

					return $error;
				}
			}
			$error[] = "密碼不正確。";
	}
	return $error;
}

function validationForRegister($post)
{

	include_once $_SERVER['DOCUMENT_ROOT'] . '/core/readDB.php';
	// $conn = readDb("RentingDatabase");
	// if (!$conn) {
	//     die("Connection failed: " . mysqli_connect_error());
	// }

	$error = array();

	$fName = $post["fName"];
	$lName = $post["lName"];
	$phoneNumber = $post["phoneNumber"];
	$id = $post["ID"];
	$password = $post["password"];
	$rePassword = $post["rePassword"];
	$major = $post["major"];
	$grade = $post["grade"];

	if ((empty($fName)) or (empty($lName))) {
		$error[] = "請輸入姓名。";
	}
	if (empty($phoneNumber)) {
		$error[] = "請輸入電話號碼。";
	}
	if (empty($id)) {
		$error[] = "請輸入帳號。";
	}
	if (empty($password)) {
		$error[] = "請輸入密碼。";
	}
	if ((!empty($password)) and (empty($rePassword))) {
		$error[] = "請確認密碼。";
	}
	if (empty($error)) {
		if ($password != $rePassword) {
			$error[] = "密碼不一致。";
		}
	}
	if (!empty($id)) {
		$sql = "SELECT * From member";

		$result = mysqlQuery($sql);
		foreach ($result as $row) {
			if ($row['mID'] == $id) {
				$error[] = "帳號無法使用。";
			}
		}
	}
	if ((!is_numeric($grade)) and (!empty($grade))) {
		$error[] = "年級請輸入數字。";
	}

	if (empty($error)) {
		$phoneNumber = !empty($phoneNumber) ? "'$phoneNumber'" : "NULL";
		$major = !empty($major) ? "'$major'" : "NULL";
		$grade = !empty($grade) ? "'$grade'" : "NULL";
		$sql = "INSERT INTO `member` (`mID`, `mpassword`, `fName`, `lName`, `mPhoneNumber`, `mMajor`, `mGrade`) VALUES ('$id', '$password', '$fName', '$lName', $phoneNumber, $major, $grade)";

		if (mysqlQuery($sql)) {
			echo "註冊成功!!";
			$_SESSION['ID'] = $id;
			$_SESSION['Identity'] = 'member';
			$_SESSION['UserName'] = $fName . $lName;
		} else {
			$error[] = "註冊失敗。";
		}
	}
	return $error;
}

?>


<script>
	$('.message a').click(function() {
		$('form').animate({
			height: "toggle",
			opacity: "toggle",
		}, "normal");

		// $('login-page').toggleClass();
		$(".login-page").toggleClass("register-page");

	});
</script>

<?php if (isset($_POST["register"])) : ?>
	<script>
		$('.login-page').toggleClass("register-page");
		$('.registerForm').toggle();
		$('.loginForm').toggle();
	</script>
<?php endif; ?>