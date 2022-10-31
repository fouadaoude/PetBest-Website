<?php

/**
 * @file
 * This is the main index page for the site.
 */

require_once('common.php');
if (isset($_SESSION['userInfo'])) {
	$userInfo = $_SESSION['userInfo'];
}

?>

<?php
  if($_POST){
    $_SESSION['firstName']= $_POST['firstName'];
    $_SESSION['lastName']= $_POST['lastName'];
    $_SESSION['email']= $_POST['email'];
    echo

  }
  ?>



<body>

<form action="test2.php" method="POST">

<input type="text" name="firstName" placeholder="First Name"><br><br>
<input type="text" name="lastName" placeholder="Last Name"><br><br>
<input type="text" name="email" placeholder="Email"><br><br>
<input type="submit" value="Next Step">

</form>


<!DOCTYPE HTML>
<HTML lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="keywords" content="Welcome">
	<meta name="description" content="redirect, welcome page">
	<link rel="stylesheet" type="text/css" href="css/bestPet.css">
	<link rel="stylesheet" type="text/css" href="css/card.css">

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Mobile viewport -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">


	<title>Best Pet LLC - Welcome</title>
</head>

<?php require_once("menu.php") ?>

<body>

<form action="test2.php" method="POST">
<input type="text" name="firstName" placeholder="First Name"><br><br>
<input type="text" name="lastName" placeholder="Last Name"><br><br>
<input type="text" name="email" placeholder="Email"><br><br>
<input type="submit" value="Next Step">

</form>



</body>

</HTML>
