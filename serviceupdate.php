<?php

require_once('common.php');
if (isset($_SESSION['userInfo'])) {
  $userInfo = $_SESSION['userInfo'];
  if ($userInfo->privileges == 'Admin') {
    $servicesAndCategories = $database->showAllServices();
    $services = $servicesAndCategories['services'];
    $categories = $servicesAndCategories['categories'];
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
      <div id="flex-card">
        <div class="card">
          <h1 style="text-align:center;">Pet Best LLC</h1>
          <?php if (isset($services)) : ?>
            <h2 style="text-align:center;">Services</h2>
            <div class="service-bar-title">
              <p>Service ID#</p>
              <p>Category ID#</p>
              <p>Service Name</p>
              <p>Price</p>
            </div>
            <?php foreach ($services as $value) : ?>
              <a href="editService.php?s=<?php echo $value->serviceID; ?>">
                <div class="service-bar">
                  <p><?php echo $value->serviceID; ?></p>
                  <p><?php echo $value->categoryID; ?></p>
                  <p><?php echo $value->servicename; ?></p>
                  <p><?php echo "$" . $value->price; ?></p>
                </div>
              </a>
            <?php endforeach; ?>
            <a href="editService.php">
              <div class="service-bar">
                <p style="width:inherit;font-size:1.1em;">Add Service</p>
              </div>
            </a>
          <?php endif; ?>

          <?php if (isset($categories)) : ?>
            <h2 style="text-align:center;">Categories</h2>
            <div class="categories-bar-title">
              <p>Category ID#</p>
              <p>Category Name</p>
            </div>
            <?php foreach ($categories as $value) : ?>
              <a href="editCategories.php?s=<?php echo $value->categoryID; ?>">
                <div class="categories-bar">
                  <p><?php echo $value->categoryID; ?></p>
                  <p><?php echo $value->categoryname; ?></p>
                </div>
              </a>
              <?php endforeach; ?>
              <a href="editCategories.php">
                <div class="service-bar">
                  <p style="width:inherit;font-size:1.1em;">Add Categories</p>
                </div>
              </a>
            <?php endif; ?>
        </div>
      </div>
    <?php endif; ?>

</body>

</HTML>
