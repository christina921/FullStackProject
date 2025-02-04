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
  
  $username = $_SESSION["username"]; 
  $itemId = isset($_POST["itemId"]) ? $_POST["itemId"] : null;
  $quantity = isset($_POST["quantity"]) ? $_POST["quantity"] : null;
 
  if ($itemId === null || $quantity === null) {
    die("Error: Missing itemId or quantity.");
  }

  $query = "INSERT INTO offer (citizen_id, item_id, quantity)
  VALUES ( (SELECT id FROM citizen WHERE username = '".$username."'), ".$itemId.", ".$quantity.");";
  
  $db_link->query($query);

  echo "done";
?>