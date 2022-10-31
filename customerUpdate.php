<?php

require_once('common.php');
$usererror = "";
$passerror = "";
$confirmPasserror = "";

$usernameErrorcount = 0;
$passwordErrorcount = 0;
if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['confirmpass']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email'])) {
  $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
  $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
  $confirmpass = filter_var($_POST['confirmpass'], FILTER_SANITIZE_STRING);
  $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
  $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);
  $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
  $userID = filter_var($_POST['userID'], FILTER_SANITIZE_STRING);

  if (preg_match('/[0-9]/', $username) == 0 || preg_match('/[0-9]/', $username) == 0) {
    $usererror = "Username must include at least two numbers";
    $usernameErrorcount++;
  }
  if (strlen($username) < 8) {
    $usererror = "Username must be at least 8 characters long";
    $usernameErrorcount++;
  }

  if ($password != ""){
      if (preg_match('/[0-9]/', $password) == 0 || preg_match('/[0-9]/', $password) == 0) {
        $error = "Password must include at least 2 numbers";
        $passwordErrorcount++;
      }
      if (preg_match('/[\'^£$%&*()}{@#~!?><>,|=_+¬-]/', $password) == 0) {
        $passerror = "Must include 1 special character";
        $passwordErrorcount++;
      }
      if (strlen($password) < 8) {
        $passerror = "Password must be at least 8 characters long";
        $passwordErrorcount++;
      }
      if (strcmp($password, $confirmpass) != 0) {
        $confirmPasserror = "Passwords must match";
        $passwordErrorcount++;
      }
  }


  if ($usernameErrorcount < 1 && $passwordErrorcount < 1) {
    if ($password != ""){
    $values = [
      'userID' => $userID,
      'username' => $username,
      'password' => $password,
      'firstName' => $firstname,
      'lastName' => $lastname,
      'email' => $email
    ];
  } else{
      $values = [
        'userID' => $userID,
        'username' => $username,
        'firstName' => $firstname,
        'lastName' => $lastname,
        'email' => $email
      ];
  }

    $response = $database->updateUser($values);;
  }

  if (!empty($response['result'])) {
    header('Location: logout.php');
  }
}
if (isset($_SESSION['userInfo'])) {
  $userInfo = $_SESSION['userInfo'];
}
?>
<!DOCTYPE HTML>
<HTML lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width = device-width, initial-scale = 1.0, user-scalable = 1;">
  <link rel="stylesheet" type="text/css" href="css/bestPet.css">
  <link rel="stylesheet" type="text/css" href="css/form.css">
  <link rel="stylesheet" type="text/css" href="css/sideBar.css">
  <title>Pet Best, LLC</title>
</head>

<body>
  <?php require_once("sideBar.php") ?>

  <div class="main">
    <?php echo $passerror; ?>
    <?php if (isset($userInfo)) : ?>
      <h2 style="text-align:center;">Update Information</h2>
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <fieldset name="paymentInfo">
          <label for="">User Name</label>
          <input type="text" name="username" placeholder="Change UserName" required value="<?php echo $userInfo->username; ?>">
          <label for="">Password</label>
          <input type="password" name="password" placeholder="Change Password">
          <label for="">Confirm Password</label>
          <input type="password" name="confirmpass" placeholder="Change Password">
          <label for="">Email</label>
          <input type="text" placeholder="Change Email" name="email" required value="<?php echo $userInfo->email; ?>">
          <label for="">First Name</label>
          <input type="text" name="firstname" placeholder="Change First Name" required value="<?php echo $userInfo->firstName; ?>">
          <label for="">Last Name</label>
          <input type="text" name="lastname" placeholder="Change Last Name" required value="<?php echo $userInfo->lastName; ?>">
          <input type="hidden" name="userID" value="<?php echo $userInfo->userID;?>">
        </fieldset>
        <input type="submit" value="Update">
        <a href="profile.php">
          <div class="cancel-button">Cancel</div>
        </a>
      </form>
  </div>

<?php endif; ?>
</div>
</body>

</HTML>
