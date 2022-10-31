<?php

require_once('common.php');

$username = filter_var($_POST['username'],FILTER_SANITIZE_STRING);
$password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);

$values = [
  'username' => $username,
  'password' => $password
];

$userInfo = $database->login($values);
// print_r($userInfo);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/welcome.css">
  <link rel="stylesheet" type="text/css" href="css/bestPet.css">
  <title>Welcome Page</title>
</head>
<body>
    <?php if (!empty($userInfo['result'])){
      echo '<div id="flex-card">';
      echo '<div class="card">';
      echo '<h1>Pet Best LLC</h1>';
      echo '<h2> Welcome <br>'.$userInfo['result']->firstname.' '. $userInfo['result']->lastname.'</h2>';
      echo '<p>Your email is '. $userInfo['result']->email.' </p>';
      echo '</div>';
      echo '</div>';
    }
    elseif (!empty($userInfo['error'])){
      header('Location: login.php?message=1');
    }?>

</body>
</html>
