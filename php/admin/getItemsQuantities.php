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
  header("Content-Type: application/json; charset=UTF-8");
  include_once("../../connect_to_db.php");

  // ifnull(sum(savioritems.quantity), 0) = an den to exei kanena savors apothikeyse to ws 0 alliws athroise ta 

  $query = "select item.id, item.name, item.category, item.quantity as base_quantity, ifnull(sum(savioritems.quantity), 0) as savior_quantity
  from item left join savioritems on item.id = savioritems.item_id
  group by item.id;";

  $result = $db_link->query($query);
  $data = array();
  while($row = $result->fetch_assoc()) {
    $data[$row['id']]["name"] = $row['name'];
    $data[$row['id']]["category"] = $row['category'];
    $data[$row['id']]["base_quantity"] = $row['base_quantity'];
    $data[$row['id']]["savior_quantity"] = $row['savior_quantity'];
    $data[$row['id']]["id"] = $row['id']; 
  }

  echo json_encode($data);
?>