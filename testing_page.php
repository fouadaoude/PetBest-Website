<?php
require_once('common.php');

// $values = [
//   'orderID' => 1
// ];
// $orderValues = [
//   'userID' => '12',
//   'categoryID' => '4',
//   'serviceID' => '15',
//   'appointmentDate' => '2020-04-21'
// ];
$values = [
  'orderID' => 2,
];
// $val = $database->getOrderByOrderID($values);
// print_r($val);
//$userInfo = $database->login($values);
//$userInfo['result']->token = $database->createToken($userInfo);
//$tokenUserInfo = $database->checkToken($userInfo['result']->token);
// $passfail = $database->submitOrder($orderValues);
//  $database->emailReceipt($values);

$newvalues = [
  'orderID' => 2,
  'userID' => 1,
  'orderTotal' => 100,
  'notes' => "Great Guy",
  'servicename' => "Dog Play",
  'paymentTotal' => 75,
  'dateOfCompletion' => "2020-05-08"
];
//  $database->emailInvoice($newvalues);


// print_r($invoiceStuff);

?>
