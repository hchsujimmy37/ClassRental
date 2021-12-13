<?php
session_start();
include('./header.php');
$page_flag = 0;
?>

<?php if (isset($_SESSION['ID'])) : ?>
    <!-- SESSION中有ID -->

    <?php header('Location: ./main.php', true, 301); ?>


<?php elseif (isset($_POST["submit"])) : ?>
    <!-- 利用POST(註冊按鈕)來的  -->

    <?php
    foreach (array_keys($_POST) as $key) {
        $post[$key] = $_POST[$key];
    }
    $error = validation($post); //檢查
    if (empty($error)) {
        $page_flag = 1;
    }
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


    <html>

    <head>
        <title>註冊</title>
    </head>
    <div id="register">

        <body>
            <form action="" method="POST">
                <label class="required">姓:</label>
                <input type="fName" name="fName">

                <label class="required">名:</label>
                <input type="lName" name="lName"><br>

                年級:
                <input type="grade" name="grade">
                主修:
                <input type="major" name="major"><br>

                <label class="required">電話號碼:</label><br>
                <input type="phoneNumber" name="phoneNumber"><br>
                <hr>
                <label class="required">帳號:</label>
                <input type="ID" name="ID"><br>

                <label class="required">密碼:</label><br>
                <input type="password" name="password"><br>

                <label class="required">確認密碼:</label><br>
                <input type="password" name="rePassword">
                <input type="submit" name="submit" value="送出" id="submit">
            </form>



        </body>

    </html>
<?php elseif ($page_flag == 1) : ?>
    <?php
    header("refresh:1;url='./main.php'"); 
    exit;
    ?>
<?php endif; ?>

<?php
function validation($post)
{

    include_once "readdb_php.php";
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
        for ($i = 1; $i <= mysqli_num_rows($result); $i++) {
            $rs = mysqli_fetch_row($result);
            if ($rs['0'] == $id) {
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



<style type="text/css" media="screen">
    body {

        color: #ffffff;
        margin: 0;
    }

    #register p {
        font-size: 86%;
        margin: 0px auto;
        color: #808080;
    }

    #register {

        margin: 50px auto;
        width: 320px;
    }

    #register form {
        margin: auto;
        border: 100px;
        padding: 22px 22px 22px 22px;
        width: 100%;
        border-radius: 10px;
        background: #282e33;
        border-top: 3px solid #434a52;
        border-bottom: 3px solid #434a52;
    }

    #register form span {
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

    #register form input {

        border-radius: 0px 3px 3px 0px;
        font-size: inherit;
        color: #000000;
        margin-bottom: 1em;
        padding: 0 16px;
        width: 285px;
        height: 25px;
        border-radius: 5px;
    }

    #register form input[type="fName"] {

        width: 75px;
        margin-bottom: 2em;
    }

    #register form input[type="lName"] {

        width: 75px;
        margin-bottom: 2em;
    }

    #register form input[type="major"] {
        width: 75px;
        margin-bottom: 1em;
    }

    #register form input[type="grade"] {
        width: 75px;
        margin-bottom: 1em;
    }

    #register form input[type="phoneNumber"] {
        margin-bottom: 1em;
    }

    #register form #submit {
        margin: 10px auto;
        background: #8cae47;
        width: 100%;
        height: 40px;
        border-radius: 5px;
        color: white;
        cursor: pointer;
    }

    #register form #register {
        margin: 10px auto;
        background: #808080;
        width: 100%;
        height: 40px;
        border-radius: 5px;
        color: white;
        cursor: pointer;
    }

    #register form #register:hover {

        background: #478cae;
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