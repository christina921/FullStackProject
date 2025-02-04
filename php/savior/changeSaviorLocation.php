<?php 
  session_start();
  if( !isset( $_SESSION["username"] ) && !isset( $_SESSION["type"] )) {
    header("Location:../../index.php");
  } 
  else if ( $_SESSION["type"] == "admin" ) {
    header("Location:../admin/adminHomepage.php");
  } 
  else if ( $_SESSION["type"] == "citizen" ) {
    header("Location:../citizen/citizenHomepage.php");
  }
  include_once("../../connect_to_db.php");

  $savior_id_query = "select id from savior where username = '".$_SESSION["username"]."';";
  $result = $db_link->query($savior_id_query);
  $savior_id = null;
  while($row = $result->fetch_assoc()) { $savior_id = (int)$row["id"]; }
  if ($savior_id == null) {echo "ERROR"; return;}

  $new_lat = $_POST["new_lat"];
  $new_lng = $_POST["new_lng"];

  $query = "update savior set latitude = ".$new_lat.", longitude = ".$new_lng."where id = ".$savior_id.";";
  $db_link->query($query);

  echo "done";
?>