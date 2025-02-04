<?php 
  session_start(); // αυτο το αρχειο εχει προσβαση στο session
  include_once("../connect_to_db.php");

  $username = $_GET["username"];
  $password = $_GET["password"];

  //Session Data Handling: After starting a session( by session_start()), PHP automatically handles the retrieval and storage of any data in the session array ($_SESSION). This data is stored on the server, and the session ID links the user to this data.The session data is maintained across multiple requests. Once you start a session and store data in the session array, PHP takes care of maintaining this data as long as the session is active, and you can access this data on any other page that also starts the session.

  $query = "select username, name, phone from admin where username = '".$username."' and password = '".$password."';";
  $result = $db_link->query($query);
  if (mysqli_num_rows($result) == 1) {
    $row = $result->fetch_array();
    $_SESSION["username"] = $row["username"];
    $_SESSION["name"] = $row["name"];
    $_SESSION["phone"] = $row["phone"];
    $_SESSION["type"] = "admin";
    echo "admin";
    return;
  }


  $query = "select username, name, phone from savior where username = '".$username."' and password = '".$password."';";
  $result = $db_link->query($query);
  if (mysqli_num_rows($result) == 1) {
    $row = $result->fetch_array();
    $_SESSION["username"] = $row["username"];
    $_SESSION["name"] = $row["name"];
    $_SESSION["phone"] = $row["phone"];
    $_SESSION["type"] = "savior";
    echo "savior";
    return;
  }


  $query = "select username, name, phone from citizen where username = '".$username."' and password = '".$password."';";
  $result = $db_link->query($query);
  if (mysqli_num_rows($result) == 1) {
    $row = $result->fetch_array();
    $_SESSION["username"] = $row["username"];
    $_SESSION["name"] = $row["name"];
    $_SESSION["phone"] = $row["phone"];
    $_SESSION["type"] = "citizen";
    echo "citizen";
    return;
  }

  echo "user not found";
?>