<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once('./header.php');

include_once 'config.php';
global $weeks, $priods, $priodStarts, $priodEnds, $identitys;

include_once './readdb_php.php';
?>

<?php
include('./approvalinfo.php');
if (isset($_SESSION['ID'])) {
    $approvedTable = getApprovedTable();
    $applicationTable  = getApplicationTable();
}

$notes = "";

$sql = "SELECT * FROM notes";
$result = mysqlQuery($sql);
foreach ($result as $row) {
    $notes = $notes . "<p>(" . $row['nID'] . ") " . $row['nDescription'] . "</p>";
}


?>


<div class='flexbox'>
    <div class='leftBox'>
        <div class='infoBox'>
            <h3><span>會員資訊</span></h3>
            <div class='inner'>
                <label class='memberInfo'>
                    <p>
                        <?php if (!isset($_SESSION['ID'])) : ?>
                            <?php echo "hi! 訪客 .&nbsp;"; ?>
                            <?php echo "<a href=login.php tite=modifiedPassword>登入</a>" ?>
                        <?php else : ?>
                            <?php echo "hi! " . $_SESSION['UserName'] . " " . $identitys[$_SESSION['Identity']] . ".&nbsp;"; ?>
                            <?php echo "<a href=modifyAccount.php tite=modifiedPassword>修改會員資訊</a>" ?>
                        <?php endif; ?>
                    </p>
                </label>
                </form>
                <?php if (!isset($_SESSION['ID'])) : ?>
                    <?php ?>
                <?php elseif (isset($approvedTable) or isset($applicationTable)) : ?>
                    <?php ($approvedTable) ? print "<h4><span>審核通過</span></h4>" . $approvedTable : NULL ?>
                    <?php ($applicationTable) ? print "<h4><span>審核中</span></h4>" . $applicationTable : NULL ?>
                <?php else : ?>
                    <?php echo "沒有審核中的資料!" ?>
                <?php endif; ?>
            </div>
        </div>
        <div class='searchBox'>
            <h3><span>教室查詢</span></h3>
            <div class='inner'>
                <?php
                include_once './searchForm.php';
                $searchForm = getSearchForm(isset($_POST['classroom']) ? $_POST['classroom'] : NULL, isset($_POST['date']) ? $_POST['date'] : NULL);
                echo $searchForm;
                ?>
            </div>
        </div>
    </div>
    <div class='rightBox'>
        <div class='noteBox'>
            <h3><span>附註</span></h3>
            <div class='inner'>
                <?php echo $notes; ?>
            </div>
        </div>
    </div>
</div>


<style type="text/css">
    .memberInfo {}

    .table {

        width: 90%;
        border-collapse: collapse;
        margin: 20px auto;
        font-size: 15px;
        border: 5px #3D4247 solid;
        /* box-shadow: 0 0 20px gray; */

    }

    .table th {

        text-align: center;
        background-color: #3D4247;
        color: #ffffff;
        padding: 5px 0;
        font-weight: normal;

    }

    .table td {
        text-align: center;
        color: black;
        padding: 5px 0;

    }

    .table tr {
        background: #ffffff;
    }

    .table tr:nth-child(odd) {
        background: #f8f8f8;
    }

    .flexbox {
        padding: 20px 0;
        display: flex;
        flex-direction: row;

        height: 85vh;
    }

    .flexbox>.leftBox {
        padding: 0 0;
        display: flex;
        flex: 3;
        margin-left: 5%;
        margin-right: 2vh;
        flex-direction: column-reverse;

        height: 100%;


    }

    .flexbox>.leftBox>.infoBox {
        margin-top: 2vh;
        flex: 5;
    }

    .flexbox>.leftBox>.searchBox {
        margin-bottom: 2vh;
        flex: 1;
    }

    .flexbox>.rightBox {
        flex: 1;
        margin-right: 5%;
        margin-left: 2vh;
    }


    .infoBox,
    .searchBox,
    .rightBox {
        border-collapse: collapse;
        box-shadow: 0 0 20px gray;
        border-radius: 5px;
        border: 5px #3D4247 solid;
        background: #ffffff;

    }

    .infoBox,
    .rightBox {
        overflow: auto;
    }



    .infoBox .inner,
    .searchBox .inner,
    .noteBox .inner {

        padding: 0.2em 2em;
    }


    .infoBox .inner h4 {
        font-size: 18px;
        padding-bottom: .5em;
        border-bottom: 1px solid #ccc;
    }

    .infoBox h3,
    .searchBox h3,
    .noteBox h3 {
        font-size: 22px;
        position: relative;
        padding: 0 1em;
        border-bottom: 1px solid #ccc;
        width: 94%;
    }

    .noteBox h3 {
        width: 80%;
    }

    .infoBox h3::after,
    .searchBox h3::after,
    .noteBox h3::after {
        position: absolute;
        bottom: -2px;
        left: 0;
        z-index: 2;
        content: '';
        width: 12%;
        height: 3px;
        background-color: #333;
    }

    .noteBox h3::after {
        width: 30%;
    }
</style>