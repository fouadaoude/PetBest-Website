<?php

/**
 * @file
 * This is the main index page for the site.
 */

require_once('common.php');
$categories = $database->showAllServices()['categories'];
if (isset($_GET['c'])) {
  $categoryID = filter_var($_GET['c'], FILTER_SANITIZE_STRING);
  $values = ['categoryID' => $categoryID];
  $services = $database->getServicesByCategoryID($values)['result'];
}
if (isset($_POST['userID']) && isset($_POST['serviceID']) && isset($_POST['appointment']) && isset($_POST['time'])) {
  $userID = $_POST['userID'];
  $serviceID = $_POST['serviceID'];
  $notes = filter_var($_POST['notes'], FILTER_SANITIZE_STRING);
  $appointmentDate = $_POST['appointment'];
  $appointmentTime = $_POST['time'];
  $appointmentDate = $appointmentDate . " " . $appointmentTime;
  $orderValues = [
    'userID' => $userID,
    'serviceID' => $serviceID,
    'appointmentDate' => $appointmentDate,
    'notes' => $notes
  ];
  $passfail = $database->submitOrder($orderValues);
  header("Location: profile.php");
}
if (isset($_SESSION['userInfo'])) {
  $userInfo = $_SESSION['userInfo'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/form.css">
  <link rel="stylesheet" type="text/css" href="css/bestPet.css">
  <link rel="stylesheet" type="text/css" href="css/sideBar.css">
  <title>Service Request</title>
</head>

<body>


<div class="bgimg-1">
		<div class="caption">
			<span class="border">Pet Best LLC</span>
		</div>
<!-- Menu for site -->
  <?php require_once("menu.php") ?>
  <?php if (isset($userInfo)) : ?>
    <?php require_once("sideBar.php") ?>
  <?php endif; ?>
	</div>


  <div class="main">
    <?php if (isset($userInfo)) : ?>
      <h2 style="text-align:center;">Request Service</h2>
      <fieldset id="services">
        <!-- <label for="">Customer Name</label>
        <input type="text" placeholder="Enter Name" required value="<?php echo $userInfo->firstName . ' ' . $userInfo->lastName; ?>"> -->
        <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <label for="service" style="float:none;">Category</label>
          <select id="service" style="padding: .5em 0em .5em 0em;margin-bottom:.4em;" name="c">
            <?php foreach ($categories as $value) : ?>
              <option value="<?php echo $value->categoryID; ?>"><?php echo $value->categoryname; ?></option>
            <?php endforeach ?>
            <input style="width:15vh;" class="cat-button" type="submit" value="Find Services">
        </form>
        </select>
        <form method="post" class="flex" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <?php if (isset($services)) : ?>
            <label for="service" style="float:none;">Service</label>
            <select id="service" style="padding: .5em 0em .5em 0em;" name="serviceID">
              <?php foreach ($services as $value) : ?>
                <option value="<?php echo $value->serviceID; ?>"><?php echo $value->servicename; ?></option>
              <?php endforeach ?>
            </select><br>
            <label for="requestDate" style="float:left;width:100%;">Service Date & Time</label>
            <input type="date" id="requestDate" placeholder="YYYY-MM-DD" style="margin-bottom:.4em;" name="appointment" required min=<?php echo date('Y-m-d', strtotime("+5 days")) ?> max=<?php echo date('Y-m-d', strtotime("+1 year")) ?>>
            <select id="service" style="padding:.5em 0em .5em 0em;" name="time">
              <option value="05:00:00">5:00AM</option>
              <option value="05:30:00">5:30AM</option>
              <option value="06:00:00">6:00AM</option>
              <option value="06:30:00">6:30AM</option>
              <option value="07:00:00">7:00AM</option>
              <option value="07:30:00">7:30AM</option>
              <option value="08:00:00">8:00AM</option>
              <option value="08:30:00">8:30AM</option>
              <option value="09:00:00">9:00AM</option>
              <option value="09:30:00">9:30AM</option>
              <option value="10:00:00">10:00AM</option>
              <option value="10:30:00">10:30AM</option>
              <option value="11:00:00">11:00AM</option>
              <option value="11:30:00">11:30AM</option>
              <option value="12:00:00">12:00PM</option>
              <option value="12:30:00">12:30PM</option>
              <option value="13:00:00">1:00PM</option>
              <option value="13:30:00">1:30PM</option>
              <option value="14:00:00">2:00PM</option>
              <option value="14:30:00">2:30PM</option>
              <option value="15:00:00">3:00PM</option>
              <option value="15:30:00">3:30PM</option>
              <option value="16:00:00">4:00PM</option>
              <option value="16:30:00">4:30PM</option>
              <option value="17:00:00">5:00PM</option>
              <option value="17:30:00">5:30PM</option>
              <option value="18:00:00">6:00PM</option>
              <option value="18:30:00">6:30PM</option>
              <option value="19:00:00">7:00PM</option>
              <option value="19:30:00">7:30PM</option>
              <option value="20:00:00">8:00PM</option>
            </select>
            <br><br>
            <input type="hidden" name="userID" value="<?php echo $userInfo->userID ?>">
            <label for="notes">Notes</label>
            <textarea id="notes" name="notes" row="4" cols="50"></textarea>
          <?php endif; ?>
          <input type="submit" value="Submit Order">
        </form>
      </fieldset>
    <?php else : ?>
    <script>
    window.location = 'oops.php';
</script>
    <?php endif; ?>
    <!-- <a href="profile.php">
        <div class="cancel-button">Cancel</div>
      </a> -->
    <!-- <script src="js/servicechanges.js"></script> -->
  </div>
</body>

</html>
