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

  $savior_id_query = "select id from savior where username = '".$_SESSION["username"]."';";
  $result = $db_link->query($savior_id_query);
  $savior_id = null;
  while($row = $result->fetch_assoc()) { $savior_id = (int)$row["id"]; }
  if ($savior_id == null) {echo "ERROR"; return;}


  $query = "SELECT 
    item.id, 
    item.name, 
    item.category, 
    savioritems.quantity AS savior_quantity
FROM 
    item 
INNER JOIN 
    savioritems 
ON 
    item.id = savioritems.item_id 
    WHERE 
    savioritems.savior_id = ".$savior_id.";";

  $result = $db_link->query($query);
  $data = array();
  while($row = $result->fetch_assoc()) {
    $data[$row['id']]["name"] = $row['name'];
    $data[$row['id']]["category"] = $row['category'];
    $data[$row['id']]["savior_quantity"] = $row['savior_quantity'];
    
  }

  echo json_encode($data);
?>