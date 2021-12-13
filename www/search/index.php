<?php
//顯示browser cash  防止ERR_CACHE_MISS
header('Expires:-1');
header('Cache-Control:');
header('Pragma:');

include_once $_SERVER['DOCUMENT_ROOT'] . '/parts/head.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/core/readDB.php';

$page_flag = 0;

if ((isset($_POST["date"]) and $_POST["classroom"] != "NULL")) {
    $date = strtotime(date($_POST['date'] . " 00:00:00"));
    //echo date('Y年n月j日', strtotime("+0 day", $date));
    $aWeekState = getOneWeekState($_POST['date'], $_POST['classroom']); //0:可以預約 1:審核中 2:無法使用 以0初始化
}

?>


<?php if ((isset($_POST["search"])) or (isset($_POST["return"]))) : ?>
    <!-- 利用POST(登入按鈕)來的  -->

    <?php

    foreach (array_keys($_POST) as $key) {
        $post[$key] = $_POST[$key];
    }
    $error = validationForSearch($post); //檢查

    if (!empty($error)) {
        $page_flag = 0;  //沒選擇教室
    } else {
        $page_flag = 1; //有選擇教室
    }
    ?>


<?php elseif (isset($_POST["rental"])) : ?>

    <?php

    foreach (array_keys($_POST) as $key) {
        $post[$key] = $_POST[$key];
    }
    $error = validationForRental($post); //檢查

    if (!empty($error)) {
        $page_flag = 1;
    } else {
        $page_flag = 2;
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

<?php if (($page_flag == 0) or ($page_flag == 1)) : ?>

    <?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/parts/searchForm.php';
    $searchForm = getSearchForm( isset($_POST['classroom']) ? $_POST['classroom']: NULL, isset($_POST['date']) ? $_POST['date']: NULL);
    echo $searchForm;
    ?>

<?php endif; ?>

<?php if ($page_flag == 1) : ?>

    <form action="" method="POST">

        <table class='table'>
            <tr>
                <th>節次/星期 </th>
                <?php
                for ($i = 0; $i < 7; $i++) {
                    echo "<th>" . date('Y年m月d日', strtotime("+$i day", $date)) . "<br>星期" . $weeks[date('w', strtotime("+$i day", $date))] . "</th>";
                }
                ?>

            </tr>
            <?php
            for ($i = 0; $i < 15; $i++) {
                echo "<tr>";
                echo "<td>" . $priods[$i] . "<br>" . $priodsStart[$i] . " - " . $priodsEnd[$i] . "</td>";
                for ($j = 0; $j < 7; $j++) {
                    echo "<td>";
                    switch ($aWeekState[$j][$i]) {
                        case '0':
                            if ((isset($_SESSION['Identity'])) and ($_SESSION['Identity'] == 'member')) {
                                echo "<label class='empty checkBox'><input type='checkbox' name='applications[]' value='" . date('Y-m-d', strtotime("+$j day", $date)) . "_$i'>申請</label>";
                            } else {
                                echo "<label class='empty'>可申請<label>";
                            }
                            break;
                        case '1':
                            echo "<label class='review'>審核中<label>";
                            break;
                        case '2':
                            echo "<label class='disabled'>無法使用<label>";
                            break;
                    }
                    echo "</td>";
                }
                echo "</tr>";
            }
            ?>
            <tr>
                <?php for ($i = 0; $i < 7; $i++) {
                    echo "<th></th>";
                } ?>
                <th>
                    <input type='hidden' name='classroom' value="<?php echo $_POST['classroom']; ?>">
                    <input type='hidden' name='date' value="<?php echo $_POST['date']; ?>">

                    <?php
                    if ((isset($_SESSION['Identity'])) and ($_SESSION['Identity'] == 'member')) {
                        echo "<input type='submit' name='rental' value='送出' id='submit'>";
                    } else {
                        // echo "<input type='submit' name='rental' value='送出' id='button' disabled='disabled'>";
                    }
                    ?>
                </th>
            </tr>
        </table>

    </form>

<?php elseif ($page_flag == 2) : ?>
    <?php echo "資料確認中..." ?>

    <body onLoad="document.rental.submit();">
        <form action="rentalForm.php" method="post" name="rental">
            <?php
            foreach ($_POST['applications'] as $application) {
                echo "<input type='hidden' name='applications[]' value='" . $application . "'>";
            }
            ?>
            <input type='hidden' name='classroom' value="<?php echo $_POST['classroom']; ?>">
            <input type='hidden' name='date' value="<?php echo $_POST['date']; ?>">
        </form>
    </body>

<?php endif; ?>



<?php function validationForSearch($post)
{
    $error = array();

    $classroom = $post["classroom"];

    if (empty($classroom)) {
        $error[] = "請選擇教室。";
    }

    return $error;
} ?>

<?php function validationForRental($post)
{
    $error = array();
    $isApplication = isset($post["applications"]) ?: NULL;

    if (is_null($isApplication)) {
        $error[] = "請選擇至少一項選項。";
        echo $isApplication;
    }
    return $error;
} ?>

<?php function getOneWeekState($date, $classroom) //date ->UNIX TIME
{

    include_once $_SERVER['DOCUMENT_ROOT'] . '/core/config.php';
    global $weeks, $priods, $priodsStart, $priodsEnd, $identitys;
    include_once $_SERVER['DOCUMENT_ROOT'] . '/core/readDB.php';

    $dateBigining = strtotime("+0 week", strtotime($date . " 00:00:00"));
    $dateAWeekAfter = strtotime("+1 week", strtotime($date . " 00:00:00"));


    $array = array_fill(0, 7, array_fill(0, 15, 0)); //0:可以預約 1:審核中 2:無法使用 以0初始化


    $sql = "SELECT rDateTimeFrom,rDateTimeTo,rApproval From Rental_Agreement WHERE cID = '" . $classroom . "'";
    $result = mysqlQuery($sql);

    while ($row = mysqli_fetch_row($result)) {
        $rowDateTimeFrom = strtotime($row[0]);
        $rowDateTimeTo = strtotime($row[1]);
        if (($dateBigining <= $rowDateTimeTo and $rowDateTimeFrom <= $dateAWeekAfter)) { //如果在索引日期的一周以內
            for ($j = 0; $j < 7; $j++) {
                for ($k = 0; $k < 15; $k++) {
                    $dateTimeFrom = strtotime("+$j day", strtotime(date($date . " " . $priodsStart[$k] . ":00")));  //UNIX time 
                    $dateTimeTo   = strtotime("+$j day", strtotime(date($date . " " . $priodsEnd[$k] . ":00")));
                    if (($dateTimeFrom <= $rowDateTimeTo and $rowDateTimeFrom <= $dateTimeTo)) {
                        $array[$j][$k] = isset($row[2]) ? 2 : 1;
                    }
                }
            }
        }
    }
    return $array;
} ?>

<? function getWeekBeginning($ymd)
{
    $w = date("w", strTime($ymd));
    $beginningDate = 　date('Y-m-d', strTime("-{$w} day", strTime($ymd)));
    return $beginningDate;
} ?>


<style type="text/css">

.table td {
    text-align: center;
    color: black;
    padding: 1px 0;

}
</style>
