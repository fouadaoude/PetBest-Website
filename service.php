<?php

/**
 * @file
 * This is the main index page for the site.
 */

require_once('common.php');

if (isset($_POST['userID']) && isset($_POST['categoryID']) && isset($_POST['appointment']) && isset($_POST['time'])){
  $userID = $_POST['userID'];
  $categoryID = $_POST['categoryID'];
  $serviceID = $_POST['serviceID'];
  $appointmentDate = $_POST['appointment'];
  $appointmentTime = $_POST['time'];
  $appointmentDate = $appointmentDate . " " . $appointmentTime;
  $orderValues = [
    'userID' => $userID,
    'categoryID' => $categoryID,
    'serviceID' => $serviceID,
    'appointmentDate' => $appointmentDate
  ];
  $passfail = $database->submitOrder($orderValues);
}
if (isset($_SESSION['userInfo'])) {
  $userInfo = $_SESSION['userInfo'];
}
// if (!empty($_POST)){
//   print_r($_POST);
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/service.css">
  <link rel="stylesheet" type="text/css" href="css/bestPet.css">
  <link rel="stylesheet" type="text/css" href="css/sideBar.css">
  <title>Service Request</title>
</head>

<body>
  <!-- Menu for site -->

  <div class="bgimg-1">
		<div class="caption">
			<span class="border">Request Service</span>
		</div>

		 <?php require_once("menu.php") ?>
  <?php if (isset($userInfo)) : ?>
    <?php require_once("sideBar.php") ?>
  <?php endif; ?>

	</div>


  <div id="full-page">
    <div class="service-card">
      <div id="bg1"></div>
      <fieldset>
        <legend>Service Request</legend>
        <?php if (isset($message)) : ?>
          <h1><?php echo $message ?></h1>
        <?php endif; ?>
        <form method="post" class="flex" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <label for="name">Firstname</label>
          <input type="text" id="name" placeholder="First Name" required value=<?php if (isset($userInfo)) echo $userInfo->firstName; ?>><br><br>
          <label for="name">Lastname</label>
          <input type="text" id="name" placeholder="Last Name" required value=<?php if (isset($userInfo)) echo $userInfo->lastName; ?>><br><br>

          <input type="hidden" name="userID" value=<?php if (isset($userInfo)) echo $userInfo->userID; ?>>

          <label for="category">Service Category</label>
          <select id="category" name="categoryID" required>
            <option value="" disabled selected>Select your option</option>
            <option value="1">Clean-up (Dog)</option>
            <option value="2">Clean-up (Cat)</option>
            <option value="3">Clean-up (Other)</option>
            <option value="4">Transport</option>
            <option value="5">Care Services (Dog)</option>
            <option value="6">Care Services (Cat)</option>
          </select> <br><br>


          <label for="type" id="type" class="dogclean active">What To Clean</label>
          <select id="type" name="serviceID" class="dogclean selectbox active" required>
            <option value="" disabled selected>Select your option</option>
            <option value="1">Yard Clean-Up</option>
            <option value="2">Special Occassion</option>
          </select>

          <label for="type1" id="type1" class="catclean">What To Clean</label>
          <select id="type1" name="serviceID" class="catclean selectbox" required>
            <option value="3">Litter Cleaning</option>
          </select>

          <label for="type2" id="type2" class="smallclean">What To Clean</label>
          <select id="type2" name="serviceID" class="smallclean selectbox" required>
            <option value="4">Cage Cleaning</option>
          </select>

          <label for="type3" id="type3" class="transport">Transport To/From</label>
          <select id="type3" name="serviceID" class="transport selectbox" required>
            <option value="5">Doggie Day Care</option>
            <option value="6">Vet Appointment</option>
            <option value="7">Training Appointment</option>
            <option value="8">Groomer Appointment</option>
            <option value="9">Puppies from Breeder</option>
            <option value="17">Other</option>
          </select>

          <label for="type4" id="type4" class="dogcare">Kind Of Care</label>
          <select id="type4" name="serviceID" class="dogcare selectbox" required>
            <option value="10">Walking</option>
            <option value="11">Dog/House Sitting</option>
            <option value="12">PlayTime</option>
            <option value="13">Food/Treat Deliver</option>
            <option value="14">Park Adventure</option>
          </select>

          <label for="type5" id="type5" class="catcare">Kind Of Care</label>
          <select id="type5" name="serviceID" class="catcare selectbox" required>
            <option value="15">Cat/House Sitting</option>
            <option value="16">Food/Treat Delivery</option>
          </select>

          <br><br>

          <label for="appointmentdate">Appointment Date</label>
          <input type="date" id="appointmentdate" name="appointment" min=<?php echo date('Y-m-d', strtotime("+5 days")) ?> max=<?php echo date('Y-m-d', strtotime("+1 year")) ?> required>
          <select id="time" name="time">
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
          <input type="submit" value="Submit">
      </fieldset>



      </form>
    </div>
  </div>
  <!-- <script src="js/servicechanges.js"></script> -->
</body>

</html>
