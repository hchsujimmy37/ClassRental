<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/parts/head.php';

$account = getAccountInfo($_SESSION['ID']);

$page_flag = 0;
?>

<?php if (isset($_POST["modify"])) : ?>
    <!-- 利用POST(送出按鈕)來的  -->
    <?php

    $account['password'] = $_POST['password'] ?: $account['password'];
    $account['fName'] = $_POST['fName'] ?: $account['fName'];
    $account['lName'] = $_POST['lName'] ?: $account['lName'];
    $account['phoneNumber'] =  $_POST['phoneNumber'] ?: $account['phoneNumber'];
    $account['major'] = $_POST['major'];
    $account['grade'] = $_POST['grade'];


    foreach (array_keys($_POST) as $key) {
        $post[$key] = $_POST[$key];
    }
    $error = validation($post); //檢查
    if (empty($error)) {
        $page_flag = 1;
    }
    ?>
<?php elseif (isset($_POST["remove"])) : ?>
    <?php
    $page_flag = 2;
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


    <div class="account-page">
        <div class="entryForm">
            <form class="modifyForm" action='' method='POST'>
                <div class='grid'>
                    <span class='lName required'>姓:</span>
                    <input type="text" name="lName" class="" placeholder="姓" <?php echo "value='" . $account['lName'] . "'" ?> />

                    <span class='fName required'>名:</span>
                    <input type="text" name="fName" class="" placeholder="名" <?php echo "value='" . $account['fName'] . "'" ?> /></dd>

                    <span class='grade'>年級:</span>
                    <input type="number" name="grade" class="" min='1' placeholder="年級" <?php echo "value='" . $account['grade'] . "'" ?> />

                    <span class='major'>主修:</span>
                    <input type="text" name="major" placeholder="主修" <?php echo "value='" . $account['major'] . "'" ?> />

                    <span class='required'>電話號碼:</span>
                    <input type="text" name="phoneNumber" class="required" placeholder="電話號碼" <?php echo "value='" . $account['phoneNumber'] . "'" ?> />

                    <span class='required'>帳號:</span>
                    <input type="text" name="ID" class="required" placeholder="帳號(ID)" <?php echo "value='" . $account['ID'] . "'" ?> disabled="disabled" />

                    <span class='required'>密碼:</span>
                    <input type="password" name="password" class="required" placeholder="密碼" <?php echo "value='" . $account['password'] . "'" ?> />

                    <span class='required'>確認密碼:</span>
                    <input type="password" name="rePassword" class="required" placeholder="確認密碼">
                    <input type="submit" name="reset" value="重置" id="reset">
                    <input type="submit" name="modify" value="送出" id="modify">

                </div>
            </form>
            <hr>
            <form class="removeAccount" action='' method='POST'>
                <input type="submit" name="remove" value="刪除帳號" id="remove">
            </form>
        </div>

    </div>

<?php elseif ($page_flag == 1) : ?>
    <?php
    header("refresh:1;url='../'");
    exit;
    ?>

<?php elseif ($page_flag == 2) : ?>
    <?php
    header('Location: ./removeAccount.php', true, 301);
    exit;
    ?>
<?php endif; ?>


<?php function validation($post)
{

    include_once $_SERVER['DOCUMENT_ROOT'] . '/core/readDB.php';

    $error = array();

    $fName = $post["fName"];
    $lName = $post["lName"];
    $phoneNumber = $post["phoneNumber"];
    $id = $_SESSION["ID"];
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
    if ((!is_numeric($grade)) and (!empty($grade))) {
        $error[] = "年級請輸入數字。";
    }
    if (!is_numeric($phoneNumber)) {
        $error[] = "電話號碼請輸入數字。";
    }

    if (empty($error)) {
        $phoneNumber = !empty($phoneNumber) ? "'$phoneNumber'" : "NULL";
        $major = !empty($major) ? "'$major'" : "NULL";
        $grade = !empty($grade) ? "'$grade'" : "NULL";
        //$sql = "UPDATE `member` SET (`mID`, `mpassword`, `fName`, `lName`, `mPhoneNumber`, `mMajor`, `mGrade`) VALUES ('$id', '$password', '$fName', '$lName', $phoneNumber, $major, $grade)";
        $sql = "UPDATE `member` SET `mpassword` = '$password', `fName` = '$fName', `lName` = '$lName', `mPhoneNumber` = $phoneNumber, `mMajor` = $major, `mGrade` = $grade WHERE `mID` ='$id' ";
        // mysqli_query($conn, "SET NAMES 'utf8'");
        if (mysqlQuery($sql)) {
            echo "修改成功!!";
            $_SESSION['ID'] = $id;
            $_SESSION['Identity'] = 'member';
            $_SESSION['UserName'] = $fName . $lName;
        } else {
            $error[] = "失敗。";
        }
    }
    return $error;
} ?>

<?php function getAccountInfo($ID)
{
    include_once $_SERVER['DOCUMENT_ROOT'] . '/core/readDB.php';
    $sql = "SELECT * FROM member WHERE mID = '" . $ID . "'";
    $result = mysqlQuery($sql);
    $rs = mysqli_fetch_row($result);

    $account = [
        'ID'     => $rs[0],
        'password' => $rs[1],
        'fName' => $rs[2],
        'lName' => $rs[3],
        'phoneNumber' => $rs[4],
        'major' => $rs[5],
        'grade' => $rs[6],
    ];

    return $account;
} ?>