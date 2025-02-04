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

  $itemId = $_POST["itemId"];
  $quantity_to_get = $_POST["quantityToGet"];

  $savior_id_query = "select id from savior where username = '".$_SESSION["username"]."';";
  $result = $db_link->query($savior_id_query);
  $savior_id = null;
  while($row = $result->fetch_assoc()) { $savior_id = (int)$row["id"]; }
  if (is_null($savior_id)) {echo "savior_id is null"; return;}

  $check_item_quantity_query = "select quantity from item where id = ".$itemId.";";
  $result = $db_link->query($check_item_quantity_query);
  $item_quantity = null;
  while($row = $result->fetch_assoc()) { $item_quantity = (int)$row["quantity"]; }
  if (is_null($item_quantity)) {echo "item_quantity is null"; return;}

  // check if needed quantity exists in base
  if($quantity_to_get > $item_quantity) { echo "quantity_not_available_error"; return; }

  // remove items from base
  $query = "update item set quantity = quantity - ".$quantity_to_get." where id = ".$itemId.";";
  $db_link->query($query);

  // add items to savior
  $query = "insert into savioritems (`savior_id`, `item_id`, `quantity`) values
  (".$savior_id.", ".$itemId.", ".$quantity_to_get.") on duplicate key update quantity = quantity + values(quantity);";
  $db_link->query($query);

  echo "done";
?>