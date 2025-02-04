<?php 
  session_start();
  if( !isset( $_SESSION["username"] ) && !isset( $_SESSION["type"] )) {
    header("Location:../../index.php");
  } 
  else if ( $_SESSION["type"] == "savior" ) {
    header("Location:../savior/saviorHomepage.php");
  } 
  else if ( $_SESSION["type"] == "citizen" ) {
    header("Location:../citizen/citizenHomepage.php");
  }
  include_once("../../connect_to_db.php");

  $new_lat = $_POST["new_lat"];
  $new_lng = $_POST["new_lng"];

  $query = "update buildinglocation set latitude = ".$new_lat.", longitude = ".$new_lng.";";
  $db_link->query($query);

  echo "done";
?>