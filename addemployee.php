<?php

require_once('common.php');
if (isset($_SESSION['userInfo'])) {
  $userInfo = $_SESSION['userInfo'];
}

$usererror = "";
$passerror = "";
$confirmPasserror = "";

$usernameErrorcount = 0;
$passwordErrorcount = 0;

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['confirmpass']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['birthdate'])) {
  $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
  $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
  $confirmpass = filter_var($_POST['confirmpass'], FILTER_SANITIZE_STRING);
  $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
  $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);
  $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
  $birthdate = filter_var($_POST['birthdate'], FILTER_SANITIZE_STRING);
  $hiredate = date('Y-m-d');

  if (preg_match('/[0-9]/', $username) == 0 || preg_match('/[0-9]/', $username) == 0) {
    $usererror = "Username must include at least two numbers";
    $usernameErrorcount++;
  }
  if (strlen($username) < 8) {
    $usererror = "Username must be at least 8 characters long";
    $usernameErrorcount++;
  }
  if (preg_match('/[0-9]/', $password) == 0 || preg_match('/[0-9]/', $password) == 0) {
    $error = "Password must include at least 2 numbers";
    $passwordErrorcount++;
  }
  if (preg_match('/[\'^£$%&*()}{@#~!?> <>,|=_+¬-]/', $password) == 0) {
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
  if ($usernameErrorcount < 1 && $passwordErrorcount < 1) {
    $values = [
      'username' => $username,
      'password' => $password,
      'firstName' => $firstname,
      'lastName' => $lastname,
      'privileges' => 'Employee',
      'email' => $email,
      'birthdate' => $birthdate,
      'hiredate' => $hiredate
    ];

    $response = $database->createUser($values);
  }
}
?>
<!DOCTYPE HTML>
<HTML lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width = device-width, initial-scale = 1.0, user-scalable = 1;">
  <link rel="stylesheet" type="text/css" href="css/bestPet.css">
  <link rel="stylesheet" type="text/css" href="css/sideBar.css">
  <title>Pet Best, LLC</title>
</head>

<body>
  <?php require_once("menu.php") ?>
  <?php require_once("sideBar.php") ?>

  <div class="main">

      <?php if (isset($userInfo)) : ?>
        <h1>Pet Best LLC</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <h2>Add Employee</h2>
          <div class="AddEmployeeCard">
            <label for="firstname"><b>First Name</b></label>
            <input type="text" class="employeeAdd" placeholder="Enter First Name" name="firstname" required value=<?php if (isset($firstname)) {
                                                                                                                    echo $firstname;
                                                                                                                  } ?>><br>
            <label for="lastname"><b>Last Name</b></label>
            <input type="text" class="employeeAdd" placeholder="Enter Last Name" name="lastname" required value=<?php if (isset($lastname)) {
                                                                                                                  echo $lastname;
                                                                                                                } ?>><br>
            <label for="birthdate"><b>Date of Birth</b></label>
            <input type="date" class="employeeAdd" placeholder="YYYY-MM-DD" name="birthdate" required value=<?php if (isset($birthdate)) {
                                                                                                                  echo $birthdate;
                                                                                                                } ?>><br>
            <label for="email"><b>Email</b></label>
            <input type="email" class="employeeAdd" placeholder="Enter Email" name="email" required value=<?php if (isset($email)) {
                                                                                                            echo $email;
                                                                                                          } ?>><br>
            <label for="username"><b>Username</b></label>
            <input type="text" class="employeeAdd" placeholder="Enter Username" name="username" required value=<?php if (isset($username)) {
                                                                                                                  echo $username;
                                                                                                                } ?>> <?php echo "<span style=color:red;font-size:.8em;>" . $usererror . "</span>" ?><br>
            <label for="password"><b>Password</b></label>
            <input type="password" class="employeeAdd" placeholder="Enter Password" name="password" required value=<?php if (isset($password)) {
                                                                                                                      echo $password;
                                                                                                                    } ?>> <?php echo "<span style=color:red;font-size:.8em;>" . $passerror . "</span>" ?><br>
            <label for="confirmpass"><b>Repeat Password</b></label>
            <input type="password" class="employeeAdd" placeholder="Confirm Password" name="confirmpass" required><?php echo "<span style=color:red;font-size:.8em;>" . $confirmPasserror . "</span>" ?><br>
          </div>
          <input type="submit" style="margin-top:10px;padding: 10px 5px;" value="Add Employee"></input>
        </form>
      <?php endif; ?>
  </div>
</body>

</HTML>
