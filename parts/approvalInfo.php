<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/core/config.php';
global $weeks, $priods, $priodsStart, $priodsEnd, $identitys;

function getApplicationTable()
{
    $sql = "SELECT * FROM rental_agreement WHERE mID ='" . $_SESSION['ID'] . "' AND rDateTimeTo > DATE(NOW()) AND rApproval IS NULL";
    return getTable($sql);
}
function getApprovedTable()
{
    $sql = "SELECT * FROM rental_agreement WHERE mID ='" . $_SESSION['ID'] . "' AND rDateTimeTo > DATE(NOW()) AND rApproval = 1";
    return getTable($sql);
}

function getRejectedTable()
{
    $sql = "SELECT * FROM rental_agreement WHERE mID ='" . $_SESSION['ID'] . "' AND rDateTimeTo > DATE(NOW()) AND rApproval = 2";
    return getTable($sql);
}

function getTable($sql)
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    include_once $_SERVER['DOCUMENT_ROOT'] . '/core/config.php';
    global $weeks, $priods, $priodsStart, $priodsEnd, $identitys;
    
    include_once $_SERVER['DOCUMENT_ROOT'] . '/core/readDB.php';
    $result = mysqlQuery($sql);

    if (mysqli_num_rows($result) == 0) return NULL;
    //<th>審核編號</th>
    //<th>審核結果</th>
    $str = "<table class='table'>
            <tbody>
                <tr>
                    <th>申請日期</th>
                    <th>教室編號</th>
                    <th>使用日期</th>
                    <th>節次</th>
                    <th>時間</th>    
                </tr>";

    foreach ($result as $row) {
        $str = $str . "<tr>";

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

        //$str = $str . "<td>" . $row['rID'] . "</td>";  //審核編號
        $str = $str . "<td>" . $row['rAppricationDate'] . "</td>"; //申請日期
        ($row['cID'] == NULL) ? $str = $str . "<td>未選擇</td>" : $str = $str . "<td>" . $row['cID'] . "</td>"; //教室編號
        $str = $str . "<td>" . $date . "</td>"; //使用日期
        $str = $str . "<td>" . $priods[$priod] . "</td>"; //節次
        $str = $str . "<td>" . $priodsStart[$priod] ." - ".$priodsEnd[$priod]."</td>"; //時間
        $str = $str . "</tr>";
    }
    $str = $str . "</tbody></table>";

    return $str;
};


