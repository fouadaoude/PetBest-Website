if (isset($_SESSION['userInfo'])) {
	$userInfo = $_SESSION['userInfo'];
	if ($userInfo->privileges == 'admin') {
		$allOrderInfo = $database->showAllOrders($userInfo);
	} else if ($userInfo->privileges == 'Employee'){
		$assignedRequest = $database->getAssignedRequest($userInfo->userID);
	}
	else {
		$customerOrderInfo = $database->showCustomerOrders($userInfo);
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
