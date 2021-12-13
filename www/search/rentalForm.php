<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/parts/head.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/core/readDB.php';

$sql = "SELECT * FROM member WHERE mID = '" . $_SESSION['ID'] . "'";
$result = mysqlQuery($sql);
foreach ($result as $row) {
    $memberInfo = $row;
}

// $mID = $rs[0];
// $mpassword = $rs[1];
// $fName = $rs[2];
// $lName = $rs[3];
// $mPhoneNumber = $rs[4];
// $mMajor = $rs[5];
// $mGrade = $rs[6];

$sql = "SELECT * FROM classroom WHERE cID = '" . $_POST['classroom'] . "'";
$result = mysqlQuery($sql);
foreach ($result as $row) {
    $classroomInfo = $row;
}

// cID = $rs[0];
// cName = $rs[1];
// cCapacity = $rs[2];
// cPrice = $rs[3];

?>

<div id="rentalForm">
    <form action="./rentalRequest.php" method="POST">
        <table class='horizontalTable'>

            <caption>教室申請表單</caption>
            <tr>
                <th>身分</th>
                <td><?php echo $identitys[$_SESSION['Identity']]; ?></td>
            </tr>
            <tr>
                <th>姓名</th>
                <td><?php echo $_SESSION['UserName']; ?></td>
            </tr>
            <tr>
                <th>帳號</th>
                <td><?php echo $_SESSION['ID']; ?></td>
            </tr>
            <tr>
                <th>電話號碼</th>
                <td><?php echo $memberInfo['mPhoneNumber']; ?></td>
            </tr>
            <tr>
                <th>教室編號</th>
                <td><?php echo $classroomInfo['cID']; ?></td>
            </tr>
            <tr>
                <th>教室名稱</th>
                <td><?php echo $classroomInfo['cName']; ?></td>
            </tr>
            <tr>
                <th>使用時間</th>
                <td>
                    <table class='innerTable'>
                        <tr>
                            <th>日期</th>
                            <th>時間</th>
                            <th>節次</th>
                        </tr>

                        <?php
                        foreach ($_POST['applications'] as $datePriod) {
                            $applications[] = explode('_', $datePriod,);
                        }

                        asort($applications); //排序

                        foreach ($applications as $application) {
                            echo "<tr>";
                            echo "<td>" . $application[0] . "</td>";
                            echo "<td>" . $priodsStart[$application[1]] . " - " . $priodsEnd[$application[1]] . "</td>";
                            echo "<td>" . $priods[$application[1]] . "</td>";
                            echo "</tr>";
                        }
                        ?>

                    </table>
                </td>
            </tr>
            <tr>
                <th>選擇設備</th>
                <td>
                    <?php
                    $sql = "SELECT * From equipment";
                    $result = mysqlQuery($sql);
                    foreach ($result as $row) {
                        echo "<label class='checkBox'><input type=\"checkbox\" name=\"equipment[]\" value=\"" . $row['eID'] . "\">" . $row['eName'] . "</label>";
                    }
                    ?>
                </td>
            </tr>
        </table>
        <table class='verticalTable'>
            <tr>
                <th>注意事項</th>
            </tr>
            <tr>
                <td>
                    <?php
                    $precautions = "";
                    $sql = "SELECT * FROM precautions";
                    $result = mysqlQuery($sql);
                    foreach ($result as $row) {
                        $precautions = $precautions . "<p>(" . $row['pID'] . ") " . $row['pDescription'] . "</p>";
                    }
                    echo $precautions;
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    <label class='checkBox2'><input type='checkbox' name='agree' value='' required='required'>我已閱讀並同意會員約定條款說明</label>
                </td>
            </tr>
        </table>

        <?php
        foreach ($_POST['applications'] as $datePriod) {
            echo "<input type='hidden' name='applications[]' value='" . $datePriod . "'>";
        }
        ?>
        <input type='hidden' name='classroom' value='<?php echo $_POST['classroom'] ?>'>
        <input type="submit" name="submit" value="送出" id="submit">
    </form>
    <form action="../search/" method="POST">
        <input type='hidden' name='date' value='<?php echo $_POST['date'] ?>'>
        <input type='hidden' name='classroom' value='<?php echo $_POST['classroom'] ?>'>
        <input type="submit" name="return" value="返回" id="return">
    </form>
</div>
