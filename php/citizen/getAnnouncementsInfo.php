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

  $query = "    SELECT 
            announcement.id AS announcementId,
            announcement.created_date, 
            item.name AS item_name,
            item.id as item_id
            FROM announProd
            INNER JOIN item ON announProd.item_id = item.id
            INNER JOIN announcement ON announProd.announcementId = announcement.id;";

  $result = $db_link->query($query);
  $data = array();

  while ($row = $result->fetch_assoc()) {
    $announcementId = $row["announcementId"]; 
    
    $data[$announcementId]["created_date"] = $row["created_date"];
    
    $data[$announcementId]["items"][$row["item_id"]]["item_name"] = $row["item_name"];
}


  echo json_encode($data);
?>