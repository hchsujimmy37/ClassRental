

<?php
$pageTtl = '教室查詢系統';
?>

<head>
    <?php /* title */ ?>
    <title><?php echo htmlspecialchars($pageTtl, ENT_QUOTES | ENT_HTML5, 'UTF-8'); ?></title>
    <?php /* CSS */ ?>
    <link rel="stylesheet" href="../css/style.css">
    <?php /* js */ ?>
    <!-- <script src="js/.js"></script> -->
</head>

<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
include_once $_SERVER['DOCUMENT_ROOT'] . '/parts/header.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/core/config.php';
global $weeks, $priods, $priodsStart, $priodsEnd, $identitys;
?>