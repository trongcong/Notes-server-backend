<?php

require_once 'DBOperations.php';

class Functions{
    private $db;
    public function __construct() {
        
            $this -> db = new DBOperations();
    
    }


    public function registerUser($name, $email, $password, $phone) {
    
        $db = $this -> db;
        $name = trim($name);
        $email = trim($email);
        $password = trim($password);
        $phone = trim($phone);
    
        if (!empty($name) && !empty($email) && !empty($password) && !empty($phone)) {
    
              if ($db -> checkUserExist($email)) {
    
                  $response["result"] = "failure";
                  $response["message"] = "User Already Registered !";
                  return json_encode($response);
    
              } else {
    
                  $result = $db -> insertUser($name, $email, $password, $phone);
    
                  if ($result) {

                      $response["result"] = "success";
                      $response["message"] = "User Registered Successfully !";
                      return json_encode($response);
                              
                  } else {
    
                      $response["result"] = "failure";
                      $response["message"] = "Registration Failure";
                      return json_encode($response);
    
                  }
              }					
          } else {
    
              return $this -> getMsgParamNotEmpty();
    
          }
    }
    
    public function loginUser($email, $password) {
    
      $db = $this -> db; 
      $email = trim($email);
      $password = trim($password);
    //   $phone = trim($email);
    
      if (!empty($email) && !empty($password)) {
    
        if ($db -> checkUserExist($email)) {
    
           $result =  $db -> checkLogin($email, $password);
    
           if(!$result) {
    
            $response["result"] = "failure";
            $response["message"] = "Invaild Login Credentials";
            return json_encode($response);
    
           } else {
    
            $response["result"] = "success";
            $response["message"] = "Login Successful";
            $response["user"] = $result;
            return json_encode($response);
    
           }
    
        } else {
    
          $response["result"] = "failure";
          $response["message"] = "Invaild Login Credentials";
          return json_encode($response);
    
        }
      } else {
    
          return $this -> getMsgParamNotEmpty();
        }
    
    }

    public function getMsgParamNotEmpty(){
        
        $response["result"] = "failure";
        $response["message"] = "Parameters should not be empty !";
        return json_encode($response);
    
    }
    public function getMsgInvalidParam(){
        
        $response["result"] = "failure";
        $response["message"] = "Invalid Parameters";
        return json_encode($response);
    
    }
    
    public function getMsgInvalidEmail(){
    
        $response["result"] = "failure";
        $response["message"] = "Invalid Email";
        return json_encode($response);
    
    }        
}