<?php

  ini_set('display_errors', 1); error_reporting(-1);

  include "Connection.php";
  include "User.php";
  include "UserDBModel.php";

  $pageUserName = $_POST['pageUserName'];
  $password = $_POST['password'];

  $homePage = "home.html";
  $loginPage = "login.html";
  $registerPage = "register.html";

  // Call Validator class
  //isValid(username)
  //isValid(password)

  // Stablish connection
  $connection = Connection::connect();

  // Query data from DB
  $model = new UserDBModel($connection);
  $userRetrieved = $model->getUser($pageUserName);

  // If user credentials match
  if (!is_null($userRetrieved) && $userRetrieved->getPassword() == $password) {
    include_once $homePage;
  }
  else {
    // echo "\n".$pageUserName;
    // echo "\n".$password." vs ".$userRetrieved->getPageUserName();
    echo "\nUser credentials not valid";
    include_once $loginPage;
  }

?>
