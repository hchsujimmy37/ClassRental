<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once $_SERVER['DOCUMENT_ROOT'] . '/parts/header.php';

include_once $_SERVER['DOCUMENT_ROOT'] . '/core/readDB.php';
$sql = "SELECT * FROM member WHERE mID = '" . $_SESSION['ID'] . "'";
$result = mysqlQuery($sql);

$rs = mysqli_fetch_row($result);
$id = $rs[0];
$password = $rs[1];
$fName = $rs[2];
$lName = $rs[3];
$phoneNumber = $rs[4];
$major = $rs[5];
$grade = $rs[6];

$page_flag = 0;

?>

<?php if (isset($_POST["submit"])) : ?>
    <!-- 利用POST(送出按鈕)來的  -->

    <?php
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
    <ul class="error_list">
        <?php foreach ($error as $value) : ?>
            <li><?php echo $value; ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if ($page_flag == 0) : ?>


    <div id="modify">

        <body>
            <form action="" method="POST">
                <label class="required">姓:</label>
                <input type="fName" name="fName" <?php echo "value=\"" . $lName . "\"" ?>>

                <label class="required">名:</label>
                <input type="lName" name="lName" <?php echo "value=\"" . $fName . "\"" ?>><br>

                年級:
                <input type="grade" name="grade" <?php echo "value=\"" . $grade . "\"" ?>>
                主修:
                <input type="major" name="major" <?php echo "value=\"" . $major . "\"" ?>><br>

                <label class="required">電話號碼:</label><br>
                <input type="phoneNumber" name="phoneNumber" <?php echo "value=\"" . $phoneNumber . "\"" ?>><br>
                <hr>
                <label class="required">帳號:</label>
                <input type="ID" name="ID" <?php echo "value=\"" . $id . "\"" ?> disabled="disabled"><br>

                <label class="required">密碼:</label><br>
                <input type="password" name="password" <?php echo "value=\"" . $password . "\"" ?>><br>

                <label class="required">確認密碼:</label><br>
                <input type="rePassword" name="rePassword">

                <input type="submit" name="submit" value="送出" id="submit">
                <input type="submit" name="remove" value="刪除帳號" id="remove">
            </form>



        </body>

    </html>

<?php elseif ($page_flag == 1) : ?>
    <?php
    header("refresh:1;url='./main.php'");
    exit;
    ?>

<?php elseif ($page_flag == 2) : ?>
    <?php
    header('Location: ./removeAccount.php', true, 301);
    exit;
    ?>
<?php endif; ?>


<?php
function validation($post)
{

    include_once "readdb_php.php";

    $error = array();

    $fName = $post["fName"];
    $lName = $post["lName"];
    $phoneNumber = $post["phoneNumber"];
    $id = $_SESSION["ID"]; //
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
}

?>



<style type="text/css" media="screen">
    body {

        color: #ffffff;
        margin: 0;
    }

    #modify p {
        font-size: 86%;
        margin: 0px auto;
        color: #808080;
    }

    #modify {

        margin: 50px auto;
        width: 320px;
    }

    #modify form {
        margin: auto;
        border: 100px;
        padding: 22px 22px 22px 22px;
        width: 100%;
        border-radius: 10px;
        background: #282e33;
        border-top: 3px solid #434a52;
        border-bottom: 3px solid #434a52;
    }

    #modify form span {
        background-color: #363b41;
        border-radius: 3px 0px 0px 3px;
        border-right: 3px solid #434a52;
        color: #606468;
        display: block;
        float: left;
        line-height: 50px;
        text-align: center;
        width: 50px;
        height: 50px;
    }

    .required:after {
        content: " *";
        color: #ff2e5a;
    }

    #modify form input {

        border-radius: 0px 3px 3px 0px;
        font-size: inherit;
        color: #000000;
        margin-bottom: 1em;
        padding: 0 16px;
        width: 285px;
        height: 25px;
        border-radius: 5px;
    }

    #modify form input[type="fName"] {

        width: 75px;
        margin-bottom: 2em;
    }

    #modify form input[type="lName"] {

        width: 75px;
        margin-bottom: 2em;
    }

    #modify form input[type="major"] {
        width: 75px;
        margin-bottom: 1em;
    }

    #modify form input[type="grade"] {
        width: 75px;
        margin-bottom: 1em;
    }

    #modify form input[type="phoneNumber"] {
        margin-bottom: 1em;
    }

    #modify form #submit {
        margin: 10px auto;
        background: #8cae47;
        width: 100%;
        height: 40px;
        border-radius: 5px;
        color: white;
        cursor: pointer;
    }

    #modify form #remove {
        margin: 10px auto;
        background: #808080;
        width: 100%;
        height: 40px;
        border-radius: 5px;
        color: white;
        cursor: pointer;
    }

    #modify form #remove:hover {

        background: #DE4830;
    }

    .error_list {
        background: #fff0f3;
        width: 100%;
        margin: 0px auto;
        padding: 10px 30px;
        color: #ff2e5a;
        font-size: 86%;
        border: 1px solid #ff2e5a;
        position: absolute;
        bottom: 0;
    }
</style>