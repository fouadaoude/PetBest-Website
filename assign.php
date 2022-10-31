<?php

require_once('common.php');
if (isset($_SESSION['userInfo'])) {
  $userInfo = $_SESSION['userInfo'];
  if ($userInfo->privileges == 'Admin') {
    $employeeList = $database->showAllEmployees();
  }
  if (isset($_POST['employeeID'])) {
    $orderID = $_SESSION['orderID'];
    $values = ['orderID' => $orderID,'userID' => $_POST['employeeID']];
    $database->assignEmployeeToOrder($values);
    header("Location: currentorders.php");
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
    <?php if (isset($employeeList)) : ?>
      <div id="flex-card">
        <div class="card">
          <div id="empList">
            <h2>Employee List</h2>
            <table id="free">
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Privileges</th>
                <th>Choice</th>
              </tr>

              <?php foreach ($employeeList as $value) : ?>
                <tr>
                  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <td><?php echo $value->firstName . ' ' . $value->lastName; ?></td>
                    <td><?php echo $value->email; ?></td>
                    <td><?php echo $value->privileges; ?></td>
                    <input type="hidden" name="employeeID" value=<?php echo $value->userID ?>>
                    <td><input type="Submit" value="Assign"></td>
                  </form>
                </tr>
              <?php endforeach; ?>
            </table>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>
</body>

</HTML>
