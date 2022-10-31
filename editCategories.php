<?php

require_once('common.php');
if (isset($_SESSION['userInfo'])) {
  $userInfo = $_SESSION['userInfo'];
  $categoryID = 0;
  if (isset($_GET['s']) && $userInfo->privileges == 'Admin') {
    $values = ['categoryID' => $_GET['s']];
    $categoryID = $values['categoryID'];
    $categoryInfo = $database->getCategoriesById($values);
  }
  if (isset($_POST['categoryID']) && isset($_POST['delete'])) {
    $values = ['categoryID' => $_POST['categoryID']];
    $database->deleteCategory($values);
    header("Location:serviceupdate.php");
  }
  if (isset($_POST['categoryname']) && isset($_POST['categoryID']) && isset($_POST['edit'])) {
    $values = [
      'categoryID' => $_POST['categoryID'],
      'categoryname' => $_POST['categoryname']
    ];
    $response = $database->updateCategories($values);
    header("Location:serviceupdate.php");
  } else if (isset($_POST['categoryname']) && isset($_POST['add'])) {
    $values = [
      'categoryname' => $_POST['categoryname'],
    ];
    $response = $database->addCategory($values);
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
      <?php if ($categoryID != 0) : ?>
        <h2 style="text-align:center;">Edit Category</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <fieldset name="paymentInfo">
            <label for="">Category Name</label>
            <input type="text" placeholder="Enter Category Name" name="categoryname" required value="<?php echo $categoryInfo->categoryname; ?>">
            <input type="hidden" name="edit" value="1">
            <input type="hidden" name="categoryID" value="<?php echo $categoryInfo->categoryID; ?>">
            <input type="submit" value="Edit Category">
            <a href="serviceupdate.php">
              <div class="cancel-button">Cancel</div>
            </a>
        </form>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <input type="hidden" name="categoryID" value="<?php echo $categoryInfo->categoryID; ?>">
          <input type="hidden" name="delete" value="1">
          <input type="submit" value="Delete Category">
        </form>
      <?php else : ?>
        <h2 style="text-align:center;">Add Category</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <fieldset name="paymentInfo">
            <label for="">Category Name</label>
            <input type="text" placeholder="Enter Category Name" name="categoryname" required>
            <input type="hidden" name="add" value="1">
            <input type="submit" value="Add Category">
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
