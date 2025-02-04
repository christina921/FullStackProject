<?php 
  session_start();
  if( !isset( $_SESSION["username"] ) && !isset( $_SESSION["type"] )) {
    header("Location:../../index.php");
  } else if ( $_SESSION["type"] == "admin" ) {
    header("Location:../admin/adminHomepage.php");
  } else if ( $_SESSION["type"] == "savior" ) {
    header("Location:../savior/saviorHomepage.php");
  }
  include_once("../../connect_to_db.php");

  $username = $_SESSION["username"];
  $itemName = $_POST["item_name"];
  $numOfPeople = $_POST["people_num"];
  
  // username ετσι οπως ειναι τσεκαρισμενα απο το signup ειναι μοναδικα αλλα στην περιπτωση που κατι παει στραβα βαζω εξτρα     
  // προστασια το limit 1  , το username το παιρνω απο το session variable 

  $query = "insert into request (citizen_id, item_id, num_of_people)  
  value ((select id from citizen where username = '".$username."' limit 1),    
  (select id from item where name = '".$itemName."' limit 1), ".$numOfPeople.");";

  $db_link->query($query);

  echo "done";
?>