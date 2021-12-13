<?php
date_default_timezone_set('Asia/Taipei');
?>

<?php if (isset($_SESSION['ID'])) : ?>
  <?php if ($_SESSION['Identity'] == 'member') : ?>
    <nav>
      <ul>
        <li><a href='../'>首頁</a></li>
        <li><a href='../classroomList.php'>教室清單</a></li>
        <li><a href='../history/'>借用紀錄</a></li>
        <a href='../' id='hello' 　>hi! <span class='memberName'><?php echo $_SESSION['UserName'] ?></span>會員</a>
        <li class='logout'><a href='../account/logout.php'>登出</a></li>
      </ul>
    </nav>
  <?php elseif ($_SESSION['Identity'] == 'approver') : ?>
    <nav>
      <ul>
        <li><a href='../'>首頁</a></li>
        <!-- <li><a href='../rentalSearch/'>教室查詢</a></li> -->
        <li><a href='../classroomList.php'>教室清單</a></li>
        <li><a href='../approve/'>審核</a></li>
        <a href='../' id='hello' 　>hi!　<span class='memberName'><?php echo $_SESSION['UserName'] ?></span>管理者</a>
        <li class='logout'><a href='../account/logout.php'>登出</a></li>
      </ul>
    </nav>
  <?php endif; ?>
<?php else : ?>
  <nav>
    <ul>
      <li><a href='../'>首頁</a></li>
      <!-- <li><a href='../rentalSearch/'>教室查詢</a></li> -->
      <li><a href='../classroomList.php'>教室清單</a></li>
      <li class='login'><a href='../login/'>登入</a></li>
    </ul>
  </nav>
<?php endif; ?>

</html>