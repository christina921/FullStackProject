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


  $data = array();

  $savior_id_query = "select id from savior where username = '".$_SESSION["username"]."';";
  $result = $db_link->query($savior_id_query);
  $savior_id = null;
  while($row = $result->fetch_assoc()) { $savior_id = (int)$row["id"]; }
  if ($savior_id == null) {echo "ERROR"; return;}

  //που δεν εχουν τελειωσει
  $took_over_offers_query = "select 
      offer.id as offer_id, offer.quantity, offer.created_date, offer.took_over_date,
      item.id as item_id, item.name as item_name, item.category as item_category,
      citizen.id as citizen_id, citizen.name as citizen_name, citizen.phone as citizen_phone, citizen.latitude as citizen_lat, citizen.longitude as citizen_lng,
      savior.id as savior_id, savior.name as savior_name, savior.phone as savior_phone, savior.latitude as savior_lat, savior.longitude as savior_lng
  from offer
  inner join item on offer.item_id = item.id
  inner join citizen on offer.citizen_id = citizen.id
  left join savior on offer.savior_id = savior.id
  where offer.finished_date is NULL and offer.canceled = false and offer.savior_id =".$savior_id.";";

  $result = $db_link->query($took_over_offers_query);

  while($row = $result->fetch_assoc()) {
    $data["took_over_offers"][$row["offer_id"]]["quantity"] = $row["quantity"];
    // { 1: { "quantity": $row["quantity"] } }
    $data["took_over_offers"][$row["offer_id"]]["created_date"] = $row["created_date"];
    // { 1: { "quantity": $row["quantity"], "created_date", $row["created_date"] } }
    $data["took_over_offers"][$row["offer_id"]]["took_over_date"] = $row["took_over_date"];
    // { 1: { "quantity": $row["quantity"], "created_date", $row["created_date"], "took_over_date":  $row["took_over_date"]}}
    $data["took_over_offers"][$row["offer_id"]]["item_id"] = $row["item_id"];
    $data["took_over_offers"][$row["offer_id"]]["item_name"] = $row["item_name"];
    $data["took_over_offers"][$row["offer_id"]]["item_category"] = $row["item_category"];
    $data["took_over_offers"][$row["offer_id"]]["citizen_id"] = $row["citizen_id"];
    $data["took_over_offers"][$row["offer_id"]]["citizen_name"] = $row["citizen_name"];
    $data["took_over_offers"][$row["offer_id"]]["citizen_phone"] = $row["citizen_phone"];
   
   
    
  }





//που δεν εχουν τελειωσει 
  $took_over_requests_query = "select 
        request.id as request_id, request.num_of_people, request.created_date, request.took_over_date,
          item.id as item_id, item.name as item_name, item.category as item_category,
          citizen.id as citizen_id, citizen.name as citizen_name, citizen.phone as citizen_phone, citizen.latitude as citizen_lat, citizen.longitude as citizen_lng,
          savior.id as savior_id, savior.name as savior_name, savior.phone as savior_phone, savior.latitude as savior_lat, savior.longitude as savior_lng
      from request
      inner join item on request.item_id = item.id
      inner join citizen on request.citizen_id = citizen.id
      left join savior on request.savior_id = savior.id
      where request.finished_date is NULL and request.savior_id =".$savior_id.";";

  

  $result = $db_link->query($took_over_requests_query);
  while($row = $result->fetch_assoc()) {
    $data["took_over_requests"][$row["request_id"]]["num_of_people"] = $row["num_of_people"];
    // { 1: { "num_of_people": $row["num_of_people"] } }
    $data["took_over_requests"][$row["request_id"]]["created_date"] = $row["created_date"];
    // { 1: { "num_of_people": $row["num_of_people"], "created_date", $row["created_date"] } }
    $data["took_over_requests"][$row["request_id"]]["took_over_date"] = $row["took_over_date"];
    // { 1: { "num_of_people": $row["num_of_people"], "created_date", $row["created_date"], "took_over_date":  $row["took_over_date"]}}
    $data["took_over_requests"][$row["request_id"]]["item_id"] = $row["item_id"];
    $data["took_over_requests"][$row["request_id"]]["item_name"] = $row["item_name"];
    $data["took_over_requests"][$row["request_id"]]["item_category"] = $row["item_category"];
    $data["took_over_requests"][$row["request_id"]]["citizen_id"] = $row["citizen_id"];
    $data["took_over_requests"][$row["request_id"]]["citizen_name"] = $row["citizen_name"];
    $data["took_over_requests"][$row["request_id"]]["citizen_phone"] = $row["citizen_phone"];
    
  }




  echo json_encode($data);
?>