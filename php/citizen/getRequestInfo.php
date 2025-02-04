<?php 
  session_start();
  if( !isset( $_SESSION["username"] ) && !isset( $_SESSION["type"] )) {
    header("Location:../../index.php");
  } else if ( $_SESSION["type"] == "admin" ) {
    header("Location:../admin/adminHomepage.php");
  } else if ( $_SESSION["type"] == "savior" ) {
    header("Location:../savior/saviorHomepage.php");
  }

  header("Content-Type: application/json; charset=UTF-8");   //για το json ,λεει οτι ειναι τυπου json 
  include_once("../../connect_to_db.php");

  $query = "select 
              request.id, request.num_of_people, request.created_date, request.savior_id, request.took_over_date, 
              request.finished_date,
              item.name as item_name, 
              savior.name as savior_name,
              savior.phone as savior_phone
            from request 
            inner join citizen on request.citizen_id = citizen.id
            inner join item on request.item_id = item.id
            left join savior on request.savior_id = savior.id
            where citizen.username = '".$_SESSION["username"]."';";

  $result = $db_link->query($query);
  $data = array();

  while($row = $result->fetch_assoc()) {
    $data[$row["id"]]["num_of_people"] = (int)$row["num_of_people"];
    $data[$row["id"]]["created_date"] = $row["created_date"];
    $data[$row["id"]]["savior_id"] = $row["savior_id"];
    $data[$row["id"]]["took_over_date"] = $row["took_over_date"];
    $data[$row["id"]]["finished_date"] = $row["finished_date"];
    $data[$row["id"]]["item_name"] = $row["item_name"];
    $data[$row["id"]]["savior_name"] = $row["savior_name"];
    $data[$row["id"]]["phone"] = $row["savior_phone"];
  }

  echo json_encode($data); // εκτος το header χρειαζομαι και αυτο για το json ΕΠΙΣΗΣΣ αν γυρναει ενα στοιχειο δεν χρειαζεται αυτη την εντολη αν γυρναει πολλα την χρειαζεται
?>