<?php

require_once('common.php');
if (isset($_SESSION['userInfo'])) {
  $userInfo = $_SESSION['userInfo'];
  if ($userInfo->privileges == 'Employee') {
    $assignedRequest = $database->getAssignedRequest($userInfo->userID);
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width = device-width, initial-scale = 1.0, user-scalable = 1;">
  <link rel="stylesheet" type="text/css" href="css/bestPet.css">
  <link rel="stylesheet" type="text/css" href="css/sideBar.css">
  <title>Pet Best, LLC</title>
</head>
  <?php require_once("menu.php") ?>
  <?php require_once("sideBar.php") ?>

  <div class="main">
    <div style="color: #777;background-color:white;text-align:center;padding:50px 80px;text-align: justify;">
      <?php if(isset($userInfo)) : ?>
        <div id="flex-card">
          <div class="card">
          <?php print_r($_POST); ?>
            <h3>Share Your Experience</h3>
            <?php if(isset($assignedRequest)) : ?>
            <table id="free">
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Job Date</th>
              <th>Job Category</th>
              <th>Service</th>
              <th>Status</th>
              <th>Order ID</th>
            </tr>
            <?php foreach ($assignedRequest as $value) : ?>
              <?php if($_POST["orderID"] == $value->orderID) :?>
              <tr>
                <td><?php echo $value->firstName . ' ' . $value->lastName; ?></td>
                <td><?php echo $value->email; ?></td>
                <td><?php echo $value->serviceDateRequest; ?></td>
                <td><?php echo $value->categoryname; ?></td>
                <td><?php echo $value->servicename ?></td>
                <td><?php echo $value->orderStatus ?></td>
                <td><?php echo $value->orderID ?></td>
              </tr>
              <?php endif; ?>
            <?php endforeach; ?>
            <?php endif; ?>
            <?php endif; ?>
          </div>
        </div>
</body>
</html>
