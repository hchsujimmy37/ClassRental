<?php function getSearchForm($classroom, $date)
{
    include_once $_SERVER['DOCUMENT_ROOT'] . '/core/readDB.php';

    $date = (isset($date)) ? $date : date('Y-m-d');
    $str = "<form action='../search/' method='POST' class='searchForm'>";
    $str = $str . " <span>選擇教室:</span>";
    $str = $str . "<select name='classroom' class='classroom'>
                    <option value='0'>請選擇教室</option>";

    $sql = "SELECT * From classroom";
    $result = mysqlQuery($sql);

    foreach ($result as $row) {
        $str = $str . "<option value='" . $row['cID'] . "'";
        if (isset($classroom) and $classroom == $row['cID']) {
            $str = $str . " selected = 'selected'";
        }
        $str = $str . ">" . $row['cName'] . "</option>";
    }
    $str = $str . "</select>";
    $str = $str . "<span>選擇時間:</span>";
    $str = $str . "<label>
                    <input type='date' name='date' min='" . date('Y-m-d') . "' value='" . $date . "'>
                   </label>
                    <input type='submit' name='search' value='查詢' id='search'>";
    $str = $str . "</form>";

    return $str;
} ?>
