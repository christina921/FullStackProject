<?php 
  session_start();
  if( !isset( $_SESSION["username"] ) && !isset( $_SESSION["type"] )) {
    header("Location:../../index.php");
  } else if ( $_SESSION["type"] == "admin" ) {
    header("Location:../admin/adminHomepage.php");
  } else if ( $_SESSION["type"] == "savior" ) {
    header("Location:../savior/saviorHomepage.php");
  }

  header("Content-Type: application/json; charset=UTF-8");
  include_once("../../connect_to_db.php");


  $query = "select `id`, `name` from item;";

  $result = $db_link->query($query);
  $data = array();

//associative array in php
  while($row = $result->fetch_assoc()) {
    $data[$row['id']] = $row['name'];  //ex    16:	"Water"
                                       //      17:	"Orange juice"
  }

  echo json_encode($data); 
  //the json_encode makes the php assoc. array to a string object ,the  return would be like that 
  // {
  //    "16": "Water",
  //    "17": "Orange juice"
//   }


  ?>