<?php

function getApprovalTableWithButton(){

    $sql = "SELECT * FROM rental_agreement WHERE rApproval IS NULL ";

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
                    <th></th>
                    <th><form action='' method='POST'><input type = 'submit' name = 'approveAll' value='承認全部' id='approveAll'></form></th>
                </tr>";
    $count = 0;
    foreach ($result as $row) {
        $str = $str . "<tr>";
        $date = date('Y-m-d', strtotime($row['rDateTimeFrom']));
        $time = date('H:i', strtotime($row['rDateTimeFrom']));

        $priod = array_search($time, $priodsStart);

        //$str = $str . "<td>" . $row['rID'] . "</td>";  //審核編號
        $str = $str . "<td>" . $row['rAppricationDate'] . "</td>"; //申請日期
        ($row['cID'] == NULL) ? $str = $str . "<td>未選擇</td>" : $str = $str . "<td>" . $row['cID'] . "</td>"; //教室編號
        $str = $str . "<td>" . $date . "</td>"; //使用日期
        $str = $str . "<td>" . $priods[$priod] . "</td>"; //節次
        $str = $str . "<td>" . $priodsStart[$priod] . " - " . $priodsEnd[$priod] . "</td>"; //時間
        $str = $str . "<form action='' method='POST'>";
        $str = $str . "<td><input type = 'submit' name = 'reject' value='拒絕' id='reject'></td>";
        $str = $str . "<td><input type = 'submit' name = 'approve' value='承認' id='approve'></td>";
        $str = $str . "<input type='hidden' name='rID' value='" . $row['rID'] . "'>";
        $str = $str . "<input type='hidden' name='count' value='" . $count . "'>";
        $str = $str . "</form>";
        $str = $str . "</tr>";
        $count++;
    }
    $str = $str . "</tbody></table>";


    return $str;
}

function getApprovalTable(){
    
    $sql = "SELECT * FROM rental_agreement WHERE rApproval IS NULL ";

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
    $count = 0;
    foreach ($result as $row) {
        $str = $str . "<tr>";
        $date = date('Y-m-d', strtotime($row['rDateTimeFrom']));
        $time = date('H:i', strtotime($row['rDateTimeFrom']));

        $priod = array_search($time, $priodsStart);

        //$str = $str . "<td>" . $row['rID'] . "</td>";  //審核編號
        $str = $str . "<td>" . $row['rAppricationDate'] . "</td>"; //申請日期
        ($row['cID'] == NULL) ? $str = $str . "<td>未選擇</td>" : $str = $str . "<td>" . $row['cID'] . "</td>"; //教室編號
        $str = $str . "<td>" . $date . "</td>"; //使用日期
        $str = $str . "<td>" . $priods[$priod] . "</td>"; //節次
        $str = $str . "<td>" . $priodsStart[$priod] . " - " . $priodsEnd[$priod] . "</td>"; //時間
        $str = $str . "<form action='' method='POST'>";
        $str = $str . "</form>";
        $str = $str . "</tr>";
        $count++;
    }
    $str = $str . "</tbody></table>";


    return $str;

}
