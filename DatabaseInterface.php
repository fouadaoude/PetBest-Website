<?php

namespace PetBest;

use \PDO;

/**
 * Defines the Pet Best Database Service Interface.
 */
interface DatabaseInterface {

  /**
   * Creates an instance of this class.
   *
   * @param \PDO $pdo
   *   The database connection object.
   */
  public static function create(PDO $pdo);

  /**
   * Verifies user login credentials and returns matching user object.
   *
   * @param array $values
   *   Required keys:
   *   - username: the account username.
   *   - password: the account password.
   *
   * @return array|null
   *   Returns an array containing the users' information on success,
   *   or null on failure.
   */
  public function login($values);

    /**
   * Creates new user and logs them into the page.
   *
   * @param array $values
   *    Required keys:
   *    - firstName: first name of user.
   *    - lastName: last name of user.
   *    - username: username for the user
   *    - password: password for user
   *    - email: email for the user.
   *
   * @return array|null
   *    Inserts register information in the database and returns
   *    user info for logged in page.
   */
  public function createUser($values);

  /**
   * Updates current users information.
   *
   * @param array $values
   *     Required keys:
   *    - atleast one of the form variables
   *
   * @return string | null
   */
  public function updateUser($values);

  /**
   * Returns users pet depending sorting option chosen
   *
   * @param array $values
   *      Required keys:
   *      fullname
   *      birthdate
   *      color
   *      pweight
   *      breed
   *
   * @return array
   *    Grabs records that fit the key passed in and return an array
   *    of those records.
   */

  public function createPet($petValues);

  /**
   * Updates pet information matching the petID.
   *
   * @param array $values
   *   Required keys:
   *   - petID
   *
   * @return array
   *    Updates records that fit the key passed in and return an array
   *    of those records.
   */

  public function updatePet($petValues);

  /**
   * Retrieves the user information.
   *
   * @param array $values
   *   Required keys:
   *   - userID
   *   - username
   *   - firstName
   *   - lastName
   *   - privileges
   *
   * @return array
   *    Returns the correct user information.
   */

  public function getUsers($values);

  //Comments coming soon
  public function createToken($userInfo);

  //Comments coming soon
  public function checkToken($tokenID);

  //comments coming soon
  public function tokenTest($tokenID);

  /**
   * Submits the order.
   *
   * @param array $values
   *   Required keys:
   *   - userID
   *   - serviceID
   *   - appointmentDate
   *   - orderDate
   *
   * @return array
   *    Creates an order and saves the information into orders table.
   */

  public function submitOrder($values);

  /**
   * Displays a specific customer order.
   *
   * @param array $values
   *   Required keys:
   *   - userID
   *
   * @return array
   *    Displays the customers order based on their userID.
   */

  public function showPastCustomerOrders($userInfo);
  public function showCustomerActiveOrders($userInfo);

  /**
   * Displays all customer orders.
   *
   * @param array $values
   *   Required keys:
   *   - userInfo
   *   - privileges
   *
   * @return array
   *    Displays all orders only if user is admin.
   */

  public function showAllOrders($userInfo);

  /**
   * Displays completed orders.
   *
   * @param array $values
   *   Required keys:
   *   - userInfo
   *   - privileges
   *
   * @return array
   *    Displays all completed orders only if user is admin.
   */

  public function showAllCompleteOrders($userInfo);

  /**
   * Displays cancelled orders.
   *
   * @param array $values
   *   Required keys:
   *   - userInfo
   *   - privileges
   *
   * @return array
   *    Displays all cancelled orders only if user is admin.
   */

  public function showAllCancelledOrders($userInfo);

  /**
   * Displays pending orders.
   *
   * @param array $values
   *   Required keys:
   *   - userInfo
   *   - privileges
   *
   * @return array
   *    Displays all pending orders only if user is admin.
   */

  public function showAllProgessOrders($userInfo);

  /**
   * Displays pet information tied to customer (userID).
   *
   * @param array $values
   *   Required keys:
   *   - userID
   *
   * @return array
   *    Displays pet information belonging to customer.
   */

  public function showPetsByCustomer($userInfo);

  /**
   * Assigns employee to an order.
   *
   * @param array $values
   *   Required keys:
   *   - employeeID
   *   - orderID
   *
   * @return array|null
   *    Assigns an order by orderID to an employee
   */

  public function assignEmployeeToOrder($userInfo);

  /**
   * Displays the assigned requests.
   *
   * @param array $values
   *   Required keys:
   *   - userID
   *
   * @return array
   *    Returns both completed and cancelled requests.
   */

  public function getAssignedRequest($userInfo);

  /**
   * Displays employee information.
   *
   * @param array $values
   *   Required keys:
   *   - employeeID
   *
   * @return array
   *    Returns the employee information tied to the employeeID.
   */

  public function getEmployeeInfo($userInfo);

  /**
   * Displays employee information.
   *
   * @param null
   *   No required keys
   *
   * @return array
   *    Returns a list of all employees.
   */

  public function showAllEmployees();

  /**
   * Displays an updatd view of an order.
   *
   * @param array $values
   *   Required keys:
   *   - orderID
   *
   * @return array
   *    Returns updated order information.
   */

  public function getOrderUpdateInfo($values);

  /**
   * Updates and displays updated order information.
   *
   * @param array $values
   *   Required keys:
   *   - orderID
   *   - userID
   *   - orderStatus
   *   - totalPrice
   *   - amountPaid
   *   - dateOfCompletetion
   *
   * @return null
   *    Updates order information and displays changes to user.
   */

  public function orderUpdate($values);

  /**
   * Displays all unpaid invoices.
   *
   * @param array $values
   *   Required keys:
   *   - privileges
   *
   * @return array
   *    Returns all invoices that have not been paid (user must be admin).
   */

  public function getUnpaidInvoices($values);

  /**
   * Displays all paid invoices.
   *
   * @param array $values
   *   Required keys:
   *   - privileges
   *
   * @return array
   *    Returns all invoices that have been paid (user must be admin).
   */

  public function getPaidInvoices($values);

  /**
   * Displays all overdue invoices.
   *
   * @param array $values
   *   Required keys:
   *   - privileges
   *
   * @return array
   *    Returns all invoices that are past their duedate (user must be admin).
   */

  public function getOverdueInvoices($values);

  /**
   * Displays requests that have been completed.
   *
   * @param array $values
   *   Required keys:
   *   - userID
   *
   * @return array
   *    Returns all requests where orderStatus is 'Completed'.
   */

  public function getCompletedRequest($userInfo);

  /**
   * Displays requests that have been cancelled.
   *
   * @param array $values
   *   Required keys:
   *   - userID
   *
   * @return array
   *    Returns all requests where orderStatus is 'Cancelled'.
   */

  public function getCancelledRequest($userInfo);

  public function showCustomerWhoHavePets();

}
