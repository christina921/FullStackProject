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


  $query = "SELECT 
                        offer.id,
                        offer.quantity,
                        offer.created_date,
                        offer.took_over_date,
                        offer.finished_date,
                        offer.canceled,
                        item.name AS item_name,
                        citizen.username,
                        citizen.name,
                        savior.name AS savior_name ,
                        savior.phone AS savior_phone
                    FROM offer
                    INNER JOIN citizen ON offer.citizen_id = citizen.id
                    INNER JOIN item ON offer.item_id = item.id
                    LEFT JOIN savior ON offer.savior_id = savior.id
                    WHERE citizen.username = '".$_SESSION["username"]."';";



$result = $db_link->query($query);
$data = array();


while($row = $result->fetch_assoc()) {
    $data[$row["id"]]["quantity"] = (int)$row["quantity"];
    $data[$row["id"]]["created_date"] = $row["created_date"];
    $data[$row["id"]]["savior_name"] = $row["savior_name"];
    $data[$row["id"]]["canceled"] = $row["canceled"];
    $data[$row["id"]]["took_over_date"] = $row["took_over_date"];
    $data[$row["id"]]["finished_date"] = $row["finished_date"];
    $data[$row["id"]]["item_name"] = $row["item_name"];
    $data[$row["id"]]["savior_name"] = $row["savior_name"];
    $data[$row["id"]]["savior_phone"] = $row["savior_phone"];
  }



    
     echo json_encode($data);















  ?>