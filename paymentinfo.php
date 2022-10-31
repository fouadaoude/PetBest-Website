<?php

require_once('common.php');
if (isset($_SESSION['userInfo'])) {
  $userInfo = $_SESSION['userInfo'];
  if ($userInfo->privileges == 'Admin') {
    $customerInfo = $database->showCustomerWhoHavePets();
  }
  if (isset($_POST['userID'])) {
    $values = ['userID' => $_POST['userID']];
    $petInfo = $database->showPetsByCustomer($values);
    print_r($petInfo);
  }
  if (isset($_POST['month'])) {
    $values = ['month' => $_POST['month']];
    $petBirthdayInfo = $database->showPetsByBirthMonth($values);
    print_r($petBirthdayInfo);
  }
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
  <?php require_once("menu.php") ?>
  <?php require_once("sideBar.php") ?>

  <div class="main">
    <!-- <div style="color: #777;background-color:white;text-align:center;padding:50px 80px;text-align: justify;"> -->
      <?php if (isset($userInfo)) : ?>
        <div id="flex-card">
          <div class="card">
            <h1 style="text-align:center">Payment Information</h1>

            <form>
              <fieldset name="paymentInfo">
                <label for="firstname">First Name</label>
                <input type="firstname" id="firstname" placeholder="John">

                <label for="lastname">Last Name</label>
                <input type="lastname" id="lastname" placeholder="Doe">
              </fieldset>

              <fieldset name="cardInfo">
                <label for="cardNum" required>Card Number</label>
                <input type="tel" id="cardNum" placeholder="0000 0000 0000 0000">

                <label for="cardExp" required>Expires</label>
                <input type="tel" id="cardExp" placeholder="MM/YY">

                <label for="cardCVC" required>CVC</label>
                <input type="tel" id="cardCVC" placeholder="***">
              </fieldset>

              <input type="submit" value="Add Card">
            </form>

          </div>


        <?php endif; ?>
        </div>
    <!-- </div> -->
    <script src="js/orders.js"></script>
</body>

</HTML>
