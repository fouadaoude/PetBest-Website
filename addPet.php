<?php

/**
 * @file
 * This is the add pet page for the site.
 */

require_once('common.php');

// print_r($_POST);

if (isset($_SESSION['userInfo']))
{
$userInfo = $_SESSION['userInfo'];
}
if (isset($_POST['birthdate']) && isset($_POST['breed']) && isset($_POST['userID']) && isset($_POST['fullname']) && isset($_POST['pweight']) && isset($_POST['color'])){
	$userID = filter_var($_POST['userID'], FILTER_SANITIZE_STRING);
	$birthdate = filter_var($_POST['birthdate'], FILTER_SANITIZE_STRING);
	$breed = filter_var($_POST['breed'], FILTER_SANITIZE_STRING);
	$fullname = filter_var($_POST['fullname'], FILTER_SANITIZE_STRING);
	$pweight = filter_var($_POST['pweight'], FILTER_SANITIZE_STRING);
	$color = filter_var($_POST['color'], FILTER_SANITIZE_STRING);

	$pValues = [
		'userID' => $userID,
		'birthdate' => $birthdate,
		'breed' => $breed,
		'fullname' => $fullname,
		'pweight' => $pweight,
		'color' => $color
	];

	$response = $database->createPet($pValues);
	// $petInfo['result'] = $response[0]['result'];
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

	<div class="bgimg-1">
		<div class="caption">
			<span class="border">Pet Best LLC</span>
		</div>

		<?php require_once("menu.php") ?>
		<?php require_once("sideBar.php") ?>
	</div>






<div class = "main">
		<h3 style="text-align:center;">Add a Pet</h3>
				<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<label for="fullname">Pet Name</label>
					<input type ="text" id="fullname" name="fullname" required><br>
					<input type ="hidden" name ="userID" value =<?php echo $userInfo->userID; ?>>

					<!-- <label>Pet Species</label><br> -->
					<!-- <select id="species">
						<option value="" disabled selected>Select</option>
						<option value="dog">Dog</option>
						<option value="cat">Cat</option>
					</select><br> -->

					<label for="">Birthdate</label>
					<input type="date" name="birthdate" required><br>

					<label for="breed">Breed</label>
					<input type="text" id="breed" name="breed" required><br>

					<label for="color">Color</label>
					<input type="text" id="color" name="color" required><br>

					<label for="pweight">Weight</label>
					<input type="text" id="pweight" name="pweight" required><br>


				<button type="submit" class="button">Add Pet</button>
				<br>


	</form>
	</div>



</body>

</HTML>
