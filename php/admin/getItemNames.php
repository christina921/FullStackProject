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


  $query = "select `id`, `name` from item;";

  $result = $db_link->query($query);
  $data = array();


  while($row = $result->fetch_assoc()) {
    $data[$row['id']] = $row['name'];
  }

  echo json_encode($data);

  ?>