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

  $data = array();

  $took_over_requests_query = "select 
        request.id as request_id, request.num_of_people, request.created_date, request.took_over_date,
          item.id as item_id, item.name as item_name, item.category as item_category,
          citizen.id as citizen_id, citizen.name as citizen_name, citizen.phone as citizen_phone, citizen.latitude as citizen_lat, citizen.longitude as citizen_lng,
          savior.id as savior_id, savior.name as savior_name, savior.phone as savior_phone, savior.latitude as savior_lat, savior.longitude as savior_lng
      from request
      inner join item on request.item_id = item.id
      inner join citizen on request.citizen_id = citizen.id
      left join savior on request.savior_id = savior.id
      where request.finished_date is NULL and request.savior_id is not NULL;";

  

  $result = $db_link->query($took_over_requests_query);
  while($row = $result->fetch_assoc()) {
    $data["took_over_requests"][$row["request_id"]]["num_of_people"] = $row["num_of_people"];
    //το "took_over_requests ειναι ο γονιος και μετα το πρωτο παιδι ειναι το κλειδι το id και το δευτερο η πληροφορια
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
    $data["took_over_requests"][$row["request_id"]]["citizen_lat"] = $row["citizen_lat"];
    $data["took_over_requests"][$row["request_id"]]["citizen_lng"] = $row["citizen_lng"];
    $data["took_over_requests"][$row["request_id"]]["savior_id"] = $row["savior_id"];
    $data["took_over_requests"][$row["request_id"]]["savior_name"] = $row["savior_name"];
    $data["took_over_requests"][$row["request_id"]]["savior_phone"] = $row["savior_phone"];
    $data["took_over_requests"][$row["request_id"]]["savior_lat"] = $row["savior_lat"];
    $data["took_over_requests"][$row["request_id"]]["savior_lng"] = $row["savior_lng"];
  }



  

  $requests_query = "select 
      request.id as request_id, request.num_of_people, request.created_date, request.took_over_date,
        item.id as item_id, item.name as item_name, item.category as item_category,
        citizen.id as citizen_id, citizen.name as citizen_name, citizen.phone as citizen_phone, citizen.latitude as citizen_lat, citizen.longitude as citizen_lng,
        savior.id as savior_id, savior.name as savior_name, savior.phone as savior_phone, savior.latitude as savior_lat, savior.longitude as savior_lng
    from request
    inner join item on request.item_id = item.id
    inner join citizen on request.citizen_id = citizen.id
    left join savior on request.savior_id = savior.id
    where request.finished_date is NULL and request.savior_id is NULL;";

  $result = $db_link->query($requests_query);

  while($row = $result->fetch_assoc()) { // σε καθε επαναληψη κανει retrieve ενα row 
    // stores data into a structured associative array
    $data["requests"][$row["request_id"]]["num_of_people"] = $row["num_of_people"];
    // { 1: { "num_of_people": $row["num_of_people"] } }
    $data["requests"][$row["request_id"]]["created_date"] = $row["created_date"];
    // { 1: { "num_of_people": $row["num_of_people"], "created_date", $row["created_date"] } }
    $data["requests"][$row["request_id"]]["took_over_date"] = $row["took_over_date"];
    // { 1: { "num_of_people": $row["num_of_people"], "created_date", $row["created_date"], "took_over_date":  $row["took_over_date"]}}
    $data["requests"][$row["request_id"]]["item_id"] = $row["item_id"];
    $data["requests"][$row["request_id"]]["item_name"] = $row["item_name"];
    $data["requests"][$row["request_id"]]["item_category"] = $row["item_category"];
    $data["requests"][$row["request_id"]]["citizen_id"] = $row["citizen_id"];
    $data["requests"][$row["request_id"]]["citizen_name"] = $row["citizen_name"];
    $data["requests"][$row["request_id"]]["citizen_phone"] = $row["citizen_phone"];
    $data["requests"][$row["request_id"]]["citizen_lat"] = $row["citizen_lat"];
    $data["requests"][$row["request_id"]]["citizen_lng"] = $row["citizen_lng"];
    $data["requests"][$row["request_id"]]["savior_id"] = $row["savior_id"];
    $data["requests"][$row["request_id"]]["savior_name"] = $row["savior_name"];
    $data["requests"][$row["request_id"]]["savior_phone"] = $row["savior_phone"];
    $data["requests"][$row["request_id"]]["savior_lat"] = $row["savior_lat"];
    $data["requests"][$row["request_id"]]["savior_lng"] = $row["savior_lng"];
  }


  $took_over_offers_query = "select 
      offer.id as offer_id, offer.quantity, offer.created_date, offer.took_over_date,
      item.id as item_id, item.name as item_name, item.category as item_category,
      citizen.id as citizen_id, citizen.name as citizen_name, citizen.phone as citizen_phone, citizen.latitude as citizen_lat, citizen.longitude as citizen_lng,
      savior.id as savior_id, savior.name as savior_name, savior.phone as savior_phone, savior.latitude as savior_lat, savior.longitude as savior_lng
  from offer
  inner join item on offer.item_id = item.id
  inner join citizen on offer.citizen_id = citizen.id
  left join savior on offer.savior_id = savior.id
  where offer.finished_date is NULL and offer.canceled = false and offer.savior_id is not NULL;";

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
    $data["took_over_offers"][$row["offer_id"]]["citizen_lat"] = $row["citizen_lat"];
    $data["took_over_offers"][$row["offer_id"]]["citizen_lng"] = $row["citizen_lng"];
    $data["took_over_offers"][$row["offer_id"]]["savior_id"] = $row["savior_id"];
    $data["took_over_offers"][$row["offer_id"]]["savior_name"] = $row["savior_name"];
    $data["took_over_offers"][$row["offer_id"]]["savior_phone"] = $row["savior_phone"];
    $data["took_over_offers"][$row["offer_id"]]["savior_lat"] = $row["savior_lat"];
    $data["took_over_offers"][$row["offer_id"]]["savior_lng"] = $row["savior_lng"];
  }

  $offers_query = "select 
      offer.id as offer_id, offer.quantity, offer.created_date, offer.took_over_date,
      item.id as item_id, item.name as item_name, item.category as item_category,
      citizen.id as citizen_id, citizen.name as citizen_name, citizen.phone as citizen_phone, citizen.latitude as citizen_lat, citizen.longitude as citizen_lng,
      savior.id as savior_id, savior.name as savior_name, savior.phone as savior_phone, savior.latitude as savior_lat, savior.longitude as savior_lng
  from offer
  inner join item on offer.item_id = item.id
  inner join citizen on offer.citizen_id = citizen.id
  left join savior on offer.savior_id = savior.id
  where offer.finished_date is NULL and offer.canceled = false and offer.savior_id is NULL;";

  $result = $db_link->query($offers_query);

  while($row = $result->fetch_assoc()) {
    $data["offers"][$row["offer_id"]]["quantity"] = $row["quantity"];
    // {"offers": { 1: { "quantity": $row["quantity"] } }}
    $data["offers"][$row["offer_id"]]["created_date"] = $row["created_date"];
    // { 1: { "quantity": $row["quantity"], "created_date", $row["created_date"] } }
    $data["offers"][$row["offer_id"]]["took_over_date"] = $row["took_over_date"];
    // { 1: { "quantity": $row["quantity"], "created_date", $row["created_date"], "took_over_date":  $row["took_over_date"]}}
    $data["offers"][$row["offer_id"]]["item_id"] = $row["item_id"];
    $data["offers"][$row["offer_id"]]["item_name"] = $row["item_name"];
    $data["offers"][$row["offer_id"]]["item_category"] = $row["item_category"];
    $data["offers"][$row["offer_id"]]["citizen_id"] = $row["citizen_id"];
    $data["offers"][$row["offer_id"]]["citizen_name"] = $row["citizen_name"];
    $data["offers"][$row["offer_id"]]["citizen_phone"] = $row["citizen_phone"];
    $data["offers"][$row["offer_id"]]["citizen_lat"] = $row["citizen_lat"];
    $data["offers"][$row["offer_id"]]["citizen_lng"] = $row["citizen_lng"];
    $data["offers"][$row["offer_id"]]["savior_id"] = $row["savior_id"];
    $data["offers"][$row["offer_id"]]["savior_name"] = $row["savior_name"];
    $data["offers"][$row["offer_id"]]["savior_phone"] = $row["savior_phone"];
    $data["offers"][$row["offer_id"]]["savior_lat"] = $row["savior_lat"];
    $data["offers"][$row["offer_id"]]["savior_lng"] = $row["savior_lng"];
  }

  $offers_query = "select * from buildinglocation;";

  $result = $db_link->query($offers_query);

  while($row = $result->fetch_assoc()) {
    $data["buildinglocation"]["latitude"] = $row["latitude"];
    // {"offers": { 1: { "quantity": $row["quantity"] } }}
    $data["buildinglocation"]["longitude"] = $row["longitude"];
  }


  $saviorsfree_query = "SELECT savior.id,savior.username,savior.name,savior.phone, savior.latitude,savior.longitude,
    saviorItems.quantity, saviorItems.item_id, item.name
    FROM savior
    LEFT JOIN request ON savior.id = request.savior_id
    LEFT JOIN offer ON savior.id = offer.savior_id
    LEFT JOIN saviorItems ON savior.id = saviorItems.savior_id
    left join item ON saviorItems.item_id = item.id
    
    WHERE request.savior_id IS NULL AND offer.savior_id IS NULL;";

 $result = $db_link->query($saviorsfree_query);

 while($row = $result->fetch_assoc()) {
  $data["saviors_free"][$row["id"]]["username"] = $row["username"];
  // {"offers": { 1: { "quantity": $row["quantity"] } }}
  $data["saviors_free"][$row["id"]]["name"] = $row["name"];
  // { 1: { "quantity": $row["quantity"], "created_date", $row["created_date"] } }
  $data["saviors_free"][$row["id"]]["phone"] = $row["phone"];
  $data["saviors_free"][$row["id"]]["latitude"] = $row["latitude"];
  $data["saviors_free"][$row["id"]]["longitude"] = $row["longitude"];

  $data["saviors_free"][$row["id"]]["saviorItems"][$row["item_id"]]["name"] = $row["name"];
  $data["saviors_free"][$row["id"]]["saviorItems"][$row["item_id"]]["quantity"] = $row["quantity"];


 }




//saviors that have at least one offer  at this time

 $saviorsO_query = "SELECT 
 savior.id AS savior_id,
 savior.username,
 savior.name,
 savior.phone,
 savior.latitude,
 savior.longitude,
 offer.quantity AS offer_quantity,
 offer.created_date AS offer_created_day,
 offer.took_over_date AS offer_took_over_date,
 saviorItems.quantity, saviorItems.item_id, item.name as item_name
 
FROM 
 savior
LEFT JOIN 
 offer ON savior.id = offer.savior_id
 LEFT JOIN saviorItems ON savior.id = saviorItems.savior_id
 left join item ON saviorItems.item_id = item.id
WHERE 
 offer.savior_id IS NOT NULL AND 
 offer.finished_date IS NULL;
";

$result = $db_link->query($saviorsO_query);

while ($row = $result->fetch_assoc()) {
    // Initialize the savior data if it hasn't been initialized yet
    if (!isset($data["saviorsO"][$row["savior_id"]])) {
        $data["saviorsO"][$row["savior_id"]] = [
            "username" => $row["username"],
            "name" => $row["name"],
            "phone" => $row["phone"],
            "latitude" => $row["latitude"],
            "longitude" => $row["longitude"],
            "offers" => [],  // Initialize an empty array to store offers
            "savior_items" => []
        ];
    }

    // Append each offer to the savior's offers array gia na mporei na exei polla offers
    $data["saviorsO"][$row["savior_id"]]["offers"][] = [
        "offer_quantity" => $row["offer_quantity"],
        "offer_created_day" => $row["offer_created_day"],
        "offer_took_over_date" => $row["offer_took_over_date"]
    ];

    // Append each item to the savior's items array gia na mporei na exei polla items
    $data["saviorsO"][$row["savior_id"]]["savior_items"][$row["item_id"]] = [
      "item_quantity" => $row["quantity"],
      "item_id" => $row["item_id"],
      "item_name" => $row["item_name"]
    ];
}





//saviors that have at least one request  at this time

 $saviorsR_query = " SELECT savior.id AS savior_id,
 savior.username,
 savior.name,
 savior.phone,
 savior.latitude,
 savior.longitude,

 request.num_of_people,
 request.created_date AS request_created_day,
 request.took_over_date AS request_took_over_date,
 saviorItems.quantity, saviorItems.item_id, item.name as item_name
 FROM savior

 left JOIN request ON savior.id = request.savior_id
 LEFT JOIN saviorItems ON savior.id = saviorItems.savior_id
 left join item ON saviorItems.item_id = item.id

WHERE request.savior_id IS NOT NULL  AND request.finished_date is NULL  ;
";

$result = $db_link->query($saviorsR_query);




 while ($row = $result->fetch_assoc()) {
  // Initialize the savior data if it hasn't been initialized yet
  if (!isset($data["saviorsR"][$row["savior_id"]])) {
      $data["saviorsR"][$row["savior_id"]] = [
          "username" => $row["username"],
          "name" => $row["name"],
          "phone" => $row["phone"],
          "latitude" => $row["latitude"],
          "longitude" => $row["longitude"],
          "requests" => [],  // Initialize an empty array to store offers
          "savior_items" => []
      ];
  }

  // Append each offer to the savior's offers array gia na mporei na exei polla offers
  $data["saviorsR"][$row["savior_id"]]["offers"][] = [
      "num_of_people" => $row["num_of_people"],
      "request_created_day" => $row["request_created_day"],
      "request_took_over_date" => $row["request_took_over_date"]
  ];

  // Append each item to the savior's items array gia na mporei na exei polla items
  $data["saviorsR"][$row["savior_id"]]["savior_items"][$row["item_id"]] = [
    "item_quantity" => $row["quantity"],
    "item_id" => $row["item_id"],
    "item_name" => $row["item_name"]
  ];
}








  echo json_encode($data);
?>