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
  include_once("../../connect_to_db.php");

  $savior_id_query = "select id from savior where username = '".$_SESSION["username"]."';";
  $result = $db_link->query($savior_id_query);
  $savior_id = null;
  while($row = $result->fetch_assoc()) { $savior_id = (int)$row["id"]; }
  if (is_null($savior_id)) {echo "savior_id: $savior_id"; return;}

  $offerId = $_POST["offerId"];

  // get the number of requests for this savior
  $request_count_query = "SELECT count(*) as req_count FROM request WHERE savior_id = " . $savior_id . " AND finished_date IS NULL;";

  $result = $db_link->query($request_count_query);
  $request_num = null;
  while($row = $result->fetch_assoc()) { $request_num = (int)$row["req_count"]; }
  if (is_null($request_num)) {echo "request_num: $request_num"; return;} // this variable HAS TO BE a number 0, 1, 2, ...

  // get the number of offers for this savior
  $offer_count_query = "SELECT count(*) as offer_count FROM offer WHERE savior_id = " . $savior_id . " AND finished_date IS NULL;";

  $result = $db_link->query($offer_count_query);
  $offer_num = null;
  while($row = $result->fetch_assoc()) { $offer_num = (int)$row["offer_count"]; }
  if (is_null($offer_num)) {echo "offer num: $offer_num"; return;} // this variable HAS TO BE a number 0, 1, 2, ...

  if(($offer_num + $request_num) >= 4) {
    echo "4_task_limit_reached";
    return;
  }

  $query = "update offer set savior_id = ".$savior_id.", took_over_date = CURRENT_TIMESTAMP where id = ".$offerId.";";
  $db_link->query($query);

  echo "done";
?>