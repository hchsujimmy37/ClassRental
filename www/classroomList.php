<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/parts/head.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/core/readDB.php';
$sql = "SELECT * FROM classroom";
$result = mysqlQuery($sql);
?>


<table class='table'>
    <thead>
        <tr>
            <th>教室編號</th>
            <th>教室名稱</th>
            <th>教室容量</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($rs = mysqli_fetch_row($result)) {
            echo "<tr>";

            echo "<td>" . $rs[0] . "</td>";
            echo "<td>" . $rs[1] . "</td>";
            echo "<td>" . $rs[2] . "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>