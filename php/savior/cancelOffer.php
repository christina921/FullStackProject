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

  $offerId = $_POST["offerId"];

  $query = "update offer set savior_id = NULL, took_over_date = NULL where id = ".$offerId.";";
  $db_link->query($query);

  echo "done";
?>