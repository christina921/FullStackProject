<?php 
  session_start();
  include_once("../../connect_to_db.php");
  $username = $_POST["username"];
  $password = $_POST["password"]; 
  $fullName = $_POST["fullName"];
  $phone = $_POST["phone"];
  $lat = $_POST["latitude"];
  $lng = $_POST["longitude"];

  $usernameCheckQuery = "select username from savior where username='".$username."';";
  $usernameCheckResult = $db_link->query($usernameCheckQuery);

  if(mysqli_num_rows($usernameCheckResult) == 0) {
    $query = "INSERT INTO savior (username, password, name, phone, latitude, longitude) 
    VALUES ('".$username."', '".$password."', '".$fullName."', '".$phone."', '".$lat."', '".$lng."');";
    
    $result = $db_link->query($query);
    echo "registered";
  } else {
    echo "already user";
  }

?>