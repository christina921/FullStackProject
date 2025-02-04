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

  // find savior id
  $savior_id_query = "select id from savior where username = '".$_SESSION["username"]."';";
  $result = $db_link->query($savior_id_query);
  $savior_id = null;
  while($row = $result->fetch_assoc()) { $savior_id = (int)$row["id"]; }
  if (is_null($savior_id)) {echo "savior_id is null"; return;}

  // get all items in current savior storage
  $query = "select item_id, quantity from saviorItems where savior_id = ".$savior_id.";";
  $result = $db_link->query($query);
  $savior_items = array();
  while($row = $result->fetch_assoc()) {
    
    $temp["item_id"] = $row["item_id"];
    $temp["quantity"] = $row["quantity"];
    // $temp = {item_id: 16, quantity: 8}  1η επανάληψη
    // $temp = {item_id: 18, quantity: 5}  2η επανάληψη
    array_push($savior_items, $temp);
    // $savior_items = [{item_id: 16, quantity: 8}]  1η επανάληψη
    // $savior_items = [{item_id: 16, quantity: 8}, {item_id: 18, quantity: 5}]  2η επανάληψη
  }
  

  // add items to base
  foreach($savior_items as $item) {
    $query = "update item set quantity = quantity + ".$item["quantity"]." where id = ".$item["item_id"].";";
    $db_link->query($query);
  }

  // remove items from saviors storage
  $query = "update savioritems set quantity = 0 where savior_id = ".$savior_id.";";
  $db_link->query($query);

  echo "done";
?>