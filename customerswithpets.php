<?php

require_once('common.php');
if (isset($_SESSION['userInfo'])) {
  $userInfo = $_SESSION['userInfo'];
  echo "Hello";
  if ($userInfo->privileges == 'Admin') {
    $customerPets = $database->listCustomerWithPets();
    echo "Hello";
  }
  if (isset($_POST['month'])) {
    $values = ['month' => $_POST['month']];
    $petBirthdayInfo = $database->showPetsByBirthMonth($values);
    // print_r($petBirthdayInfo);
  }
}
?>

<!DOCTYPE HTML>
<html lang="en">

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
    <div style="color: #777;background-color:white;text-align:center;padding:50px 80px;text-align: justify;">
      <?php if (isset($customerPets)) : ?>
        <div id="flex-card">
          <div class="card">
            <h1>Pet Best LLC</h1>
            <h2 style="color:black;">Customer With Pets</h2>
            <table id="free">
              <tr>
                <th>ID #</th>
                <th>Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Pets</th>
              </tr>
              <?php foreach ($customerPets['result'] as $value) : ?>
                <tr>
                  <td><?php echo $value->userID; ?></td>
                  <td><?php echo $value->firstName . ' ' . $value->lastName; ?></td>
                  <td><?php echo $value->username; ?></td>
                  <td><a href=<?php echo "mailto:" . $value->email; ?>><?php echo $value->email; ?></a></td>
                  <td><?php echo $value->PetName ?></td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
            </table>
            <h2>Show Pets by Birth Month</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
              <label for="Month" style="color:black;">Month:</label>
              <select name="month">
                <option value="1">JAN</option>
                <option value="2">FEB</option>
                <option value="3">MAR</option>
                <option value="4">APR</option>
                <option value="5">MAY</option>
                <option value="6">JUN</option>
                <option value="7">JUL</option>
                <option value="8">AUG</option>
                <option value="9">SEP</option>
                <option value="10">OCT</option>
                <option value="11">NOV</option>
                <option value="12">DEC</option>
              </select>
              <input type="submit" value="Submit">
            </form>
            <?php if (isset($petBirthdayInfo)) : ?>
              <div id="all" class="all show">
                <div class="customerview-bar-title">
                  <p>Pet Name</p>
                  <p>Pet Birthdate</p>
                  <p>Breed</p>
                  <p>Color</p>
                  <p>Weight</p>
                </div>
                <?php foreach ($petBirthdayInfo as $value) : ?>
                  <div class="customerview-bar">
                    <p><?php echo $value->fullName; ?></p>
                    <p><?php echo $value->birthdate; ?></p>
                    <p style="margin:0em .3em 0em .5em;"><?php echo $value->breed; ?></p>
                    <p><?php echo $value->color; ?></p>
                    <p><?php echo $value->weight; ?></p>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>


</body>

</html>
