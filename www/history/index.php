<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/parts/head.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/core/readDB.php';

$sql = "SELECT * FROM rental_agreement WHERE mID ='" . $_SESSION['ID'] . "'";
$result = mysqlQuery($sql);

?>

<?php if (!isset($_SESSION['ID'])) : ?>
    <!-- SESSION中有ID -->

    <?php header('Location: ./Login/', true, 301); ?>
<?php endif; ?>

<table class='table'>
    <tbody>
        <tr>
            <th>審核編號</th>
            <th>申請日期</th>
            <th>教室編號</th>
            <th>使用日期</th>
            <th>節次</th>
            <th>時間</th>
            <th>審核結果</th>
        </tr>
        <?php

        foreach ($result as $row) {
            echo "<tr>";

            // $row['rID']; //0
            // $row['mID']; //1
            // $row['cID']; //2
            // $row['rAppricationDate']; //3
            // $row['rDateTimeFrom']; //4
            // $row['rDateTimeTo']; //5
            // $row['aID']; //6
            // $row['rApproval']; //7
            // $row['rApprovalDate']; //8

            $date = date('Y-m-d', strtotime($row['rDateTimeFrom']));
            $time = date('H:i', strtotime($row['rDateTimeFrom']));

            $priod = array_search($time, $priodsStart);

            //echo date('Y年n月j日', strtotime("+0 day", $date));

            echo "<td>" . $row['rID'] . "</td>";  //審核編號
            echo "<td>" . $row['rAppricationDate'] . "</td>"; //申請日期
            ($row['cID'] == NULL) ? print "<td>未選擇</td>" : print "<td>" . $row['cID'] . "</td>"; //教室編號
            echo "<td>" . $date . "</td>"; //使用日期

            echo "<td>" . $priods[$priod] . "</td>"; //節次
            echo "<td>" . $priodsStart[$priod] . "</td>"; //時間
            // echo "<td>" .  $row['rDateTimeFrom'] . "</td><td>" . $row['rDateTimeTo'] . "</td>";
            if ($row['rApproval'] == NULL) {
                echo "<td>未到</td>";
            } else if ($row['rApproval'] == 1) {
                echo "<td>通過</td>";
            }

            echo "</tr>";
        }

        ?>
    </tbody>
</table>