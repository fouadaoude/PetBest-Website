<?php

require_once('common.php');
if (isset($_POST['orderID'])) {
  $_SESSION['orderID'] = $_POST['orderID'];
  header("Location: assign.php");
}
if (isset($_SESSION['userInfo'])) {
  $userInfo = $_SESSION['userInfo'];
  if ($userInfo->privileges == 'Admin') {
    $allOrderInfo = $database->showAllOrders($userInfo);
    $completeOrders = $database->showAllCompleteOrders($userInfo);
    $cancelOrders = $database->showAllCancelledOrders($userInfo);
    $progressOrders = $database->showAllProgessOrders($userInfo);
    if (isset($_POST['employeeID'])) {
      $values = ['userID' => $_POST['employeeID']];
      $employeeInfo = $database->getEmployeeInfo($values);
    }
    if (isset($_POST['time'])){
      $values = ['hour' => $_POST['time']];
      $timeOrders = $database->ordersInHourPeriod($values);
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
      <?php if (isset($userInfo)) : ?>
        <div id="flex-card">
          <div class="card">
            <h1>Pet Best LLC</h1>
            <h2>Find Orders Within Certain Time Period</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
              <label for="time" style="color:black;">Times:</label>
              <select id="time" name="time">
                <option value="5">5:00AM</option>
                <option value="6">6:00AM</option>
                <option value="7">7:00AM</option>
                <option value="8">8:00AM</option>
                <option value="9">9:00AM</option>
                <option value="10">10:00AM</option>
                <option value="11">11:00AM</option>
                <option value="12">12:00PM</option>
                <option value="13">1:00PM</option>
                <option value="14">2:00PM</option>
                <option value="15">3:00PM</option>
                <option value="16">4:00PM</option>
                <option value="17">5:00PM</option>
                <option value="18">6:00PM</option>
                <option value="19">7:00PM</option>
                <option value="20">8:00PM</option>
              </select>
              <input type="submit" value="Find Orders">
            </form>
            <?php if (isset($timeOrders)) : ?>
              <div id="all" class="all show">
                <h2>Customers Orders</h2>
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
                  <?php foreach ($timeOrders as $value) : ?>
                    <tr>
                      <td><?php echo $value->firstName . ' ' . $value->lastName; ?></td>
                      <td><a href=<?php echo "mailto:" . $value->email; ?>><?php echo $value->email; ?></a></td>
                      <td><?php echo $value->orderID; ?></td>
                      <td><?php echo $value->orderDate; ?></td>
                      <td><?php echo $value->serviceDateRequest; ?></td>
                      <td><?php echo $value->orderStatus ?></td>
                      <td><?php echo $value->categoryname; ?></td>
                      <td><?php echo $value->servicename; ?></td>
                      <?php if (isset($value->employeeID)) : ?>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                          <input type="hidden" name="employeeID" value=<?php echo $value->employeeID; ?>>
                          <?php $values = ['userID' => $value->employeeID];
                          $currentEmployeeInfo = $database->getEmployeeInfo($values); ?>
                          <td><input type="submit" style="padding: 5px 10px;border-radius:1em;width:50%;" value=<?php echo $currentEmployeeInfo->firstName; ?>></td>
                        </form>
                      <?php else : ?>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                          <input type="hidden" name="orderID" value=<?php echo $value->orderID ?>>
                          <td><input type="submit" style="padding: 5px 10px;border-radius:1em;" value="Assign Employee"></td>
                        </form>
                      <?php endif; ?>
                    </tr>
                  <?php endforeach; ?>
                </table>
              </div>
            <?php endif; ?>
            <h2>Customers Orders</h2>
            <label for="Sort" style="color:black;">Sort By:</label>
            <select id="Sort">
              <option value="All">Current Pending</option>
              <option value="Complete">Completed</option>
              <option value="In-Progress">All Orders</option>
              <option value="Cancel">Cancelled</option>
            </select>
            <?php if (isset($progressOrders)) : ?>
              <div id="all" class="all show">
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
                  <?php foreach ($progressOrders as $value) : ?>
                    <tr>
                      <td><?php echo $value->firstName . ' ' . $value->lastName; ?></td>
                      <td><a href=<?php echo "mailto:" . $value->email; ?>><?php echo $value->email; ?></a></td>
                      <td><?php echo $value->orderID; ?></td>
                      <td><?php echo $value->orderDate; ?></td>
                      <td><?php echo $value->serviceDateRequest; ?></td>
                      <td><?php echo $value->orderStatus ?></td>
                      <td><?php echo $value->categoryname; ?></td>
                      <td><?php echo $value->servicename; ?></td>
                      <?php if (isset($value->employeeID)) : ?>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                          <input type="hidden" name="employeeID" value=<?php echo $value->employeeID; ?>>
                          <?php $values = ['userID' => $value->employeeID];
                          $currentEmployeeInfo = $database->getEmployeeInfo($values); ?>
                          <td><input type="submit" style="padding: 5px 10px;border-radius:1em;width:50%;" value=<?php echo $currentEmployeeInfo->firstName; ?>></td>
                        </form>
                      <?php else : ?>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                          <input type="hidden" name="orderID" value=<?php echo $value->orderID ?>>
                          <td><input type="submit" style="padding: 5px 10px;border-radius:1em;" value="Assign Employee"></td>
                        </form>
                      <?php endif; ?>
                    </tr>
                  <?php endforeach; ?>
                </table>
              </div>
            <?php endif; ?>
          <?php endif; ?>

          <?php if (isset($completeOrders)) : ?>
            <div id="complete" class="complete hidden">
              <h2>Complete Orders</h2>
              <table id="free">
                <tr>
                  <th>Customer Name</th>
                  <th>Customer Email</th>
                  <th>Order ID</th>
                  <th>Order Date</th>
                  <th>Service Date</th>
                  <th>Completion Date</th>
                  <th>Order Status</th>
                  <th>Category Of Service</th>
                  <th>Name of Service</th>
                  <th>Employee Assigned</th>
                </tr>
                <?php foreach ($completeOrders as $value) : ?>
                  <tr>
                    <td><?php echo $value->firstName . ' ' . $value->lastName; ?></td>
                    <td><a href=<?php echo "mailto:" . $value->email; ?>><?php echo $value->email; ?></a></td>
                    <td><?php echo $value->orderID; ?></td>
                    <td><?php echo $value->orderDate; ?></td>
                    <td><?php echo $value->serviceDateRequest; ?></td>
                    <td><?php echo $value->serviceDateComplete; ?></td>
                    <td><?php echo $value->orderStatus ?></td>
                    <td><?php echo $value->categoryname; ?></td>
                    <td><?php echo $value->servicename; ?></td>
                    <?php if (isset($value->employeeID)) : ?>
                      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <input type="hidden" name="employeeID" value=<?php echo $value->employeeID; ?>>
                        <?php $values = ['userID' => $value->employeeID];
                        $currentEmployeeInfo = $database->getEmployeeInfo($values); ?>
                        <td><input type="submit" style="padding: 5px 10px;border-radius:1em;width:50%;" value=<?php echo $currentEmployeeInfo->firstName; ?>></td>
                      </form>
                    <?php endif; ?>
                  </tr>
                <?php endforeach; ?>
              </table>
            </div>
          <?php endif; ?>

          <?php if (isset($allOrderInfo)) : ?>
            <div id="progress" class="progress hidden">
              <h2>In Progress Orders</h2>
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
                <?php foreach ($allOrderInfo as $value) : ?>
                  <tr>
                    <td><?php echo $value->firstName . ' ' . $value->lastName; ?></td>
                    <td><a href=<?php echo "mailto:" . $value->email; ?>><?php echo $value->email; ?></a></td>
                    <td><?php echo $value->orderID; ?></td>
                    <td><?php echo $value->orderDate; ?></td>
                    <td><?php echo $value->serviceDateRequest; ?></td>
                    <td><?php echo $value->orderStatus ?></td>
                    <td><?php echo $value->categoryname; ?></td>
                    <td><?php echo $value->servicename; ?></td>
                    <?php if (isset($value->employeeID)) : ?>
                      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <input type="hidden" name="employeeID" value=<?php echo $value->employeeID; ?>>
                        <?php $values = ['userID' => $value->employeeID];
                        $currentEmployeeInfo = $database->getEmployeeInfo($values); ?>
                        <td><input type="submit" style="padding: 5px 10px;border-radius:1em;width:50%;" value=<?php echo $currentEmployeeInfo->firstName; ?>></td>
                      </form>
                    <?php endif; ?>
                  </tr>
                <?php endforeach; ?>
              </table>
            </div>
          <?php endif; ?>

          <?php if (isset($cancelOrders)) : ?>
            <div id="cancell" class="cancell hidden">
              <h2>Cancelled Orders</h2>
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
                <?php foreach ($cancelOrders as $value) : ?>
                  <tr>
                    <td><?php echo $value->firstName . ' ' . $value->lastName; ?></td>
                    <td><a href=<?php echo "mailto:" . $value->email; ?>><?php echo $value->email; ?></a></td>
                    <td><?php echo $value->orderID; ?></td>
                    <td><?php echo $value->orderDate; ?></td>
                    <td><?php echo $value->serviceDateRequest; ?></td>
                    <td><?php echo $value->orderStatus ?></td>
                    <td><?php echo $value->categoryname; ?></td>
                    <td><?php echo $value->servicename; ?></td>
                    <?php if (isset($value->employeeID)) : ?>
                      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <input type="hidden" name="employeeID" value=<?php echo $value->employeeID; ?>>
                        <?php $values = ['userID' => $value->employeeID];
                        $currentEmployeeInfo = $database->getEmployeeInfo($values); ?>
                        <td><input type="submit" style="padding: 5px 10px;border-radius:1em;width:50%;" value=<?php echo $currentEmployeeInfo->firstName; ?>></td>
                      </form>
                    <?php endif; ?>
                  </tr>
                <?php endforeach; ?>
              </table>
            </div>
          <?php endif; ?>

          <?php if (isset($employeeInfo)) : ?>
            <h2>Employee Info</h2>
            <table id="free">
              <tr>
                <th>ID #</th>
                <th>Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Privileges</th>
                <th>Date of Hire</th>
                <th>Date of Birth</th>
              </tr>
              <tr>
                <td><?php echo $employeeInfo->userID; ?></td>
                <td><?php echo $employeeInfo->firstName . ' ' . $employeeInfo->lastName; ?></td>
                <td><?php echo $employeeInfo->username; ?></td>
                <td><a href=<?php echo "mailto:" . $employeeInfo->email; ?>><?php echo $employeeInfo->email; ?></a></td>
                <td><?php echo $employeeInfo->privileges; ?></td>
                <td><?php echo $employeeInfo->hiredate; ?></td>
                <td><?php echo $employeeInfo->birthdate; ?></td>
              </tr>
            </table>
          </div>
        <?php endif; ?>
        </div>
    </div>
    <script src="js/orders.js"></script>
</body>

</HTML>
