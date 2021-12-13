<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/parts/head.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/core/readDB.php';

if (isset($_POST['approve'])) {

    $sql = "UPDATE rental_agreement SET rApproval = 1 , aID = '" . $_SESSION['ID'] . "',rApprovalDate = DATE(NOW()) WHERE rID = " . $_POST['rID'];
    if (mysqlQuery($sql)) {
        echo "承認成功!!<br>";
    } else {
        echo "重試";
    }
} else if (isset($_POST['reject'])) {
    $sql = "UPDATE rental_agreement SET rApproval = 0 , aID = '" . $_SESSION['ID'] . "',rApprovalDate = DATE(NOW()) WHERE rID = " . $_POST['rID'];
    if (mysqlQuery($sql)) {
        echo "拒絕成功!!<br>";
    } else {
        echo "重試";
    }
} else if (isset($_POST['approveAll'])) {
    $sql = "UPDATE rental_agreement SET rApproval = 1 , aID = '" . $_SESSION['ID'] . "',rApprovalDate = DATE(NOW()) WHERE rApproval IS NULL ";
    if (mysqlQuery($sql)) {
        echo "承認成功!!<br>";
    } else {
        echo "重試";
    }
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/parts/approvalInfoForApprover.php';
$approvalTable = getApprovalTableWithButton();

?>

<?php ($approvalTable)? print $approvalTable: print "目前沒有資料"?>
