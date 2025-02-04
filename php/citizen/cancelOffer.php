<?php 
  session_start();
  if( !isset( $_SESSION["username"] ) && !isset( $_SESSION["type"] )) {
    header("Location:../../index.php");
  } else if ( $_SESSION["type"] == "admin" ) {
    header("Location:../admin/adminHomepage.php");
  } else if ( $_SESSION["type"] == "savior" ) {
    header("Location:../savior/saviorHomepage.php");
  }
  include_once("../../connect_to_db.php");

  $offerId = $_POST["offerId"];

  $query = "UPDATE `offer` SET `canceled` = 1 WHERE (`id` = ".$offerId.");";

  $db_link->query($query);

  echo "done";
?>