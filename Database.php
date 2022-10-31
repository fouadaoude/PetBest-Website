<?php

namespace PetBest;

use mysqli_sql_exception;
use \PDO;
use PDOException;

/**
 * Defines the Pet Best Database Service API.
 */
class Database implements DatabaseInterface {

  /**
   * Stores the PDO object.
   *
   * @var \PDO $pdo
   */
  private $pdo;

  /**
   * {@inheritdoc}
   */
  public static function create(PDO $pdo) {
    return new static($pdo);
  }

  /**
   * Initialize a new object.
   *
   * @param \PDO $pdo
   *   The Database connection.
   */
  public function __construct(PDO $pdo) {
    $this->pdo = $pdo;
  }

  /**
   * {@inheritdoc}
   */
  public function login($values) {

    if (isset($values['token'])){
       return $this->checkToken($values['token']);
    }

    $username = !empty($values['username']) ? $values['username'] : NULL;
    $password = !empty($values['password']) ? $values['password'] : NULL;

    // @todo: Query the database for a user with matching credentials.
    $query = "SELECT * FROM users
    where username = :username AND password = sha1(:password)";
    $statement = $this->pdo->prepare($query);

    $parameters = [
      ':username' => $username,
      ':password' => $password
    ];

    $statement->execute($parameters);
    $userInfo = $statement->fetchAll(PDO::FETCH_CLASS, '\stdClass');

    //if the array is empty, then go into if statement and return null
    if (!empty($userInfo)){
      $userInfo = reset($userInfo);
      unset($userInfo->password);
      return ['result' => $userInfo];
    }
    else{
      return ['error' => 'Login Failed' ];
    }

  }

  /**method="post"
   * {@inheritdoc}
   */
  public function createPet($petValues){
    $userID = !empty($petValues['userID']) ? $petValues['userID'] : NULL;
    $fullname = !empty($petValues['fullname'])? $petValues['fullname']:NULL;
    $birthdate = !empty($petValues['birthdate']) ? $petValues['birthdate'] : NULL;
    $color = !empty($petValues['color']) ? $petValues['color'] : NULL;
    $pweight = !empty($petValues['pweight']) ? $petValues['pweight'] : NULL;
    $breed = !empty($petValues['breed']) ? $petValues['breed'] : NULL;

    $query = "INSERT INTO pets (userID, fullName, birthdate, breed, color, weight)
    VALUES(:userID,:fullname, :birthdate, :breed, :color, :weight)" . PHP_EOL;

    $statement = $this->pdo->prepare($query);

    $parameters = [
      ':userID' => $userID,
      ':fullname' => $fullname,
      ':birthdate' => $birthdate,
      ':color' => $color,
      ':weight' => $pweight,
      ':breed' => $breed
    ];

    $statement->execute($parameters);
    $currentPetID = $this->pdo->lastInsertId();

    $messageForSuccess = $currentPetID . ' ' . $fullname . ' was created in the pets table';

    if ($currentPetID >= 1){
      return ['result' => $messageForSuccess];
    } else if ($currentPetID < 1){
      return ['error' => 'Pet was not added to pets Table'];
    }

  }

  //updatePet - Wedad Aljahmi
  public function updatePet($petValues){
    unset($petValues['request']);
    $petID = $petValues['petID'];
    unset($petValues['petID']);

    $keys = array_keys($petValues);

    foreach($keys as $petValue){
      $fields[] = $petValue . ' = ' . ':' . $petValue;
    }

    $query = "UPDATE pets SET " . implode(', ',$fields). " WHERE petID = :petID" . PHP_EOL;
    echo $query;
    $statement = $this->pdo->prepare($query);

    foreach ($petValues as $key => $va1){
      $key = ":" . $key;
      $parameters[$key]=$va1;
    }

    $parameters[':petID']=$petID;

    unset($parameters[0]);
    try{
    $statement->execute($parameters);
    } catch (PDOException $ex){
      echo $ex;
    }

    return ['result' => "Pet Information Updated"];
  }

  public function readPet($values){
    $petID = !empty($values['petID']) ? $values['petID'] : null;

    $query = "SELECT * From pets WHERE petID = :petID" . PHP_EOL;

    $statement = $this->pdo->prepare($query);

    $parameters = [':petID' => $petID];

    $statement->execute($parameters);

    $petInfo = $statement->fetchAll(PDO::FETCH_CLASS, '\stdClass');

    //if the array is empty, then go into if statement and return null
    if (!empty($petInfo)) {
      $petInfo = reset($petInfo);
      return ['result' => $petInfo];
    } else {
      return ['error' => 'Pet with ID # '.$petID.' does not exist'];
    }

  }


  public function createUser($values){ //-Fouad, revised by Brian, implemented by Wedad
      $username = !empty($values['username']) ? $values['username'] : NULL;
      $email = !empty($values['email']) ? $values['email'] : NULL;
      $firstName = !empty($values['firstName']) ? $values['firstName'] : NULL;
      $lastName = !empty($values['lastName']) ? $values['lastName'] : NULL;
      $password = !empty($values['password']) ? $values['password'] : NULL;
      $privileges = !empty($values['privileges']) ? $values['privileges'] : 'Customer';
      $birthdate = !empty($values['birthdate']) ? $values['birthdate'] : NULL;
      $hiredate = !empty($values['hiredate']) ? $values['hiredate'] : NULL;

    //Prevent duplicate userNames - Wedad
    //get userNames from table
    $query = "SELECT * FROM users where username = :username" .PHP_EOL;

    $statement = $this->pdo->prepare($query);

    $parameters = [':username' => $username];

    $statement->execute($parameters);

    $userInfo = $statement->fetchAll(PDO::FETCH_CLASS, '\stdClass');

    if(!empty($userInfo)){
      return ['error' => 'This username already exists'];
    }


    //inserting into Users table
    if (!empty($hiredate) && !empty($birthdate)){
      $query = "INSERT INTO users (username, password, firstName, lastName, privileges, email, hiredate, birthdate)
      Values(:username, sha1(:password), :firstName, :lastName, :privileges, :email, :hiredate, :birthdate)" . PHP_EOL;

      $parameters = [
        ':username' => $username,
        ':password' => $password,
        ':firstName' => $firstName,
        ':lastName' => $lastName,
        ':privileges' => $privileges,
        ':email' => $email,
        ':hiredate' => $hiredate,
        ':birthdate' => $birthdate
      ];
    } else{
      $query = "INSERT INTO users (username, password, firstName, lastName, privileges, email)
      Values(:username, sha1(:password), :firstName, :lastName, :privileges, :email)" . PHP_EOL;

      $parameters = [
        ':username' => $username,
        ':password' => $password,
        ':firstName' => $firstName,
        ':lastName' => $lastName,
        ':privileges' => $privileges,
        ':email' => $email
      ];
    }
    $statement = $this->pdo->prepare($query);

    $statement->execute($parameters);

    $loginValues=[
          'username' => $username,
          'password' => $password
    ];

    $response[] = $this->login($loginValues);
    return $response;
}

  public function updateUser($values){
    // Removing the request element in the values array that is passed in. - Brian
    unset($values['request']);
    $userID = $values['userID'];
    unset($values['userID']);
    //Setting the values array keys to another array to help with UPDATE statement - Brian
    $keys = array_keys($values);

    //load fields array with proper values for the UPDATE statement - Brian
    //If one of the values is the password field we will wrap it in sha1.
    foreach ($keys as $value) {
      if ($value == "password"){
        $fields[] = $value . ' = '.'sha1(:'.$value.')';
      }else{
        $fields[] = $value . ' = ' . ':' . $value;
      }
    }

    /*Create UPDATE statement with implode on the fields array, which create a bounding string for each value
    to be updated by the function*/
    // fix to work with userid instead of username
    $query = "UPDATE users SET " . implode(', ', $fields) . " WHERE userID = :userID" . PHP_EOL;

    //Prepare sql statement with pdo prepare method
    $statement = $this->pdo->prepare($query);

    /* load each key and value from the values array as to be able to pass it bounding parameters
    to the pdo execute method */
    foreach ($values as $key => $val) {
        $key = ':' . $key;
        $parameters[$key] = $val;
    }
    /* Add the userid bounding and the userid variable to the parameter list*/
    $parameters[':userID'] = $userID;
    // A zero index appeared inside the parameter array for reasons I don't know yet
    // so I am removing it.
    unset($parameters[0]);
    // Ececute the statement.
    $statement->execute($parameters);

    //return string that lets user know the information was updated.
    return ['result' => "Information Updated"];

  }

  public function getUsers($values){

    if (!empty($values['userID'])){
      $query = $this->pdo->prepare("SELECT * FROM users where userID = :userID");
      $parameters = [':userID' => $values['userID']];
      $query->execute($parameters);
      $result = $query->fetchAll(PDO::FETCH_CLASS, 'StdClass');
    }
    elseif (!empty($values['username'])){
      $query = $this->pdo->prepare("SELECT * FROM users where username = :username");
      $parameters = [':username' => $values['username']];
      $query->execute($parameters);
      $result = $query->fetchAll(PDO::FETCH_CLASS, 'StdClass');
    }
    elseif(!empty($values['firstName'])){
      $query = $this->pdo->prepare("SELECT * FROM users where firstName = :firstName");
      $parameters = [':firstName' => $values['firstName']];
      $query->execute($parameters);
      $result = $query->fetchAll(PDO::FETCH_CLASS, 'StdClass');
    }
    elseif(!empty($values['lastName'])){
      $query = $this->pdo->prepare("SELECT * FROM users where lastName = :lastName");
      $parameters = [':lastName' => $values['lastName']];
      $query->execute($parameters);
      $result = $query->fetchAll(PDO::FETCH_CLASS, 'StdClass');
    }
    elseif (!empty($values['privileges'])) {
      $query = $this->pdo->prepare("SELECT * FROM users where privileges = :privileges");
      $parameters = [':privileges' => $values['privileges']];
      $query->execute($parameters);
      $result = $query->fetchAll(PDO::FETCH_CLASS, 'StdClass');
    }
    else {
      $query = $this->pdo->prepare("SELECT * FROM users");
      $query->execute();
      $result = $query->fetchAll(PDO::FETCH_CLASS, 'StdClass');
    }

    return $result;
  }

  public function showPetsByBirthMonth($values){
    $month = !empty($values['month']) ? $values['month'] : NULL;

    $selectStatement = "SELECT * FROM pets WHERE MONTH(birthdate) = :month";
    $statement = $this->pdo->prepare($selectStatement);
    $parameters = [':month' => $month];
    $statement->execute($parameters);
    $petsWithBirthMonth[] = $statement->fetchAll(PDO::FETCH_CLASS,'\stdClass');
    $petsWithBirthMonth = reset($petsWithBirthMonth);
    return $petsWithBirthMonth;
  }

  public function showPetsByCustomer($userInfo){
    if (is_a($userInfo, '\stdClass')){
      $userID = !empty($userInfo->userID) ? $userInfo->userID : null;
    } else{
      $userID = !empty($userInfo['userID']) ? $userInfo['userID'] : null;
    }
    $selectStatement = "SELECT firstName, lastName, petID, fullName, pets.birthdate, breed, color, weight
      FROM pets JOIN users on pets.userID = users.userID WHERE pets.userID = :userID";
    $statement = $this->pdo->prepare($selectStatement);
    $parameters = [
      ':userID' => $userID
    ];
    $statement->execute($parameters);
    $petInfo[] = $statement->fetchAll(PDO::FETCH_CLASS, '\stdClass');
    $petInfo = reset($petInfo);
    return $petInfo;
  }

  public function showCustomerWhoHavePets(){
    $selectStatement = "SELECT DISTINCT users.userID, username, firstName, lastName, email
                        FROM users WHERE privileges = 'Customer'";
    $statement = $this->pdo->prepare($selectStatement);
    try{
    $statement->execute();
    $customersWhohavePets[] = $statement->fetchAll(PDO::FETCH_CLASS, '\stdClass');
    $customersWhohavePets = reset($customersWhohavePets);
    return $customersWhohavePets;}
    catch (PDOException $ex){
      echo $ex;
    }
  }

  public function ordersInHourPeriod($values){
    $hour = !empty($values['hour']) ? $values['hour'] : null;
    $selectStatement = "SELECT firstName, lastName, email, orders.orderID, orderDate, serviceDateRequest, categoryname, servicename, orderStatus, employeeID
      FROM users JOIN orders ON users.userID = orders.userID
      JOIN orderitems ON orders.orderID = orderitems.orderID
      JOIN services ON orderitems.serviceID = services.serviceID
      JOIN categories ON services.categoryID = categories.categoryID
      WHERE HOUR(serviceDateRequest) = :hour && (orderStatus <> 'Cancelled' || orderStatus <> 'Complete')
      ORDER BY serviceDateRequest ASC";
    $statement = $this->pdo->prepare($selectStatement);
    $parameters = [':hour'=>$hour];
    $statement->execute($parameters);
    $jobsWithinHourPeriod[] = $statement->fetchAll(PDO::FETCH_CLASS,'\stdClass');
    $jobsWithinHourPeriod = reset($jobsWithinHourPeriod);
    return $jobsWithinHourPeriod;
  }

  public function submitOrder($values){
    $userID = !empty($values['userID']) ? $values['userID'] : NULL;
    //$categoryID = !empty($values['categoryID']) ? $values['categoryID'] : NULL;
    $serviceID = !empty($values['serviceID']) ? $values['serviceID'] : NULL;
    $notes = !empty($values['notes']) ? $values['notes'] : "N/A";
    $appointmentDate = !empty($values['appointmentDate']) ? $values['appointmentDate'] : NULL;
    $orderDate = date('Y-m-d');

    $insertStatement ="INSERT INTO orders (userID, orderDate, serviceDateRequest,orderStatus, orderTotal, notes)
    VALUES(:userID, :orderDate, :serviceDateRequest, :orderStatus, :orderTotal, :notes)" . PHP_EOL;

    $statement = $this->pdo->prepare($insertStatement);
    $parameters = [
      ':userID' => $userID,
      ':orderDate' => $orderDate,
      ':serviceDateRequest' => $appointmentDate,
      ':orderStatus' => 'Pending',
      ':orderTotal' => 0.0,
      ':notes' => $notes
    ];
    $statement->execute($parameters);

    $orderID = $this->pdo->lastInsertId();
    $insertStatement ="INSERT INTO orderitems (orderID, serviceID, price)
    VALUES(:orderID, :serviceID, :price)" . PHP_EOL;

    $statement = $this->pdo->prepare($insertStatement);
    $parameters = [
      ':orderID' => $orderID,
      ':serviceID' => $serviceID,
      ':price' => 0.0
    ];
    $statement->execute($parameters);


    $selectStatement = "SELECT * FROM orderitems WHERE orderID = :orderID AND serviceID = :serviceID";
    $statement = $this->pdo->prepare($selectStatement);
    $parameters = [
      ':orderID' => $orderID,
      ':serviceID' => $serviceID
    ];
    $statement->execute($parameters);
    $orderItemInfo = $statement->fetchAll(PDO::FETCH_CLASS, '\stdClass');
    $orderItemInfo = reset($orderItemInfo);

    if(!empty($orderItemInfo)){
      return ['Success' => 'Service Request Was Successfully Submitted\nYou can find your service info on your home page'];
    } else{
      return ['Failue' => 'Service could not be processed at this time'];
    }
  }

  public function orderUpdate($values){
    $orderID = !empty($values['orderID']) ? $values['orderID'] : NULL;
    $userID = !empty($values['userID']) ? $values['userID'] : NULL;
    $orderStatus = !empty($values['orderStatus']) ? $values['orderStatus'] : NULL;
    $totalPrice = !empty($values['orderTotal']) ? $values['orderTotal'] : NULL;
    $amountPaid = !empty($values['paymentTotal']) ? $values['paymentTotal'] : NULL;
    $dateOfCompletion = !empty($values['dateOfCompletion']) ? $values['dateOfCompletion'] : NULL;
    $notes = !empty($values['notes']) ? $values['notes'] : NULL;

    $updateStatement = "UPDATE orders SET orderStatus = :orderStatus, orderTotal = :orderTotal, notes = :notes WHERE orderID = :orderID";
    $statement = $this->pdo->prepare($updateStatement);
    $parameters = [
      ':orderStatus' => $orderStatus,
      ':orderTotal' => $totalPrice,
      ':orderID' => $orderID,
      ':notes' => $notes
    ];
    // print_r($parameters);
    $statement->execute($parameters);

    if ($amountPaid < $totalPrice) {
      $isPayed = 0; //false
    } else {
      $isPayed = 1; //true
    }
    $invoiceDueDate = date('Y-m-d', strtotime($dateOfCompletion . "+30 days"));

    $insertStatement = "INSERT INTO invoices (orderID, customerID, invoiceDate, invoiceTotal, paymentTotal, invoiceDueDate, isPayed)
                        VALUES(:orderID, :customerID, :invoiceDate, :invoiceTotal, :paymentTotal, :invoiceDueDate, :isPayed)" . PHP_EOL;
    $statement = $this->pdo->prepare($insertStatement);
    $parameters = [
      ':orderID' => $orderID,
      ':customerID' => $userID,
      ':invoiceDate' => $dateOfCompletion,
      ':invoiceTotal' => $totalPrice,
      ':paymentTotal' => $amountPaid,
      ':invoiceDueDate' => $invoiceDueDate,
      ':isPayed' => $isPayed
    ];
    try {
      $statement->execute($parameters);
    } catch (PDOException $ex) {
      echo $ex;
    }
}

  public function showAllEmployees(){
    $selectStatement = "SELECT * FROM users
                        WHERE privileges = 'Employee'";
    $statement = $this->pdo->prepare($selectStatement);
    $statement->execute();
    $employeeList[] = $statement->fetchAll(PDO::FETCH_CLASS, '\stdClass');
    $employeeList = reset($employeeList);
    return $employeeList;
  }

  public function assignEmployeeToOrder($userInfo){
    $employeeID = !empty($userInfo['userID']) ? $userInfo['userID'] : NULL;
    $orderID = !empty($userInfo['orderID']) ? $userInfo['orderID'] : NULL;
    $insertStatement = "UPDATE orders SET employeeID = :employeeID WHERE orderID = :orderID";
    $statement = $this->pdo->prepare($insertStatement);
    $parameters = [
      ':employeeID' => $employeeID,
      ':orderID' => $orderID
  ];
    $statement->execute($parameters);
  }

  public function getEmployeeInfo($userInfo){
    if (is_a($userInfo,'\stdClass')){
      $employeeID = !empty($userInfo->userID) ? $userInfo->userID : NULL;
    } else {
      $employeeID = !empty($userInfo['userID']) ? $userInfo['userID'] : NULL;
    }
    $selectStatement = "SELECT * FROM users WHERE userID = :userID";
    $statement = $this->pdo->prepare($selectStatement);
    $parameters = [ ':userID' => $employeeID];
    $statement->execute($parameters);
    $employeeInfo = $statement->fetchAll(PDO::FETCH_CLASS, '\stdClass');
    $employeeInfo = reset($employeeInfo);
    return $employeeInfo;
  }

  public function showPastCustomerOrders($userInfo){
    if (is_a($userInfo, '\stdClass')) {
      $userID = !empty($userInfo->userID) ? $userInfo->userID : NULL;
    } else {
      $userID = !empty($userInfo['userID']) ? $userInfo['userID'] : NULL;
    }

    $selectStatement = "SELECT orders.orderID, orderDate, serviceDateRequest, orderStatus, servicename, description
    FROM orders JOIN orderitems ON orders.orderID = orderitems.orderID
    JOIN services ON orderitems.serviceID = services.serviceID
    WHERE (orderStatus <> 'Pending' AND orderStatus <> 'In Route' AND orderStatus <> 'In Progress')  AND orders.userID = :userID" . PHP_EOL;

    $statement = $this->pdo->prepare($selectStatement);
    $parameters = [':userID' => $userID];
    $statement->execute($parameters);
    $serviceInfo[] = $statement->fetchAll(PDO::FETCH_CLASS, '\stdClass');
    $serviceInfo = reset($serviceInfo);

    return $serviceInfo;
  }
  public function showCustomerActiveOrders($userInfo)
  {
    if (is_a($userInfo, '\stdClass')) {
      $userID = !empty($userInfo->userID) ? $userInfo->userID : NULL;
    } else {
      $userID = !empty($userInfo['userID']) ? $userInfo['userID'] : NULL;
    }

    $selectStatement = "SELECT orders.orderID, orderDate, serviceDateRequest, orderStatus, servicename, description
    FROM orders JOIN orderitems ON orders.orderID = orderitems.orderID
    JOIN services ON orderitems.serviceID = services.serviceID
    WHERE (orderStatus <> 'Cancelled' AND orderStatus <> 'Complete') AND orders.userID = :userID" . PHP_EOL;

    $statement = $this->pdo->prepare($selectStatement);
    $parameters = [':userID' => $userID];
    $statement->execute($parameters);
    $serviceInfo[] = $statement->fetchAll(PDO::FETCH_CLASS, '\stdClass');
    $serviceInfo = reset($serviceInfo);

    return $serviceInfo;
  }

  // public function getOrderInfo($values){

  // }
  public function getAssignedRequest($userInfo){
    if (is_a($userInfo, '\stdClass')) {
      $userID = !empty($userInfo->userID) ? $userInfo->userID : NULL;
    } else {
      $userID = !empty($userInfo['userID']) ? $userInfo['userID'] : NULL;
    }

    $selectStatement = "SELECT firstName, lastName, email, orderDate, serviceDateRequest, categoryname, servicename, orderStatus, orders.orderID
      FROM users JOIN orders ON users.userID = orders.userID
      JOIN orderitems ON orders.orderID = orderitems.orderID
      JOIN services ON orderitems.serviceID = services.serviceID
      JOIN categories ON services.categoryID = categories.categoryID
      WHERE employeeID = :employeeID AND orderStatus <> 'Complete' AND orderStatus <> 'Cancelled'" . PHP_EOL;

      $statement = $this->pdo->prepare($selectStatement);
      $parameters = [ ':employeeID' => $userID ];
      $statement->execute($parameters);
      $assignedRequest[] = $statement->fetchAll(PDO::FETCH_CLASS, '\stdClass');
      $assignedRequest = reset($assignedRequest);
      return $assignedRequest;
  }


    public function getCompletedRequest($userInfo){
    if (is_a($userInfo, '\stdClass')) {
      $userID = !empty($userInfo->userID) ? $userInfo->userID : NULL;
    } else {
      $userID = !empty($userInfo['userID']) ? $userInfo['userID'] : NULL;
    }

    $selectStatement = "SELECT firstName, lastName, email, orderDate, serviceDateRequest, categoryname, servicename, orderStatus, orders.orderID
      FROM users JOIN orders ON users.userID = orders.userID
      JOIN orderitems ON orders.orderID = orderitems.orderID
      JOIN services ON orderitems.serviceID = services.serviceID
      JOIN categories ON services.categoryID = categories.categoryID
      WHERE employeeID = :employeeID AND orderStatus = 'Complete' AND orderStatus <> 'Cancelled'" . PHP_EOL;

      $statement = $this->pdo->prepare($selectStatement);
      $parameters = [ ':employeeID' => $userID ];
      $statement->execute($parameters);
      $assignedRequest[] = $statement->fetchAll(PDO::FETCH_CLASS, '\stdClass');
      $assignedRequest = reset($assignedRequest);
      return $assignedRequest;
  }

    public function getCancelledRequest($userInfo){
    if (is_a($userInfo, '\stdClass')) {
      $userID = !empty($userInfo->userID) ? $userInfo->userID : NULL;
    } else {
      $userID = !empty($userInfo['userID']) ? $userInfo['userID'] : NULL;
    }

    $selectStatement = "SELECT firstName, lastName, email, orderDate, serviceDateRequest, categoryname, servicename, orderStatus, orders.orderID
      FROM users JOIN orders ON users.userID = orders.userID
      JOIN orderitems ON orders.orderID = orderitems.orderID
      JOIN services ON orderitems.serviceID = services.serviceID
      JOIN categories ON services.categoryID = categories.categoryID
      WHERE employeeID = :employeeID AND orderStatus = 'Cancelled'" . PHP_EOL;

      $statement = $this->pdo->prepare($selectStatement);
      $parameters = [ ':employeeID' => $userID ];
      $statement->execute($parameters);
      $assignedRequest[] = $statement->fetchAll(PDO::FETCH_CLASS, '\stdClass');
      $assignedRequest = reset($assignedRequest);
      return $assignedRequest;
  }

  public function showAllOrders($userInfo){
    if (is_a($userInfo, '\stdClass')){
      $privileges = !empty($userInfo->privileges) ? $userInfo->privileges : NULL;
    } else {
      $privileges = !empty($userInfo['privileges']) ? $userInfo['privileges'] : NULL;
    }

    if ($privileges != 'Admin'){
      return ['empty' => 'Negative'];
    } else {
      $selectStatement = "SELECT firstName, lastName, email, orders.orderID, orderDate, serviceDateRequest, categoryname, servicename, orderStatus, employeeID
      FROM users JOIN orders ON users.userID = orders.userID
      JOIN orderitems ON orders.orderID = orderitems.orderID
      JOIN services ON orderitems.serviceID = services.serviceID
      JOIN categories ON services.categoryID = categories.categoryID" . PHP_EOL;

      $statement = $this->pdo->prepare($selectStatement);
      $statement->execute();
      $customerInfo[] = $statement->fetchAll(PDO::FETCH_CLASS, '\stdClass');
      $customerInfo = reset($customerInfo);
      return $customerInfo;

    }
  }

  public function showAllCompleteOrders($userInfo)
  {
    if (is_a($userInfo, '\stdClass')) {
      $privileges = !empty($userInfo->privileges) ? $userInfo->privileges : NULL;
    } else {
      $privileges = !empty($userInfo['privileges']) ? $userInfo['privileges'] : NULL;
    }

    if ($privileges != 'Admin') {
      return ['empty' => 'Negative'];
    } else {
      $selectStatement = "SELECT firstName, lastName, email, orders.orderID, orderDate, serviceDateRequest, serviceDateComplete, categoryname, servicename, orderStatus, employeeID
      FROM users JOIN orders ON users.userID = orders.userID
      JOIN orderitems ON orders.orderID = orderitems.orderID
      JOIN services ON orderitems.serviceID = services.serviceID
      JOIN categories ON services.categoryID = categories.categoryID
      WHERE orderStatus = 'Complete'" . PHP_EOL;

      $statement = $this->pdo->prepare($selectStatement);
      $statement->execute();
      $customerInfo[] = $statement->fetchAll(PDO::FETCH_CLASS, '\stdClass');
      $customerInfo = reset($customerInfo);
      return $customerInfo;
    }
  }

  public function showAllCancelledOrders($userInfo)
  {
    if (is_a($userInfo, '\stdClass')) {
      $privileges = !empty($userInfo->privileges) ? $userInfo->privileges : NULL;
    } else {
      $privileges = !empty($userInfo['privileges']) ? $userInfo['privileges'] : NULL;
    }

    if ($privileges != 'Admin') {
      return ['empty' => 'Negative'];
    } else {
      $selectStatement = "SELECT firstName, lastName, email, orders.orderID, orderDate, serviceDateRequest, categoryname, servicename, orderStatus, employeeID
      FROM users JOIN orders ON users.userID = orders.userID
      JOIN orderitems ON orders.orderID = orderitems.orderID
      JOIN services ON orderitems.serviceID = services.serviceID
      JOIN categories ON services.categoryID = categories.categoryID
      WHERE orderStatus = 'Cancelled'" . PHP_EOL;

      $statement = $this->pdo->prepare($selectStatement);
      $statement->execute();
      $customerInfo[] = $statement->fetchAll(PDO::FETCH_CLASS, '\stdClass');
      $customerInfo = reset($customerInfo);
      return $customerInfo;
    }
  }

  public function showAllProgessOrders($userInfo)
  {
    if (is_a($userInfo, '\stdClass')) {
      $privileges = !empty($userInfo->privileges) ? $userInfo->privileges : NULL;
    } else {
      $privileges = !empty($userInfo['privileges']) ? $userInfo['privileges'] : NULL;
    }

    if ($privileges != 'Admin') {
      return ['empty' => 'Negative'];
    } else {
      $selectStatement = "SELECT firstName, lastName, email, orders.orderID, orderDate, serviceDateRequest, categoryname, servicename, orderStatus, employeeID
      FROM users JOIN orders ON users.userID = orders.userID
      JOIN orderitems ON orders.orderID = orderitems.orderID
      JOIN services ON orderitems.serviceID = services.serviceID
      JOIN categories ON services.categoryID = categories.categoryID
      WHERE orderStatus = 'In Progress' OR orderStatus = 'In Route' OR orderStatus = 'Pending'" . PHP_EOL;

      $statement = $this->pdo->prepare($selectStatement);
      $statement->execute();
      $customerInfo[] = $statement->fetchAll(PDO::FETCH_CLASS, '\stdClass');
      $customerInfo = reset($customerInfo);
      return $customerInfo;
    }
  }

  public function updateOrderStatus($values){
    $orderID = !empty($values['orderID']) ? $values['orderID'] : NULL;
    $orderStatus = !empty($values['orderStatus']) ? $values['orderStatus'] : NULL;

    $updateStatement = "UPDATE orders SET orderStatus = :orderStatus WHERE orderID = :orderID";
    $statement = $this->pdo->prepare($updateStatement);
    $parameters = [
      ':orderStatus' => $orderStatus,
      ':orderID' => $orderID
    ];
    try{
    $statement->execute($parameters);
    } catch (PDOException $ex){
      echo $ex;
    }
  }

  /*public function emailValues($userInfo){
    $orderID = !empty($userInfo['orderID']) ? $userInfo['orderID'] : NULL;
    $userID = !empty($userInfo['userID']) ? $userInfo['userID'] : NULL;

    $selectStatement = "SELECT * FROM users JOIN orders ON users.userID = orders.userID
      JOIN orderitems ON orders.orderID = orderitems.orderID
      JOIN services ON orderitems.serviceID = services.serviceID
      JOIN categories ON services.categoryID = categories.categoryID
      WHERE orders.orderID = :orderID" . PHP_EOL;

    return ['result' => $emailInfo];

  }*/
  public function emailReceipt($values){
    $userID = !empty($values['userID']) ? $values['userID'] : NULL;
    $orderStatus = !empty($values['orderStatus']) ? $values['orderStatus'] : NULL;
    $orderTotal = !empty($values['orderTotal']) ? $values['orderTotal'] : NULL;
    $paymentTotal = !empty($values['paymentTotal']) ? $values['paymentTotal'] : NULL;
    $dateOfCompletion = !empty($values['dateOfCompletion']) ? $values['dateOfCompletion'] : NULL;
    $notes = !empty($values['notes']) ? $values['notes'] : NULL;
    $orderID = !empty($values['orderID']) ? $values['orderID'] : NULL;
    $serviceName = !empty($values['servicename']) ? $values['servicename'] : NULL;

    $query = "SELECT email, firstName, lastName from users WHERE userID = :userID" . PHP_EOL;

    $statement = $this->pdo->prepare($query);

    $parameters = [':userID' => $userID];
    $statement->execute($parameters);
    $customerInfo = $statement->fetchALL(PDO::FETCH_CLASS, '\stdClass');

    print_r($customerInfo);

    $query = "SELECT line1, city, zipcode FROM addresses WHERE userID = :userID" . PHP_EOL;

    $statement = $this->pdo->prepare($query);

    $parameters = [':userID' => $userID];
    $statement->execute($parameters);
    $customerAddress = $statement->fetchALL(PDO::FETCH_CLASS, '\stdClass');

    print_r($customerAddress);

    $to = $customerInfo[0]->email;
    // $to = "petbestcis294@gmail.com";
    echo $to;
    $subject = 'Pet Best Service Update';

    // To send HTML mail, the Content-type header must be set
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    // Create email headers
    $headers .= 'From: <fmaoude@hawkmail.hfcc.edu>' . "\r\n";
    $headers .= 'Cc: <fmaoude@hawkmail.hfcc.edu>' . "\r\n";
    // Compose a simple HTML email message

    $message = '<html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	                  <meta http-equiv="X-UA-Compatible" content="ie=edge">
                <body>
                <center><table rules="all" style="background: #faf8f7;border: #FFFFFF;font-family: Courier New;" cellpadding="20";>
                <tr style="background: #b8b8b6;font-size: 22px;"><td><strong>Pet Best LLC</strong></td><td><strong><center>Receipt</center></strong></td></tr><center>
                <tr><td><strong>Date</strong> </td><td>' . $dateOfCompletion . '</td></tr>
                <tr><td><strong>Order Number</strong> </td><td>#' . $orderID . '</td></tr>
                <tr><td><strong>Name</strong> </td><td>' . $customerInfo[0]->firstName . ' ' . $customerInfo[0]->lastName . '</td></tr>
                <tr><td><strong>Billed To</strong> </td><td>'
                . $customerAddress[0]->line1 . ' '
                . $customerAddress[0]->city . ', '
                . $customerAddress[0]->zipcode .
                '</td></tr>
                <tr><td><strong>Services</strong> </td><td>' . $serviceName . '</td></tr>';
                if(isset($notes)){
                  $message.= '<tr><td><strong>Notes</strong></td><td>' . $notes . '</td></tr>';
                }

                $message.=  '<tr><td><strong>Total</strong> </td><td>$' . $orderTotal . '</td></tr>
                              </center></center></table></body></html>';

    // Sending email
    if (mail($to, $subject, $message, $headers)) {
      echo 'Your mail has been sent successfully.';
    } else {
      echo 'Unable to send email. Please try again.';
    }
  }

  public function emailInvoice($values){
    $userID = !empty($values['userID']) ? $values['userID'] : NULL;
    $orderStatus = !empty($values['orderStatus']) ? $values['orderStatus'] : NULL;
    $orderTotal = !empty($values['orderTotal']) ? $values['orderTotal'] : NULL;
    $paymentTotal = !empty($values['paymentTotal']) ? $values['paymentTotal'] : NULL;
    $dateOfCompletion = !empty($values['dateOfCompletion']) ? $values['dateOfCompletion'] : NULL;
    $notes = !empty($values['notes']) ? $values['notes'] : NULL;
    $orderID = !empty($values['orderID']) ? $values['orderID'] : NULL;
    $serviceName = !empty($values['servicename']) ? $values['servicename'] : NULL;

    $query = "SELECT email, firstName, lastName from users WHERE userID = :userID" . PHP_EOL;

    $statement = $this->pdo->prepare($query);

    $parameters = [':userID' => $userID];
    $statement->execute($parameters);
    $customerInfo = $statement->fetchALL(PDO::FETCH_CLASS, '\stdClass');

    print_r($customerInfo);

    $query = "SELECT line1, city, zipcode FROM addresses WHERE userID = :userID" . PHP_EOL;

    $statement = $this->pdo->prepare($query);

    $parameters = [':userID' => $userID];
    $statement->execute($parameters);
    $customerAddress = $statement->fetchALL(PDO::FETCH_CLASS, '\stdClass');

    $to = $customerInfo[0]->email;
    echo $to;
    // $to = "petbestcis294@gmail.com";
    $subject = 'Pet Best Service Update';

    // To send HTML mail, the Content-type header must be set
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    // Create email headers
    $headers .= 'From: <fmaoude@hawkmail.hfcc.edu>' . "\r\n";
    $headers .= 'Cc: <fmaoude@hawkmail.hfcc.edu>' . "\r\n";
    // Compose a simple HTML email message

    $message = '<html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <meta http-equiv="X-UA-Compatible" content="ie=edge">
                <body>
                <center><table rules="all" style="background: #FAF8F7;border: #FFFFFF;font-family: Courier New;" cellpadding="20";>
                <tr style="background: #EEEEEE;font-size: 22px;"><td><strong>Pet Best LLC</strong></td><td><strong><center>Invoice</center></strong></td></tr><center>
                <tr><td><strong>Order Number</strong> </td><td>#' . $orderID . '</td></tr>
                <tr><td><strong>Name</strong> </td><td>' . $customerInfo[0]->firstName . ' ' . $customerInfo[0]->lastName . '</td></tr>
                <tr><td><strong>Services</strong> </td><td>' . $serviceName . '</td></tr>';
                if(!empty($customerInfo[0]->line1)){
                $message .=
                '<tr><td><strong>Bill To</strong> </td><td>'
                . $customerAddress[0]->line1 . ' '
                . $customerAddress[0]->city . ', '
                . $customerAddress[0]->zipcode .
                '</td></tr>';
                }
                if(isset($notes)){
                  $message.= '<tr><td><strong>Notes</strong></td><td>' . $notes . '</td></tr>';
                }
                if($paymentTotal > 0 && $paymentTotal != $orderTotal){
                  $orderTotal = $orderTotal - $paymentTotal;
                  $message.=  '<tr><td><strong>Amount Paid</strong> </td><td>$' . $paymentTotal . '<br>' . $dateOfCompletion . '</td></tr>';
                  $message.=  '<tr><td><strong>Remaining Balance</strong> </td><td>$' . $orderTotal . '</td></tr>
                              </center></center></table></body></html>';
                }
                else{
                  $message.=  '<tr><td><strong>Order Total</strong> </td><td>$' . $orderTotal . '</td></tr>
                              </center></center></table></body></html>';
                }

    // Sending email
    if (mail($to, $subject, $message, $headers)) {
      echo 'Your mail has been sent successfully.';
    } else {
      echo 'Unable to send email. Please try again.';
    }
  }

  public function getOrderByOrderID($values){
    $orderID = !empty($values['orderID']) ? $values['orderID'] : NULL;

    $selectStatement = "SELECT * FROM orders JOIN users ON orders.userID = users.userID
      JOIN orderitems ON orders.orderID = orderitems.orderID
      JOIN services ON orderitems.serviceID = services.serviceID
      WHERE orders.orderID = :orderID" . PHP_EOL;

    $statement = $this->pdo->prepare($selectStatement);
    $parameters = [':orderID' => $orderID];
    $statement->execute($parameters);
    $orderInfo = $statement->fetchAll(PDO::FETCH_CLASS, '\stdClass');
    $orderInfo = reset($orderInfo);

    return  ['result' => $orderInfo];
  }

  public function listCustomerWithPets(){
    $selectStatement = "SELECT users.firstName, users.lastName, users.userID,
                        users.username, users.email, GROUP_CONCAT(' ', pets.fullName) AS PetName
                        FROM users JOIN pets ON users.userID = pets.userID
                        WHERE privileges = 'Customer'
                        GROUP BY users.userID
                        ORDER BY users.userID asc";

    $statement = $this->pdo->prepare($selectStatement);
    $statement->execute();
    $petInfo = $statement->fetchAll(PDO::FETCH_CLASS, '\stdClass');

    return  ['result' => $petInfo];
  }

  public function getInvoiceByInvoiceID($values){
    $invoiceID = !empty($values['invoiceID']) ? $values['invoiceID'] : NULL;

    $selectStatement = "SELECT * FROM invoices JOIN orders ON invoices.orderID = orders.orderID
    WHERE invoices.invoiceID = :invoiceID" . PHP_EOL;

    $statement = $this->pdo->prepare($selectStatement);
    $parameters = [':invoiceID' => $invoiceID];
    $statement->execute($parameters);
    $invoiceInfo = $statement->fetchAll(PDO::FETCH_CLASS, '\stdClass');
    $invoiceInfo = reset($invoiceInfo);

    return  ['result' => $invoiceInfo];
  }

  public function getOrderUpdateInfo($values){
    $orderID = !empty($values['orderID']) ? $values['orderID'] : NULL;

    $selectStatement = "SELECT * FROM users JOIN orders ON users.userID = orders.userID
      JOIN orderitems ON orders.orderID = orderitems.orderID
      JOIN services ON orderitems.serviceID = services.serviceID
      JOIN categories ON services.categoryID = categories.categoryID
      WHERE orders.orderID = :orderID" . PHP_EOL;

    $statement = $this->pdo->prepare($selectStatement);
    $parameters = [':orderID' => $orderID];
    $statement->execute($parameters);
    $orderInfo = $statement->fetchAll(PDO::FETCH_CLASS, '\stdClass');
    $orderInfo = reset($orderInfo);
    return  ['result' => $orderInfo];
  }

  public function showAllServices(){
    $selectStatement = "SELECT * FROM services ORDER BY categoryID ASC";
    $statement = $this->pdo->prepare($selectStatement);
    $statement->execute();
    $servicesAndCategories['services'] = $statement->fetchAll(PDO::FETCH_CLASS, '\stdClass');

    $selectStatement = "SELECT * FROM categories";
    $statement = $this->pdo->prepare($selectStatement);
    $statement->execute();
    $servicesAndCategories['categories'] = $statement->fetchAll(PDO::FETCH_CLASS, '\stdClass');
    return $servicesAndCategories;
  }

  public function getServicesById($values)
  {
    $serviceID = !empty($values['serviceID']) ? $values['serviceID'] : NULL;
    $selectStatement = "SELECT * FROM services WHERE serviceID = :serviceID";
    $statement = $this->pdo->prepare($selectStatement);
    $parameters = [':serviceID' => $serviceID];
    $statement->execute($parameters);
    $service = $statement->fetchAll(PDO::FETCH_CLASS, '\stdClass');
    $service = reset($service);
    return $service;
  }
  public function getServicesByCategoryID($values){
    $categoryID = !empty($values['categoryID']) ? $values['categoryID'] : NULL;
    $selectStatement = "SELECT * FROM services WHERE categoryID = :categoryID";
    $statement= $this->pdo->prepare($selectStatement);
    $parameters = [':categoryID' => $categoryID];
    $statement->execute($parameters);
    $services[] = $statement->fetchAll(PDO::FETCH_CLASS,'\stdClass');
    $services = reset($services);
    return ['result' => $services];
  }
  public function getCategoriesById($values)
  {
    $categoryID = !empty($values['categoryID']) ? $values['categoryID'] : NULL;
    $selectStatement = "SELECT * FROM categories WHERE categoryID = :categoryID";
    $statement = $this->pdo->prepare($selectStatement);
    $parameters = [':categoryID' => $categoryID];
    $statement->execute($parameters);
    $categorie = $statement->fetchAll(PDO::FETCH_CLASS, '\stdClass');
    $categorie = reset($categorie);
    return $categorie;
  }

  public function updateServices($Values)
  {
    unset($Values['request']);
    $serviceID = $Values['serviceID'];
    unset($Values['serviceID']);

    $keys = array_keys($Values);

    foreach ($keys as $Value) {
      $fields[] = $Value . ' = ' . ':' . $Value;
    }

    $query = "UPDATE services SET " . implode(', ', $fields) . " WHERE serviceID = :serviceID" . PHP_EOL;
    $statement = $this->pdo->prepare($query);

    foreach ($Values as $key => $va1) {
      $key = ":" . $key;
      $parameters[$key] = $va1;
    }

    $parameters[':serviceID'] = $serviceID;

    unset($parameters[0]);
    try {
      $statement->execute($parameters);
    } catch (PDOException $ex) {
      echo $ex;
    }

    return ['result' => "Service Information Updated"];
  }

  public function updateCategories($Values)
  {
    unset($Values['request']);
    $categoryID = $Values['categoryID'];
    unset($Values['categoryID']);

    $keys = array_keys($Values);

    foreach ($keys as $Value) {
      $fields[] = $Value . ' = ' . ':' . $Value;
    }

    $query = "UPDATE categories SET " . implode(', ', $fields) . " WHERE categoryID = :categoryID" . PHP_EOL;
    $statement = $this->pdo->prepare($query);

    foreach ($Values as $key => $va1) {
      $key = ":" . $key;
      $parameters[$key] = $va1;
    }

    $parameters[':categoryID'] = $categoryID;

    unset($parameters[0]);
    try {
      $statement->execute($parameters);
    } catch (PDOException $ex) {
      echo $ex;
    }

    return ['result' => "Category Information Updated"];
  }

public function getUnpaidInvoices($values){
    if (is_a($values, '\stdClass')){
      $privileges = !empty($values->privileges) ? $values->privileges : NULL;
    }
    else{
      $privileges = !empty($values['privileges']) ? $values['privileges'] : NULL;
    }
    if ($privileges != 'Admin'){
      return ['negative' => 'Error'];
    }
    else{
      $selectStatement = "SELECT * FROM invoices WHERE isPayed = 0
                          Order By invoiceDate DESC";
      $statement = $this->pdo->prepare($selectStatement);
      $statement->execute();
      $unpaidInvoices[] = $statement->fetchall(PDO::FETCH_CLASS, '\stdClass');
      $unpaidInvoices = reset($unpaidInvoices);
      return $unpaidInvoices;
    }
}


  public function getPaidInvoices($values){
    if (is_a($values,'\stdClass')){
      $privileges = !empty($values->privileges) ? $values->privileges : NULL;
    } else{
      $privileges = !empty($values['privileges']) ? $values['privileges'] : NULL;
    }

    if ($privileges != 'Admin'){
      return ['negative' => 'Error'];
    } else{
      $selectStatement = "SELECT * FROM invoices WHERE isPayed = 1 Order By invoiceDate DESC";
      $statement = $this->pdo->prepare($selectStatement);
      $statement->execute();
      $paidInvoices[] = $statement->fetchAll(PDO::FETCH_CLASS,'\stdClass');
      $paidInvoices = reset($paidInvoices);
      return $paidInvoices;
    }

  }

  public function getOverdueInvoices($values){
    if (is_a($values, '\stdClass')) {
      $privileges = !empty($values->privileges) ? $values->privileges : NULL;
    } else {
      $privileges = !empty($values['privileges']) ? $values['privileges'] : NULL;
    }

    if ($privileges != 'Admin'){
      return ['negative' => 'Error'];
    } else {
      $date = date('Y-m-d');
      $selectStatement = "SELECT * FROM invoices WHERE :currentdate > invoiceDueDate Order By invoiceDate DESC";
      $statement = $this->pdo->prepare($selectStatement);
      $parameters = [':currentdate' => $date];
      $statement->execute($parameters);
      $overdueInvoices[] = $statement->fetchAll(PDO::FETCH_CLASS,'\stdClass');
      $overdueInvoices = reset($overdueInvoices);
      return $overdueInvoices;
    }
  }

  public function getUnderdueInvoices($values){
    if (is_a($values, '\stdClass')) {
      $privileges = !empty($values->privileges) ? $values->privileges : NULL;
    } else {
      $privileges = !empty($values['privileges']) ? $values['privileges'] : NULL;
    }

    if ($privileges != 'Admin'){
      return ['negative' => 'Error'];
    } else {
      $date = date('Y-m-d');
      $selectStatement = "SELECT * FROM invoices WHERE :currentdate < invoiceDueDate Order By invoiceDate DESC";
      $statement = $this->pdo->prepare($selectStatement);
      $parameters = [':currentdate' => $date];
      $statement->execute($parameters);
      $underdueInvoices[] = $statement->fetchAll(PDO::FETCH_CLASS,'\stdClass');
      $underdueInvoices = reset($underdueInvoices);
      return $underdueInvoices;
    }
  }

  public function getPricesByCategoryID($values){
    $categoryID = !empty($values['categoryID']) ? $values['categoryID'] : NULL;
    $selectStatement = "SELECT servicename,description,price
                        FROM services WHERE categoryID = :categoryID" . PHP_EOL;
    $statement = $this->pdo->prepare($selectStatement);
    $parameters = [':categoryID' => $categoryID];
    $statement->execute($parameters);
    $priceInfo[] = $statement->fetchAll(PDO::FETCH_CLASS,'\stdClass');
    $priceInfo = reset($priceInfo);
    return $priceInfo;
  }

  public function addService($values){
    $categoryID = !empty($values['categoryID']) ? $values['categoryID'] : NULL;
    $servicename = !empty($values['servicename']) ? $values['servicename'] : NULL;
    $description = !empty($values['description']) ? $values['description'] : NULL;
    $dateadded = date('Y-m-d');
    $price = !empty($values['price']) ? $values['price'] : NULL;

    $insertStatement = "INSERT INTO services (categoryID, servicename, description, dateadded, price)
                        VALUES (:categoryID, :servicename, :description, :dateadded, :price)" . PHP_EOL;
    $statement = $this->pdo->prepare($insertStatement);
    $parameters = [
      ':categoryID' => $categoryID,
      ':servicename' => $servicename,
      ':description' => $description,
      ':dateadded' => $dateadded,
      ':price' => $price
    ];
    $statement->execute($parameters);
  }

  public function deleteService($values)
  {
    $serviceID = !empty($values['serviceID']) ? $values['serviceID'] : NULL;

    $insertStatement = "DELETE FROM services WHERE serviceID = :serviceID" . PHP_EOL;
    $statement = $this->pdo->prepare($insertStatement);
    $parameters = [
      ':serviceID' => $serviceID,
    ];
    $statement->execute($parameters);
  }

  public function addCategory($values)
  {
    $categoryname = !empty($values['categoryname']) ? $values['categoryname'] : NULL;

    $insertStatement = "INSERT INTO categories (categoryname)
                        VALUES (:categoryname)" . PHP_EOL;
    $statement = $this->pdo->prepare($insertStatement);
    $parameters = [
      ':categoryname' => $categoryname,
    ];
    $statement->execute($parameters);
  }
  public function deleteCategory($values)
  {
    $categoryID = !empty($values['categoryID']) ? $values['categoryID'] : NULL;

    $insertStatement = "DELETE FROM categories WHERE categoryID = :categoryID" . PHP_EOL;
    $statement = $this->pdo->prepare($insertStatement);
    $parameters = [
      ':categoryID' => $categoryID,
    ];
    $statement->execute($parameters);
  }


  public function createToken($userInfo)
  {
    $tokenID = hash("sha256", mt_rand() . microtime() . print_r($_SERVER, TRUE) . getmypid());
    $tokenData = serialize($userInfo);
    $tokenExpire = date("Y-m-d h:i:s", strtotime('+5 hours'));
    $parameters = [
      ':tokenID' => $tokenID,
      ':tokenData' => $tokenData,
      ':tokenExpire' => $tokenExpire
    ];

    $query = "INSERT into tokens (tokenID, tokenData, tokenExpire)
    Values(:tokenID, :tokenData, :tokenExpire)" . PHP_EOL;

    $statement = $this->pdo->prepare($query);
    $statement->execute($parameters);

    $query = "SELECT tokenID FROM tokens WHERE tokenID = :tokenID";
    $statement = $this->pdo->prepare($query);
    $parameterToken = [
      ':tokenID' => $tokenID
    ];
    $statement->execute($parameterToken);
    $tokenId = $statement->fetchColumn();

    return $tokenId;
  }

  public function checkToken($tokenId){
    // $currentToken = (!empty($tokenId)) ? $tokenId : null;
    $parameter = [ ':tokenID' => $tokenId];
    $currentTimeStamp = date("h:i:s");
    $query = "SELECT * FROM tokens WHERE tokenID = :tokenID";
    $statement = $this->pdo->prepare($query);
    $statement->execute($parameter);
    $tokenInfo = $statement->fetchAll(PDO::FETCH_CLASS, '\stdClass');
    $tokenInfo = reset($tokenInfo);
    $expireTimeStamp = $tokenInfo->tokenExpire;

    echo $currentTimeStamp . '  ';
    echo $expireTimeStamp;

    if ($currentTimeStamp > $expireTimeStamp){
      return 'Login session expired';
    } else{
      return unserialize($tokenInfo->tokenData);
    }

  }

  public function tokenTest($tokenId){
    $parameter = [ ':tokenId' => $tokenId];
    $query = "SELECT tokenId FROM tokens WHERE tokenId = :tokenId";
    $statement = $this->pdo->prepare($query);
    $statement->execute($parameter);
    $tokenPassOrFail = $statement->fetchAll(PDO::FETCH_CLASS, '\stdClass');

    if (!empty($tokenPassOrFail)){
      return ['success' => 'Token Exist'];
    } else{
      return ['failed' => 'Token does not exist'];
    }

  }

  public function addAddress($values)
  {
    $userID = !empty($values['userID']) ? $values['userID'] : NULL;
    $line1 = !empty($values['line1']) ? $values['line1'] : NULL;
    $line2 = !empty($values['line2']) ? $values['line2'] : NULL;
    $city = !empty($values['city']) ? $values['city'] : NULL;
    $state = !empty($values['state']) ? $values['state'] : NULL;
    $zipcode = !empty($values['zipcode']) ? $values['zipcode'] : NULL;
    $phone = !empty($values['phone']) ? $values['phone'] : NULL;
    $insertStatement = "INSERT INTO addresses (addressID, userID, line1, line2, city, state, zipcode, phone)
    VALUES (NULL, :userID, :line1, :line2, :city, :state, :zipcode, :phone)" . PHP_EOL;

    $statement = $this->pdo->prepare($insertStatement);
    $parameters = [
      ':userID' => $userID,
      ':line1' => $line1,
      ':line2' => $line1,
      ':city' => $city,
      ':state' => $state,
      ':zipcode' => $zipcode,
      ':phone' => $phone
    ];

    $statement->execute($parameters);
  }

  public function getAddress($values){
    $userID = !empty($values['userID']) ? $values['userID'] : NULL;

    $selectStatement = "SELECT * FROM addresses
                        WHERE userID = :userID";
    $statement = $this->pdo->prepare($selectStatement);
    $parameters = [':userID' => $userID];
    $statement->execute($parameters);
    $userAddress[] = $statement->fetchAll(PDO::FETCH_CLASS, '\stdClass');
    $userAddress = reset($userAddress);
    return $userAddress;
  }

  public function updateAddress($values)
  {
    unset($values['request']);
    $userID = !empty($values['userID']) ? $values['userID'] : NULL;
    unset($values['userID']);
    $keys = array_keys($values);
    foreach ($keys as $value) {
      $fields[] = $value . ' = ' . ':' . $value;
    }
    $query = "UPDATE addresses SET " . implode(', ', $fields) . " WHERE userID = :userID" . PHP_EOL;
    $statement = $this->pdo->prepare($query);
    foreach ($values as $key => $val) {
      $key = ':' . $key;
      $parameters[$key] = $val;
    }
    $parameters[':userID'] = $userID;
    unset($parameters[0]);
    $statement->execute($parameters);
    return ['result' => "Address Updated"];
  }

}
