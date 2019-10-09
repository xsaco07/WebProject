<?php
class UserDBModel {

  private $DBconnection;

  function __construct($DBconnection) {
      $this->DBconnection = $DBconnection;
  }

  public function insertUser($user) {
      $result = False;
      echo $result;
      if ($statement = $this->DBconnection->prepare("INSERT INTO users VALUES (?, ?, ?, ?, ?, ?, ?, ?);")) {

        // Save user atribbutes
        $pageUserName = $user->getPageUserName();
        $userName = $user->getUserName();
        $lastName1 = $user->getLastName1();
        $lastName2 = $user->getLastName2();
        $password = $user->getPassword();
        $email = $user->getEmail();
        $phoneNumber = $user->getPhoneNumber();
        $areaCode = $user->getAreaCode();

        // All parameters are strings
        $statement->bind_param("ssssssss", $pageUserName, $userName, $lastName1, $lastName2, $password, $email, $phoneNumber, $areaCode);
        $result = $statement->execute();
        $statement->close();
      }
      $this->DBconnection->close();
      return $result;
  }

  public function getUser($userName) {
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
      return new User($row['pageUserName'], $row['userName'], $row['lastName1'], $row['lastName2'], $row['password'], $row['email'], $row['phoneNumber'], $row['areaCode']);
    }
    else {
      exit("User does not exists");
      return NULL;
    }
  }
}
?>
