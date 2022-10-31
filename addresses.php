<?php

require_once('common.php');
if (isset($_SESSION['userInfo'])) :
  $userInfo = $_SESSION['userInfo'];
  $userID = $userInfo->userID;
  $values = [
    'userID' => $userID
  ];
  //echo $userID;
  $userAddress = $database->getAddress($values);
  if($_SESSION['userInfo']->privileges == 'Customer' || $_SESSION['userInfo']->privileges == 'Employee') :
    if(empty($userAddress)){
      if(isset($_POST['line1']) && isset($_POST['city']) && isset($_POST['state']) && isset($_POST['zipcode']) && isset($_POST['phone'])){
        $values = [
          'userID' => $userID,
          'line1' => $_POST['line1'],
          'line2' => $_POST['line2'],
          'city' => $_POST['city'],
          'state' => $_POST['state'],
          'zipcode' => $_POST['zipcode'],
          'phone' => $_POST['phone']
        ];
        $database->addAddress($values);
      }
    }

    if(!empty($userAddress)){
      if(isset($_POST['line1']) && isset($_POST['city']) && isset($_POST['state']) && isset($_POST['zipcode']) && isset($_POST['phone'])){
        if($_POST['line2'] == NULL){
          $values = [
            'userID' => $userID,
            'line1' => $_POST['line1'],
            'city' => $_POST['city'],
            'state' => $_POST['state'],
            'zipcode' => $_POST['zipcode'],
            'phone' => $_POST['phone']
          ];
        }
        else{
            $values = [
            'userID' => $userID,
            'line1' => $_POST['line1'],
            'line2' => $_POST['line2'],
            'city' => $_POST['city'],
            'state' => $_POST['state'],
            'zipcode' => $_POST['zipcode'],
            'phone' => $_POST['phone']
          ];
        }

        // echo $userID;
        $database->updateAddress($values);
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
      <h2 style="text-align:center;">Update Address</h2>
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <fieldset name="addressInfo">
        <?php if(empty($userAddress[0]->line1)) :?>
          <label for="line1">Street Address</label>
          <input type="text" placeholder="Line 1" name="line1" required value="">
        <?php endif; ?>
        <?php if(!empty($userAddress[0]->line1)) :?>
          <label for="">Street Address</label>
          <input type="text" placeholder="Line 1" name="line1" required value="<?php echo $userAddress[0]->line1; ?>">
        <?php endif; ?>
          <?php if(empty($userAddress[0]->line2)) : ?>
              <label for="">Street Address Line 2</label>
              <input type="text" name="line2" placeholder="Line 2">
          <?php if(!empty($userAddress[0]->line2)) : ?>
              <label for="">Street Address Line 2</label>
              <input type="text" placeholder="Line 2" name="line2" required value="<?php echo $userAddres[0]->line2; ?>">
          <?php endif; ?>
          <?php endif; ?>
          <?php if(empty($customerAddress[0]->city)) : ?>
              <label for="">City</label>
              <input type="text" placeholder="City" name="city" required value="">
          <?php endif; ?>
          <?php if(!empty($customerAddress[0]->city)) : ?>
              <label for="">City</label>
              <input type="text" placeholder="City" name="city" required value="<?php echo $userAddress[0]->city; ?>">
          <?php endif; ?>
          <?php if(empty($userAddress[0]->zipcode)) : ?>
              <label for="zipcode">Postal / Zip Code</label>
              <input type="text" placeholder="Zip Code" name="zipcode" required value="">
          <?php endif; ?>
          <?php if(!empty($userAddress[0]->zipcode)) : ?>
              <label for="zipcode">Postal / Zip Code</label>
              <input type="text" placeholder="Zip Code" name="zipcode" required value="<?php echo $userAddress[0]->zipcode?>">
          <?php endif; ?>
          <?php if(empty($userAddress[0]->phone)) : ?>
              <label for="phone">Phone Number</label>
              <input type="text" placeholder="Phone Number" name="phone" required value="">
          <?php endif; ?>
          <?php if(!empty($userAddress[0]->phone)) : ?>
              <label for="phone">Phone Number</label>
              <input type="text" placeholder="Phone Number" name="phone" required value="<?php echo $userAddress[0]->phone?>">
          <?php endif; ?>
          <label for="state">State</label>
          <select name="state" id="state">
            <?php if(!empty($userAddress[0]->state)) : ?>
              <option value=""><?php echo $userAddress[0]->state ?></option>
            <?php endif; ?>
            <?php if(empty($userAddress[0]->state)) : ?>
              <option value="" selected="selected">Select a State</option>
            <?php endif; ?>
              <option value="AL">Alabama</option>
              <option value="AK">Alaska</option>
              <option value="AZ">Arizona</option>
              <option value="AR">Arkansas</option>
              <option value="CA">California</option>
              <option value="CO">Colorado</option>
              <option value="CT">Connecticut</option>
              <option value="DE">Delaware</option>
              <option value="DC">District Of Columbia</option>
              <option value="FL">Florida</option>
              <option value="GA">Georgia</option>
              <option value="HI">Hawaii</option>
              <option value="ID">Idaho</option>
              <option value="IL">Illinois</option>
              <option value="IN">Indiana</option>
              <option value="IA">Iowa</option>
              <option value="KS">Kansas</option>
              <option value="KY">Kentucky</option>
              <option value="LA">Louisiana</option>
              <option value="ME">Maine</option>
              <option value="MD">Maryland</option>
              <option value="MA">Massachusetts</option>
              <option value="MI">Michigan</option>
              <option value="MN">Minnesota</option>
              <option value="MS">Mississippi</option>
              <option value="MO">Missouri</option>
              <option value="MT">Montana</option>
              <option value="NE">Nebraska</option>
              <option value="NV">Nevada</option>
              <option value="NH">New Hampshire</option>
              <option value="NJ">New Jersey</option>
              <option value="NM">New Mexico</option>
              <option value="NY">New York</option>
              <option value="NC">North Carolina</option>
              <option value="ND">North Dakota</option>
              <option value="OH">Ohio</option>
              <option value="OK">Oklahoma</option>
              <option value="OR">Oregon</option>
              <option value="PA">Pennsylvania</option>
              <option value="RI">Rhode Island</option>
              <option value="SC">South Carolina</option>
              <option value="SD">South Dakota</option>
              <option value="TN">Tennessee</option>
              <option value="TX">Texas</option>
              <option value="UT">Utah</option>
              <option value="VT">Vermont</option>
              <option value="VA">Virginia</option>
              <option value="WA">Washington</option>
              <option value="WV">West Virginia</option>
              <option value="WI">Wisconsin</option>
              <option value="WY">Wyoming</option>
            </select>
        </fieldset>
        <fieldset name="addressInfo">
          <input type="hidden" name="userID" value="<?php echo $userInfo->userID ?>">
        </fieldset>
        <input type="submit" value="Update Address Information">
          <div class="cancel-button">Cancel</div>
        </a>
  </div>
  </form>
<?php endif; ?>
<?php endif; ?>
</div>
</body>

</HTML>
