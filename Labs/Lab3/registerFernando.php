<?php

  ini_set('display_errors', 1); error_reporting(-1);

  include "Connection.php";
  include "User.php";
  include "UserDBModel.php";

  $userName = $_POST['userName'];
  $lastName1 = $_POST['lastName1'];
  $lastName2 = $_POST['lastName2'];
  $pageUserName = $_POST['pageUserName'];
  $password = $_POST['password'];
  $email = $_POST['email'];
  $phoneNumber = $_POST['phoneNumber'];
  $areaCode = $_POST['areaCode'];

  $loginPage = "login.html";
  $registerPage = "register.html";

  // Call Validator class
  //isValid(username)
  //isValid(password)

  // Stablish connection
  $connection = Connection::connect();

  // Query data from DB
  $model = new UserDBModel($connection);
  $user = new User($pageUserName, $userName, $lastName1, $lastName2, $password, $email, $phoneNumber, $areaCode);

  echo "\nUser created\n";

  $status = $model->insertUser($user);

  if ($status) {
    echo "Success inserting user";
    include_once $loginPage;
  }
  else {
    echo "Register failed";
  }


?>
