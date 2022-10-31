<?php

/**
 * @file
 * This is the main index page for the site.
 */

require_once('common.php');
if (isset($_POST['orderID']) && isset($_POST['orderStatus'])) {
	$values = [
		'orderID' => $_POST['orderID'],
		'orderStatus' => $_POST['orderStatus']
	];
	$database->updateOrderStatus($values);
}
if (isset($_POST['orderID']) && $userInfo->privileges == 'Admin') {
	$_SESSION['orderID'] = $_POST['orderID'];
	header("Location: assign.php");
}
if (isset($_SESSION['userInfo'])) {
	$userInfo = $_SESSION['userInfo'];
	if ($userInfo->privileges == 'Admin') {
		//$allOrderInfo = $database->showAllOrders($userInfo);
	} else if ($userInfo->privileges == 'Employee') {
		$assignedRequest = $database->getAssignedRequest($userInfo->userID);
	} else {
		$customerActiveOrderInfo = $database->showCustomerActiveOrders($userInfo);
		$customerPastOrders = $database->showPastCustomerOrders($userInfo);
		$petData = $database->showPetsByCustomer($userInfo);
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
<div class="bgimg-1">
		<div class="caption">
			<span class="border">Pet Best LLC</span>
		</div>

		<?php require_once("menu.php") ?>
		<?php require_once("sideBar.php") ?>
	</div>





	<div class="main">



		<!-- <div style="color: #777;background-color:white;text-align:center;padding:50px 80px;text-align: justify;"> -->

		<?php if (isset($userInfo)) : ?>
			<!-- <div id="flex-card"> -->
			<!-- <div class="card"> -->



			<h2 class="mobile"> Welcome, <?php echo $userInfo->firstName . ' ' . $userInfo->lastName ?>!</h2>
			<p class="mobile">   <?php echo $userInfo->email ?> </p><br>



			<?php if (isset($customerActiveOrderInfo)) : ?>
				<h2 class="customerinfo-title">Active Orders</h2>
				<div id="customerinfo-flex">
					<?php foreach ($customerActiveOrderInfo as $value) : ?>
						<div class="customerinfo-card">
							<p class="customerinfo-details"><?php echo $value->servicename; ?></p>
							<p class="customerinfo-details"><?php echo $value->serviceDateRequest; ?></p>
							<p class="customerinfo-details"><?php echo $value->orderDate; ?></p>
							<p class="customerinfo-details"><?php echo $value->orderStatus; ?></p>
							<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
								<input type="hidden" name="orderID" value=<?php echo $value->orderID; ?>>
								<input type="hidden" name="orderStatus" value="Cancelled">
								<input class="cancel" type="submit" value="Cancel">
							</form>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<?php if (isset($petData)) : ?>
				<h2 class="customerinfo-title">Pets</h2>
				<div id="customerinfo-flex">
					<?php foreach ($petData as $value) : ?>
						<div class="customerinfo-card">
							<p class="customerinfo-details"><?php echo $value->fullName; ?></p>
							<p class="customerinfo-details"><?php echo $value->birthdate; ?></p>
							<p class="customerinfo-details"><?php echo $value->color; ?></p>
							<p class="customerinfo-details"><?php echo $value->weight . "lbs"; ?></p>
							<p class="customerinfo-details"><?php echo $value->breed; ?></p>
							<form method="post" action="updatePetInfo.php">
							<input type="hidden" name="petID" value="<?php echo $value->petID;?>">
							<input class="cancel" type="submit" value="Edit">
							</form>
						</div>
					<?php endforeach; ?>
				</div>
				</table>
			<?php endif; ?>

			<?php if (isset($customerPastOrders)) : ?>
				<h2 class="customerinfo-title">Past Orders</h2>
				<div id="customerinfo-flex">
					<?php foreach ($customerPastOrders as $value) : ?>
						<div class="customerinfo-card">
							<p class="customerinfo-details"><?php echo $value->servicename; ?></p>
							<p class="customerinfo-details"><?php echo $value->serviceDateRequest; ?></p>
							<p class="customerinfo-details"><?php echo $value->orderDate; ?></p>
							<p class="customerinfo-details"><?php echo $value->orderStatus; ?></p>
							</form>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

		<?php endif; ?>













	</div>







</body>

</HTML>
