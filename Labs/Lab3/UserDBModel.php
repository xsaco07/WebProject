<?php
class UserDBModel {

  private $DBconnection;

  function __construct($DBconnection) {
      $this->DBconnection = $DBconnection;
  }

  public function insertUser($user) {
      $statement = $this->DBconnection->prepare("INSERT INTO User VALUES (?, ?, ?, ?, ?, ?, ?, ?);");
      // All parameters are strings
      $statement->bind_param("ssssssss", $user->pageUserName, $user->userName, $user->lastName1, $user->lastName2, $user->password, $user->email, $user->phoneNumber, $user->areaCode);
      $statement->execute();
      $this->DBconnection.close();
  }

  public function getUser($userName) {
    //echo "<br>".$this->DBconnection == NULL."<br>";
    if ($statement = $this->DBconnection->prepare("SELECT * FROM users WHERE pageUserName = ?")) {
      $statement->bind_param("s", $userName); // "s" because paramater is a string
      $statement->execute();
      // Get user selected from database
      $selected_user = $this->queryToUser($statement->get_result());
      $statement->close();
    }
    $this->DBconnection->close();

    return $selected_user;
  }

  public function updateUser($userName, $newUser) {
    $statement = $this->DBconnection->prepare("UPDATE User SET pageUserName = ?, userName = ?, lastName1 = ?, lastName2 = ?, password = ?, email = ?, phoneNumber = ?, areaCode = ? WHERE pageUserName = ?;");
    // All parameters are strings
    $statement->bind_param("sssssssss", $newUser->pageUserName, $newUser->userName, $newUser->lastName1, $newUser->lastName2, $newUser->password, $newUser->email, $newUser->phoneNumber, $newUser->areaCode, $userName);
    $statement->execute();
    $this->DBconnection.close();
  }

  // Takes a database query result, fetches it's data and create a User object
  // with it.
  private function queryToUser($queryResult) {
    if ($queryResult->num_rows > 0) {
      $row = $queryResult->fetch_assoc();
      // echo $row['pageUserName'];
      // echo $row['userName'];
      // echo $row['lastName1'];
      // echo $row['lastName2'];
      // echo $row['password'];
      // echo $row['email'];
      // echo $row['phoneNumber'];
      // echo $row['areaCode'];
      return new User($row['pageUserName'], $row['userName'], $row['lastName1'], $row['lastName2'], $row['password'], $row['email'], $row['phoneNumber'], $row['areaCode']);
    }
    else {
      exit("User does not exists");
      return NULL;
    }
  }
}
?>
