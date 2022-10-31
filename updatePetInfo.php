<?php

require_once('common.php');

if (isset($_POST['fullname']) && isset($_POST['birthdate']) && isset($_POST['breed']) && isset($_POST['color']) && isset($_POST['weight']) && isset($_POST['petID'])) {
  $fullname = filter_var($_POST['fullname'], FILTER_SANITIZE_STRING);
  $birthdate = filter_var($_POST['birthdate'], FILTER_SANITIZE_STRING);
  $breed = filter_var($_POST['breed'], FILTER_SANITIZE_STRING);
  $color = filter_var($_POST['color'], FILTER_SANITIZE_STRING);
  $weight = filter_var($_POST['weight'], FILTER_SANITIZE_STRING);
  $petID = filter_var($_POST['petID'], FILTER_SANITIZE_STRING);

  $values = [
    'fullName' => $fullname,
    'birthdate' => $birthdate,
    'breed' => $breed,
    'color' => $color,
    'weight' => $weight,
    'petID' => $petID
  ];

  $response = $database->updatePet($values);
  print_r($response);


  if (!empty($response['result'])) {
    header('Location: profile.php');
  }
}
if (isset($_POST['petID'])) {
  $values = ['petID' => $_POST['petID']];
  $petInfoArray = $database->readPet($values);
  $petInfo = $petInfoArray['result'];
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
    <?php if (isset($userInfo)) : ?>
      <h2 style="text-align:center;">Pet Update</h2>
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <fieldset name="paymentInfo">
          <label for="">Name</label>
          <input type="text" name="fullname" placeholder="Change Name" required value="<?php echo $petInfo->fullName; ?>">
          <label for="">Breed</label>
          <input type="text" name="breed" placeholder="Change Breed" required value="<?php echo $petInfo->breed; ?>">
          <label for="">Color</label>
          <input type="text" placeholder="Change Color" name="color" required value="<?php echo $petInfo->color; ?>">
          <label for="">Weight</label>
          <input type="number" name="weight" placeholder="Change Weight" required value=<?php echo $petInfo->weight; ?>>
          <label for="dateOfCompletion">Birthdate</label>
          <input type="date" placeholder="YYYY-MM-DD" name="birthdate" required value=<?php echo $petInfo->birthdate; ?>>
          <input type="hidden" name="petID" value="<?php echo $petInfo->petID; ?>">
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
