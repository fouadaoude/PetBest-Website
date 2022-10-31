<?php

namespace PetBest;

/**
 * Defines the RestService class.
 *
 * This class extends the Rest API to provide a connection to database functionality.
 */
class RestService extends Rest implements RestServiceInterface {

  /**
   * @var Database
   *
   * Contains the Database API object.
   */
  private $database;

  /**
   * @var string
   *
   * Contains the authentication method.
   */
  private $auth_method;

  /**
   * {@inheritdoc}
   */
  public static function create(Database $database) {
    return new static($database);
  }

  /**
   * Initialize a new RestService object.
   *
   * @param Database
   *   The initialized database object.
   */
  public function __construct(Database $database) {
    parent::__construct();
    $this->database = $database;
  }

  /**
   * {@inheritdoc}
   */
  public function processApi() {
    if (!empty($_REQUEST['request'])) {

      $requestName = $this->_request['request'];
      $values = $this->_request;

      // WARNING: This method needs to add some ways to authenticate the user
      // and should also filter out any dangerous or magic methods before it
      // would be safe. This code is for demonstration purposes only!

      if (method_exists($this->database, $requestName)) {
        if (strcmp($requestName,"login")==0){
          $result = $this->database->$requestName($values);
          if(!empty($result['result'])){
            $result['result']->token = $this->database->createToken($result['result']);
          }

        }
        if (isset($values['token'])){
          $tokenPassOrFail = $this->database->tokenTest($values['token']);
          unset($values['token']);
        }

        if (isset($tokenPassOrFail['success'])){
          $result = $this->database->$requestName($values);
        }
        else if (isset($tokenPassOrFail['failed'])){
          $result =  ['error' => 'You are not authorized to use this!'];
        }
        // if (strcmp($requestName,"createUser")==0){
        //     if ($values['privileges'] == 'admin'){
        //       $result = $this->database->$requestName($values);
        //     }
        //     else{
        //       return ['error' => 'User is not an admin!\nOnly admin can create users.'];
        //     }
        // }

        if (!empty($result)) {
          $this->response($this->json($result), 200);
        }
        else {
          // If no records "No Content" status
          $this->response('',204);
        }
      }
      else {
        // If the method not exist with in this class, response would be "Page not found".
        $this->response('',404);
      }
    }
  }

  /**
   * Encode to json if passed data is an array.
   */
  private function json($data) {
    if (is_array($data)) {
      return json_encode($data);
    }
  }
}
