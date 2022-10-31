<?php

require_once('common.php');
print_r($_POST);
if (isset($_SESSION['userInfo'])) {
  $userInfo = $_SESSION['userInfo'];
  $serviceID = 0;
  $categories = $database->showAllServices()['categories'];
  if (isset($_GET['s']) && $userInfo->privileges == 'Admin') {
    $values = ['serviceID' => $_GET['s']];
    $serviceID = $values['serviceID'];
    $serviceInfo = $database->getServicesById($values);
    $value = ['categoryID' => $serviceInfo->categoryID];
    $categoryInfo = $database->getCategoriesById($value);
  }
  if (isset($_POST['serviceID']) && isset($_POST['delete'])) {
    $values = ['serviceID' => $_POST['serviceID']];
    $database->deleteService($values);
  }
  if (isset($_POST['servicename']) && isset($_POST['description']) && isset($_POST['categoryID']) && isset($_POST['price']) && isset($_POST['edit']) && isset($_POST['serviceID'])) {
    $values = [
      'servicename' => $_POST['servicename'],
      'description' => $_POST['description'],
      'categoryID' => $_POST['categoryID'],
      'price' => $_POST['price'],
      'serviceID' => $_POST['serviceID'],
    ];
    $response = $database->updateServices($values);
    header("Location:serviceupdate.php");
  } else if (isset($_POST['servicename']) && isset($_POST['description']) && isset($_POST['categoryID']) && isset($_POST['price']) && isset($_POST['add'])) {
    $values = [
      'servicename' => $_POST['servicename'],
      'description' => $_POST['description'],
      'categoryID' => $_POST['categoryID'],
      'price' => $_POST['price'],
    ];
    $response = $database->addService($values);
    header("Location:serviceupdate.php");
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
  <?php require_once("sideBar.php") ?>

  <div class="main">

    <?php if (isset($userInfo)) : ?>
      <?php if ($serviceID != 0) : ?>
        <h2 style="text-align:center;">Edit Service</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <fieldset name="paymentInfo">
            <label for="">Service Name</label>
            <input type="text" placeholder="Enter Service Name" name="servicename" required value="<?php echo $serviceInfo->servicename; ?>">
            <label for="">Description</label>
            <textarea placeholder="Enter Description" rows="7" cols="40" name="description" style="font-family:Lucida Grande, sans-serif;" required><?php echo $serviceInfo->description; ?></textarea>
          </fieldset>
          <fieldset name="cardInfo" style="margin-top:-2em;">
            <label for="status">Category</label>
            <select id="status" name="categoryID">
              <option value="<?php echo $categoryInfo->categoryID; ?>" selected><?php echo $categoryInfo->categoryname; ?></option>
              <?php foreach ($categories as $value) : ?>
                <option value="<?php echo $value->categoryID; ?>"><?php echo $value->categoryname; ?></option>
              <?php endforeach ?>
            </select>
            <label for="orderTotal">Total Price</label>
            <input type="number" id="orderTotal" step="0.01" placeholder="Enter Total" name="price" value=<?php echo $serviceInfo->price; ?> required>
            <input type="hidden" name="edit" value="1">
            <input type="hidden" name="serviceID" value="<?php echo $serviceID ?>">
          </fieldset>
          <input type="submit" value="Edit Service">
          <a href="serviceupdate.php">
            <div class="cancel-button">Cancel</div>
          </a>
        </form>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <input type="hidden" name="serviceID" value="<?php echo $serviceInfo->serviceID; ?>">
          <input type="hidden" name="delete" value="1">
          <input type="submit" value="Delete Service">
        </form>
      <?php else : ?>
        <h2 style="text-align:center;">Add Service</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <fieldset name="paymentInfo">
            <label for="">Service Name</label>
            <input type="text" name="servicename" placeholder="Enter Service Name" required>
            <label for="">Description</label>
            <textarea placeholder="Enter Description" rows="7" cols="40" name="description" style="font-family:Lucida Grande, sans-serif;" required></textarea>
          </fieldset>
          <fieldset name="cardInfo" style="margin-top:-2em;">
            <label for="status">Category</label>
            <select id="status" name="categoryID">
              <?php foreach ($categories as $value) : ?>
                <option value="<?php echo $value->categoryID; ?>"><?php echo $value->categoryname; ?></option>
              <?php endforeach ?>
            </select>
            <label for="orderTotal">Total Price</label>
            <input type="number" step="0.01" id="orderTotal" placeholder="Enter Total" name="price" required>
          </fieldset>
          <input type="hidden" name="add" value="1">
          <input type="submit" value="Add Service">
          <a href="serviceupdate.php">
            <div class="cancel-button">Cancel</div>
          </a>
        </form>
  </div>

<?php endif; ?>
<?php endif; ?>
</div>
</body>

</HTML>
