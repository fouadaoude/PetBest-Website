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

	<div class="bgimg-1">
		<div class="caption">
			<span class="border">Best Pet LLC</span>



		</div>


	</div>

	<script>
		//This is for the Menu Drop Down
		/* When the user clicks on the button,
		toggle between hiding and showing the dropdown content */
		function myFunction() {
			document.getElementById("myDropdown").classList.toggle("show");
		}

		// Close the dropdown if the user clicks outside of it
		window.onclick = function(e) {
			if (!e.target.matches('.dropbtn')) {
				var myDropdown = document.getElementById("myDropdown");
				if (myDropdown.classList.contains('show')) {
					myDropdown.classList.remove('show');
				}
			}
		}
	</script>
	<script>
		//This is for the hours drop down
		/* When the user clicks on the button,
		toggle between hiding and showing the dropdown content */
		function myFunction2() {
			document.getElementById("hoursDropdown").classList.toggle("show");
		}

		// Close the dropdown if the user clicks outside of it
		window.onclick = function(e) {
			if (!e.target.matches('.dropbtn')) {
				var hoursDropdown = document.getElementById("hoursDropdown");
				if (hoursDropdown.classList.contains('show')) {
					hoursDropdown.classList.remove('show');
				}
			}
		}
	</script>

	<script>
		//not yet working
		window.onscroll = function() {
			stickyFunction()
		};

		var navbar = document.getElementById("navbar");
		var sticky = navbar.offsetTop;

		function stickyFunction() {
			if (window.pageYOffset >= sticky) {
				navbar.classList.add("sticky")
			} else {
				navbar.classList.remove("sticky");
			}
		}
	</script>
	</div>


<style>

		.img1 {
			float: left;
		}

		.clearfix {
			overflow: auto;
		}

		.img2 {
			float: right;
		}
</style>


	<div style="position:relative">
		<div style="color:#ddd;background-color:#292E34;text-align:center;padding:50px 80px;">

		</div>
	</div>

	<div style="color: #777;background-color:white;text-align:center;padding:50px 80px;text-align: justify;">

			<h3 style="text-align:center;">About Us</h3>



			<div class="flex">
					<div class="card">
						<img src="images/hamster.jpeg" alt="Hamster">
						<div class="container">
							<h3 style="text-align:center;">Who We Are</h3>
							<p>We are a full service pet care company for when you need a little help caring for your four legged friends.</p>
						</div>
					</div>

					<div class="card">
									<img src="images/dog2.jpg" alt="Dog2">
									<div class="container">
											<h3 style="text-align:center;">Why Us</h3>
										<p>	At Pet Best, we understand that life can get busy. We're here to help you fill in the gaps so that you never have to choose
											between self care, and care for your best friend.</p>
									</div>
						</div>
			</div>






						<div class="clearfix">

						</div>

		</div>





	</div>




	<div class="bgimg-2">
		<div class="caption">
			<span class="border" style="background-color:transparent;font-size:25px;color: #f7f7f7;">Gentle care for your best friend.</span>
		</div>
	</div>

	<div style="position:relative">

		<div style="color: #777;background-color:white;text-align:center;padding:50px 80px;text-align: justify;">

			<h3 style="background-color: #777; text-align:center;">Services</h3>

		<div class="flex">
				<div class="card">
									<img src="images/dogincar.jpg" alt="Dog In Car">
									<div class="container">
											<h3 style="text-align:center;">Transportation</h3>
										<p>	We'll take your pet to and from their vet visit. <br>We'll even stay with them through the appointment! <a href="transportation.php">Learn more...</a></p>
									</div>
						</div>

				<div class="card">
									<img src="images/walkDog.jpeg" alt="Walk Dog">
									<div class="container">
											<h3 style="text-align:center;">Care For Dogs</h3>
										<p>	Dog Walking, dog sitting, play time, socialization at your local dog park, weekly food and treat delivery. <a href="carefordogs.php">Learn more...</a></p>

									</div>
						</div>

				<div class="card">
									<img src="images/dog4.jpg" alt="Dog">
									<div class="container">
											<h3 style="text-align:center;">Clean Up For Dogs</h3>
										<p>	Yard clean up, weekly waste removal, spring "thaw" clean up. <a href="dogcleanup.php">Learn more...</a></p>

									</div>
						</div>
		</div>

		<div class="flex">
				<div class="card">
									<img src="images/cat4.jpg" alt="Cat">
									<div class="container">
											<h3 style="text-align:center;">Care For Cats</h3>
										<p>Cat and house sitting, weekly food and treat delivery. <a href="careforcats.php">Learn more...</a></p>

									</div>
						</div>

				<div class="card">
									<img src="images/catcleanup.jpeg" alt="Cat">
									<div class="container">
											<h3 style="text-align:center;">Clean Up For Cats</h3>
										<p>Cat and house sitting, weekly food and treat delivery. <a href="catcleanup.php">Learn more...</a></p>

									</div>
						</div>



				<div class="card">
									<img src="images/ferret.jpg" alt="Critters">
									<div class="container">
											<h3 style="text-align:center;">Clean Up For Your Other Little Critters</h3>
										<p>Cage cleaning for small animals. We provide bedding of your choice. <a href="crittercleanup.php">Learn more...</a></p>

									</div>
						</div>
		</div>







		</div>
	</div>

	<div class="bgimg-4">
	</div>



	<footer>
		<div style="position:relative">
			<div style="color:#ddd;background-color:#292E34;text-align:center;padding:15px 80px;">
				Copyright 2020
			</div>
		</div>
	</footer>
</body>

</HTML>
