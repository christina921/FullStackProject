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

  $requestId = $_POST["requestId"];

  $savior_id_query = "select id from savior where username = '".$_SESSION["username"]."';";
  $result = $db_link->query($savior_id_query);
  $savior_id = null;
  while($row = $result->fetch_assoc()) { $savior_id = (int)$row["id"]; }
  if (is_null($savior_id)) {echo "savior_id is null"; return;}

  $query = "select item_id, num_of_people as quantity from request where id = ".$requestId.";";
  $result = $db_link->query($query);
  $request_item = null;
  while($row = $result->fetch_assoc()) { 
    $request_item = [
      "id" => $row["item_id"],
      "quantity" => $row["quantity"]
    ];
  }
  if (is_null($request_item)) {echo "request_item is null"; return;}

  $query = "select item_id, quantity from savioritems where savior_id = ".$savior_id." and item_id = ".$request_item["id"].";";
  $result = $db_link->query($query);
  $savior_item = null;
  if(mysqli_num_rows($result) == 0) {
    echo "not_enough_quantity_error";
    return;
  }
  while($row = $result->fetch_assoc()) { 
    $savior_item = [
      "id" => $row["item_id"],
      "quantity" => $row["quantity"]
    ];
  }
  if (is_null($savior_item)) {echo "savior_item is null"; return;}

  if($request_item["quantity"] > $savior_item["quantity"]) {
    echo "not_enough_quantity_error";
    return;
  }

  // remove items from saviorItems table
  $insert_items_query = "update saviorItems set quantity = quantity - ".$request_item["quantity"]." 
                          where savior_id = ".$savior_id." and item_id = ".$request_item["id"].";";
  $db_link->query($insert_items_query);

  // set finished date on request table
  $query = "update request set finished_date = CURRENT_TIMESTAMP where id = ".$requestId.";";
  $db_link->query($query);

  echo "done";
?>