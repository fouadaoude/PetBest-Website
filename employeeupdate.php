<?php

require_once('common.php');
if (isset($_SESSION['userInfo'])) {
  $userInfo = $_SESSION['userInfo'];
  if (isset($_POST['orderID'])) {
    $values = ['orderID' => $_POST['orderID']];
    $orderInfo = $database->getOrderUpdateInfo($values)['result'];
  }
  if (isset($_POST['dateOfCompletion']) && isset($_POST['orderStatus']) && isset($_POST['orderID']) && isset($_POST['orderTotal']) && isset($_POST['paymentTotal'])) {
    $values = [
      'orderID' => $_POST['orderID'],
      'userID' => $_POST['userID'],
      'orderStatus' => $_POST['orderStatus'],
      'orderTotal' => $_POST['orderTotal'],
      'paymentTotal' => $_POST['paymentTotal'],
      'dateOfCompletion' => $_POST['dateOfCompletion'],
      'notes' => $_POST['notes'],
      'servicename' => $_POST['servicename']
    ];

    $database->orderUpdate($values);

    if($_POST['orderTotal'] == $_POST['paymentTotal']){
      $database->emailReceipt($values);
    }
    else{
      $database->emailInvoice($values);
    }
    header("Location: activejobs.php");
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
      <h2 style="text-align:center;">Order Complete Form</h2>
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <fieldset name="paymentInfo">
          <label for="">Customer Name</label>
          <input type="text" placeholder="Enter Name" required value="<?php echo $orderInfo->firstName . " " . $orderInfo->lastName; ?>">
          <label for="">Customer Email</label>
          <input type="text" placeholder="Enter Email" required value="<?php echo $orderInfo->email; ?>">
          <label for="">Category Name</label>
          <input type="text" placeholder="Enter Category Name" required value="<?php echo $orderInfo->categoryname; ?>">
          <label for="servicename">Service Name</label>
          <input type="text" placeholder="Enter Service Name" name="servicename" required value="<?php echo $orderInfo->servicename; ?>">
          <label for="dateOfCompletion">Date of Completion</label>
          <input type="date" placeholder="YYYY-MM-DD" name="dateOfCompletion" required value=<?php echo date('Y-m-d'); ?>>
        </fieldset>
        <fieldset name="cardInfo">
          <label for="status">Order Status</label>
          <select id="status" name="orderStatus">
            <option value="Complete" selected>Complete</option>
            <option value="Cancelled">Cancelled</option>
          </select>
          <input type="hidden" name="orderID" value="<?php echo $orderInfo->orderID ?>">
          <input type="hidden" name="userID" value="<?php echo $orderInfo->userID ?>">

          <label for="orderTotal">Total Price</label>
          <input type="number" id="orderTotal" placeholder="Enter Total" name="orderTotal" value=<?php echo $orderInfo->price; ?> required>
          <label for="paymentTotal">Amount Paid</label>
          <input type="number" id="paymentTotal" placeholder="Enter Amount Paid" name="paymentTotal" required>
        </fieldset>
        <label for="notes">Notes</label>
        <textarea id="notes" name="notes" row="4" cols="50"></textarea>
        <input type="submit" value="Submit Order Update">
        <a href="activejobs.php">
          <div class="cancel-button">Cancel</div>
        </a>
  </div>
  </form>
<?php endif; ?>
</div>
</body>

</HTML>
