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
  header("Content-Type: application/json; charset=UTF-8");
  include_once("../../connect_to_db.php");

  $query = "SELECT item.id, item.name, item.category, item.quantity FROM item;";

  $result = $db_link->query($query);
  $data = array();
  while($row = $result->fetch_assoc()) {
    $data[$row['id']]["name"] = $row['name'];
    $data[$row['id']]["category"] = $row['category'];
    $data[$row['id']]["quantity"] = $row['quantity'];
  }

  echo json_encode($data);
?>