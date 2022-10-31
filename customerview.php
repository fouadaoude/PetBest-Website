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
    // print_r($petInfo);
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
    <div style="color: #777;background-color:white;text-align:center;padding:50px 80px;text-align: justify;">
      <?php if (isset($userInfo)) : ?>
        <div id="flex-card">
          <div class="card">
            <h1>Pet Best LLC</h1>
            <?php if (isset($customerInfo)) : ?>
              <div id="all" class="all show">
                <h2 style="text-align:center;color:black;">Customer View</h2>
                <div class="customerview-bar-title">
                  <p>Customer ID#</p>
                  <p>Name</p>
                  <p>Username</p>
                  <p>Email</p>
                  <!-- <p>Show Pets</p> -->
                </div>
                <?php foreach ($customerInfo as $value) : ?>
                  <div class="customerview-bar">
                    <p><?php echo $value->userID; ?></p>
                    <p><?php echo $value->firstName . ' ' . $value->lastName; ?></p>
                    <p><?php echo $value->username; ?></p>
                    <p><a href=<?php echo "mailto:" . $value->email; ?>><?php echo $value->email; ?></a></p>
                    <!-- <form style="min-width: 19%;" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                      <input type="hidden" name="userID" value=<?php echo $value->userID; ?>>
                      <p style="width:inherit;"><input type="submit" style="padding: 5px 10px;border-radius:1em;" value="Show Pets"></p>
                    </form> -->
                  </div>

                <?php endforeach; ?>
              </div>
            <?php endif; ?>

            <?php if (isset($petInfo)) : ?>
              <div id="all" class="all show">
                <h2 style="text-align:center;color:black;"><?php echo $petInfo[0]->firstName . " " . $petInfo[0]->lastName; ?> Pets</h2>
                <div class="customerview-bar-title">
                  <p>Pet Name</p>
                  <p>Pet Birthdate</p>
                  <p>Breed</p>
                  <p>Color</p>
                  <p>Weight</p>
                </div>
                <?php foreach ($petInfo as $value) : ?>
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
          <?php endif; ?>
          </div>
        </div>
        <script src="js/orders.js"></script>
</body>

</HTML>
