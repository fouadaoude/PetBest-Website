<?php
  session_start();
  unset($_SESSION['userInfo']);
  session_destroy();
  header("Location: index.php");
?>
