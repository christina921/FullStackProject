<?php
session_start();
include_once("../connect_to_db.php");
$username = $_POST["username"];
$password = $_POST["password"];
$fullName = $_POST["fullName"];
$phone = $_POST["phone"];
$latitude=$_POST["latitude"];
$longitude=$_POST["longitude"];

$usernameCheckQuery = "select username from citizen where username='".$username."'";
$usernameCheckResult = $db_link->query($usernameCheckQuery);

if(mysqli_num_rows($usernameCheckResult) == 0) {

$query = "INSERT INTO citizen (username, password, name, phone, latitude, longitude)
VALUES ('".$username."', '".$password."', '".$fullName."', '".$phone."', '".$latitude."', '".$longitude."');";
$result = $db_link->query($query);
echo 'registered';
} else {
  echo "already user";
}

?>