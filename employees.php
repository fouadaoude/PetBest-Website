<?php

require_once('common.php');
if (isset($_SESSION['userInfo'])) {
  $userInfo = $_SESSION['userInfo'];
  if ($userInfo->privileges == 'Admin') {
    $employeeList = $database->showAllEmployees();
    if (isset($_POST['employeeID'])) {
      $values = [ 'userID' => $_POST['employeeID']];
      $assignedOrder = $database->getAssignedRequest($values);
      $employeeInfo = $database->getEmployeeInfo($values);
    }
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
      <?php if (isset($employeeList)) : ?>
        <div id="flex-card">
          <div class="card">
            <h1>Pet Best LLC</h1>
            <h2 style="color:black;">Employee List</h2>
            <table id="free">
              <tr>
                <th>ID #</th>
                <th>Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Privileges</th>
                <th>Hire Date</th>
                <th>Birthdate</th>
                <th>Attached Orders</th>
              </tr>
              <?php foreach ($employeeList as $value) : ?>
                <tr>
                  <td><?php echo $value->userID; ?></td>
                  <td><?php echo $value->firstName . ' ' . $value->lastName; ?></td>
                  <td><?php echo $value->username; ?></td>
                  <td><a href=<?php echo "mailto:" . $value->email; ?>><?php echo $value->email; ?></a></td>
                  <td><?php echo $value->privileges; ?></td>
                  <td><?php echo $value->hiredate; ?></td>
                  <td><?php echo $value->birthdate; ?></td>
                  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input type="hidden" name="employeeID" value=<?php echo $value->userID; ?>>
                    <td><input type="submit" value="See Orders"></td>
                  </form>
                </tr>
              <?php endforeach; ?>
            </table>
          </div>
        </div>

        <?php if (!empty($assignedOrder)) : ?>
          <div id="flex-card">
            <div class="card">
              <h2 style="color:black;">Orders For <?php echo $employeeInfo->firstName . " " . $employeeInfo->lastName; ?> To Work On! </h2>
              <table id="free">
                <tr>
                  <th>Customer Name</th>
                  <th>Customer Email</th>
                  <th>Order ID</th>
                  <th>Order Date</th>
                  <th>Service Date</th>
                  <th>Order Status</th>
                  <th>Category Of Service</th>
                  <th>Name of Service</th>
                  <th>Employee Assigned</th>
                </tr>
                <?php foreach ($assignedOrder as $value) : ?>
                  <tr>
                    <td><?php echo $value->firstName . ' ' . $value->lastName; ?></td>
                    <td><a href=<?php echo "mailto:" . $value->email; ?>><?php echo $value->email; ?></a></td>
                    <td><?php echo $value->orderID; ?></td>
                    <td><?php echo $value->orderDate; ?></td>
                    <td><?php echo $value->serviceDateRequest; ?></td>
                    <td><?php echo $value->orderStatus; ?></td>
                    <td><?php echo $value->categoryname; ?></td>
                    <td><?php echo $value->servicename ?></td>
                    <td><?php echo $employeeInfo->firstName . " " . $employeeInfo->lastName; ?></td>
                  </tr>
                <?php endforeach; ?>
              </table>
            </div>
          </div>
        <?php elseif (isset($assignedOrder) == empty($assignedOrder)) : ?>
          <div id="flex-card">
            <div class="card">
              <h2 style="color:black;"><?php echo $employeeInfo->firstName . " " . $employeeInfo->lastName; ?> Has No Current Orders To Work On </h2>
            </div>
          </div>
        <?php endif; ?>
      <?php endif; ?>
    </div>
   </div>
</body>

</HTML>
