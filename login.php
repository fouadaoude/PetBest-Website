<?php

/**
 * @file
 * This is the main index page for the site.
 */
require_once('common.php');
if (isset($_POST['username']) && isset($_POST['password'])) {

    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

    $values = [
        'username' => $username,
        'password' => $password
    ];

    $userInfo = $database->login($values);

    if (!empty($userInfo['result'])) {
        $_SESSION['userInfo'] = $userInfo['result'];
        header("Location: profile.php");
    } else {
        $error = "The username or password was incorrect";
    }
}


if (isset($_SESSION['userInfo'])) {
	$userInfo = $_SESSION['userInfo'];
	if ($userInfo->privileges == 'admin') {
		$allOrderInfo = $database->showAllOrders($userInfo);
	} else if ($userInfo->privileges == 'Employee'){
		$assignedRequest = $database->getAssignedRequest($userInfo->userID);
	}
	else {
		$customerOrderInfo = $database->showCustomerActiveOrders($userInfo);
	}
}
if (isset($_POST['species']) && isset($_POST['birthdate']) && isset($_POST['breed'])) {
	$species = filter_var($_POST['species'], FILTER_SANITIZE_STRING);
	$birthdate = filter_var($_POST['birthdate'], FILTER_SANITIZE_STRING);
	$breed = filter_var($_POST['breed'], FILTER_SANITIZE_STRING);

	$pValues = [
		'species' => $species,
		'birthdate' => $birthdate,
		'breed' => $breed
	];

	$response = $database->createPet($pValues);
	$petInfo['result'] = $response[0]['result'];
}

?>



<!DOCTYPE HTML>
<HTML lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="keywords" content="signin, petbest">
    <meta name="description" content="sign in page ">
    <link rel="stylesheet" type="text/css" href="css/bestPet.css">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width = device-width, initial-scale = 1.0, user-scalable = 1;">
    <title>Pet Best LLC</title>
</head>

<body>



    <?php require_once("menu.php") ?>
    </div>



    <script>
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

    <div class="bgimg-1">
        <div class="caption">
            <span class="border">Pet Best LLC</span>
        </div>
    </div>

    <div style="color: #777;background-color:white;text-align:center;padding:50px 80px;text-align: justify;">

        <h3 style="text-align:center;">Sign In</h3>
    </div>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div style="color: #777;background-color:white;text-align:center;padding:1px 80px;text-align: justify;" class="form">

            <p>Please sign in below.</p>
            <hr>
            <table>
                <tr>
                    <td>
                        <label for="username"><b>Username</b></label>
                    </td>
                    <td>
                        <input type="text" style="text-align:center;" placeholder="Enter Username" name="username" required><br>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="password"><b>Password</b></label>
                    </td>
                    <td>
                        <input type="password" style="text-align:center;" placeholder="Enter Password" name="password" required><br>
                    </td>
                </tr>
                <?php if (isset($error)) : ?>
                    <p style="color:red;"><?php echo $error ?></p>
                <?php endif; ?>


            </table>
            <hr>
            <input type="submit" class="button" value="Sign In"></input>
    </form>
    <br>
    <p>Need an account? <a href="register.php">Register</a>.</p>

    </div>

    <div class="bgimg-2">
        <div class="caption">
            <span class="border" style="background-color:transparent;font-size:25px;color: #f7f7f7;">Gentle care for your best friend.</span>
        </div>
    </div>

    <div style="position:relative">
        <div style="color:#ddd;background-color:#292E34;text-align:center;padding:50px 80px;">

        </div>
    </div>







</body>

</HTML>
