<?php

/**
 * @file
 * This is the main index page for the site.
 */

require_once('common.php');

if (isset($_SESSION['userInfo'])) {
	$userInfo = $_SESSION['userInfo'];
}
	$values = ['categoryID' => 3];
	$serviceInfoArray = $database->getPricesByCategoryID($values);
?>




<!DOCTYPE HTML>
<HTML lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width = device-width, initial-scale = 1.0, user-scalable = 1;">
	<link rel="stylesheet" type="text/css" href="css/bestPet.css">
	<link rel="stylesheet" type="text/css" href="css/compare.css">
	<title>Pet Best, LLC</title>
</head>

<body>
<div class="alert">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
  <strong>COVID-19 Alert!</strong> If you feel sick please cancel your appointment in advance.
</div>
    <div class="bgimg-6">
        <div class="caption">
            <span class="border">Clean Up For Your Other Little Critters</span>
        </div>
			<!-- Menu for site -->
			<?php require_once("menu.php") ?>
	</div>



	<div style="color: #777;background-color:white;text-align:center;padding:50px 80px;text-align: justify;">
		<div class="comparison">

			<table>
				<thead>
					<tr>
						<th colspan="<?php echo count($serviceInfoArray); ?>" class="qbo">
							Critter Clean Up
						</th>
					</tr>
					<tr>
						<?php foreach ($serviceInfoArray as $value) : ?>
							<th class="compare-heading">
								<?php echo $value->servicename; ?>
							</th>
						<?php endforeach; ?>
					</tr>
					<tr>
						<?php foreach ($serviceInfoArray as $value) : ?>
							<?php if ($value->price != 0.00) : ?>
							<th class="price-info">
								<div class="price-now"><span><?php echo $value->price; ?><span class="price-small"></span></span> each way</div>
								<div><a href="serviceform.php" class="price-buy">Request Service <span class="hide-mobile"></span></a></div>
								<div class="price-try"><span class="hide-mobile">or </span><a href="register.php">Register <span class="hide-mobile"></span></a></div>
							</th>
							<?php else: ?>
								<th class="price-info">
								<div class="price-now"><span>Varies By Order<span class="price-small"></span></span></div>
								<div><a href="serviceform.php" class="price-buy">Request Service <span class="hide-mobile"></span></a></div>
								<div class="price-try"><span class="hide-mobile">or </span><a href="register.php">Register <span class="hide-mobile"></span></a></div>
							</th>
							<?php endif;?>
						<?php endforeach; ?>
					</tr>
				</thead>
			</table>
	</div>



	<div style="position:relative">
		<div style="color:#ddd;background-color:#292E34;text-align:center;padding:50px 80px;">

		</div>
	</div>

</body>

</HTML>
