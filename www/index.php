<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/parts/head.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/core/readDB.php';
?>

<?php
if (isset($_SESSION['ID'])) {
    if ($_SESSION['Identity'] == 'member') {
        include_once $_SERVER['DOCUMENT_ROOT'] . '/parts/approvalInfo.php';
        $approvedTable = getApprovedTable();
        $applicationTable  = getApplicationTable();
        $rejectedTable = getRejectedTable();
    } else if ($_SESSION['Identity'] == 'approver') {
        include_once $_SERVER['DOCUMENT_ROOT'] . '/parts/approvalInfoForApprover.php';
        $approvalTable = getApprovalTable();
    }
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
                            <?php echo "<a href=../login/ tite=modifiedPassword>登入</a>" ?>
                        <?php else : ?>
                            <?php echo "hi! " . $_SESSION['UserName'] . " " . $identitys[$_SESSION['Identity']] . ".&nbsp;"; ?>
                            <?php if ($_SESSION['Identity'] == 'member') : ?>
                                <?php echo "<a href=../account/ tite=modifiedPassword>修改會員資訊</a>" ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </p>
                </label>
                </form>
                <?php if (isset($_SESSION['ID'])) : ?>
                    <?php if ($_SESSION['Identity'] == 'member') : ?>
                        <?php if (isset($approvedTable) or isset($applicationTable)) : ?>
                            <?php ($rejectedTable) ? print "<h4><span>沒通過審核</span></h4>" . $rejectedTable : NULL ?>
                            <?php ($approvedTable) ? print "<h4><span>通過審核</span></h4>" . $approvedTable : NULL ?>
                            <?php ($applicationTable) ? print "<h4><span>待審核中</span></h4>" . $applicationTable : NULL ?>
                        <?php else : ?>
                            <?php echo "沒有審核中的資料!" ?>
                        <?php endif; ?>
                    <?php elseif ($_SESSION['Identity'] == 'approver') : ?>
                        <?php if (isset($approvalTable)) : ?>
                            <?php ($approvalTable) ? print "<h4><span>待審核中</span></h4>" .  $approvalTable : NULL ?>
                        <?php else : ?>
                            <?php echo "目前沒有需要審核的資料!" ?>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

        </div>
        <div class='searchBox'>
            <h3><span>教室查詢</span></h3>
            <div class='inner'>
                <?php
                include_once $_SERVER['DOCUMENT_ROOT'] . '/parts/searchForm.php';
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