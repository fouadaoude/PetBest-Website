<?php

require_once('common.php');
if (isset($_SESSION['userInfo'])) {
  $userInfo = $_SESSION['userInfo'];
  if (isset($_POST['orderStatus']) && isset($_POST['orderID'])) {
    $values = [
      'orderStatus' => $_POST['orderStatus'],
      'orderID' => $_POST['orderID']
    ];
    $database->updateOrderStatus($values);
    // $database->emailMyself();
  }
  if ($userInfo->privileges == 'Employee') {
    $assignedRequest = $database->getAssignedRequest($userInfo);
    $completedRequest = $database->getCompletedRequest($userInfo);
    $cancelledRequest = $database->getCancelledRequest($userInfo);
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
    <!-- <div style="color: #777;background-color:white;text-align:center;padding:50px 80px;text-align: justify;"> -->

    <?php if (isset($userInfo)) : ?>
      <div id="flex-card">
        <div class="card">
          <h1 class="mobile">Pet Best LLC</h1>

          <?php if (!empty($assignedRequest)) : ?>
            <h2 class="customerinfo-title">My Active Jobs</h2>
            <div id="customerinfo-flex">
              <?php foreach ($assignedRequest as $value) : ?>
                <div class="customerinfo-card">
                  <p class="customerinfo-details"><?php echo $value->firstName . ' ' . $value->lastName; ?></p>
                  <p class="customerinfo-details"><a href="mailto:" <?php echo $value->email; ?>><?php echo $value->email; ?></a></p>
                  <p class="customerinfo-details"><?php echo $value->serviceDateRequest; ?></p>
                  <p class="customerinfo-details"><?php echo $value->categoryname; ?></p>
                  <p class="customerinfo-details"><?php echo $value->servicename; ?></p>
                  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input type="hidden" name="orderID" value=<?php echo $value->orderID; ?>>
                    <p class="customerinfo-details">
                      <select name="orderStatus">
                        <option><?php echo $value->orderStatus ?></option>
                        <option value="In Route">On The Way</option>
                        <option value="Pending">Pending</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Cancelled">Cancelled</option>
                      </select>
                      <input type="submit" value="^">
                    </p>
                  </form>
                  <p class="customerinfo-details"><?php echo $value->orderID; ?></p>
                  <form method="post" action="employeeupdate.php">
                    <input type="hidden" name="orderID" value=<?php echo $value->orderID; ?>>
                    <p class="customerinfo-details"><input type="submit" value="Submit Order"></p>
                  </form>
                </div>
              <?php endforeach; ?>
            </div>
          <?php else : ?>
            <h2>No Active Jobs For <?php echo $userInfo->firstName . " " . $userInfo->lastName ?></h2>
          <?php endif; ?>

          <?php if (isset($completedRequest)) : ?>
            <h2 class="customerinfo-title">My Completed Jobs</h2>
            <div id="customerinfo-flex">
              <?php foreach ($completedRequest as $value) : ?>
                <div class="customerinfo-card">
                  <p class="customerinfo-details"><?php echo $value->firstName . ' ' . $value->lastName; ?></p>
                  <p class="customerinfo-details"><a href="mailto:" <?php echo $value->email; ?>><?php echo $value->email; ?></a></p>
                  <p class="customerinfo-details"><?php echo $value->serviceDateRequest; ?></p>
                  <p class="customerinfo-details"><?php echo $value->categoryname; ?></p>
                  <p class="customerinfo-details"><?php echo $value->servicename; ?></p>
                  <p class="customerinfo-details"><?php echo $value->orderStatus; ?></p>
                  <p class="customerinfo-details"><?php echo $value->orderID; ?></p>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>

          <?php if (!empty($cancelledRequest)) : ?>
            <h2 class="customerinfo-title">My Cancelled Jobs</h2>
            <div id="customerinfo-flex">
              <?php foreach ($cancelledRequest as $value) : ?>
                <div class="customerinfo-card">
                  <p class="customerinfo-details"><?php echo $value->firstName . ' ' . $value->lastName; ?></p>
                  <p class="customerinfo-details"><a href="mailto:" <?php echo $value->email; ?>><?php echo $value->email; ?></a></p>
                  <p class="customerinfo-details"><?php echo $value->serviceDateRequest; ?></p>
                  <p class="customerinfo-details"><?php echo $value->categoryname; ?></p>
                  <p class="customerinfo-details"><?php echo $value->servicename; ?></p>
                  <p class="customerinfo-details"><?php echo $value->orderStatus; ?></p>
                  <p class="customerinfo-details"><?php echo $value->orderID; ?></p>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    <?php endif; ?>
</body>

</HTML>
