<?php 
  session_start();
  if( !isset( $_SESSION["username"] ) && !isset( $_SESSION["type"] )) {       //insert items in base json
    header("Location:../../index.php");
  } 
  else if ( $_SESSION["type"] == "savior" ) {
    header("Location:../savior/saviorHomepage.php");
  } 
  else if ( $_SESSION["type"] == "citizen" ) {
    header("Location:../citizen/citizenHomepage.php");
  }
  include_once("../../connect_to_db.php");

  $items_to_insert = $_POST["items"]; 
    // $_POST =
    // {
    //  items: [
    //    {item_id: 10, item_name: "a name", item_category: "category", item_quantity: 100},
    //    {item_id: 5, item_name: "a name 5", item_category: "category 5", item_quantity: 5}
    //  ]
    //}

  foreach ($items_to_insert as $item) {  //για καθε item που σταλθηκε(items_to_insert) στα items που σταλθηκαν ονομασετε item 
    if(isset($item["item_quantity"])) {  //αν εχουμε θεσει ποσοτητα 
      $query = "insert into item (id, name, category, quantity) VALUES
      (".$item["item_id"].", '".$item["item_name"]."', '".$item["item_category"]."', ".$item["item_quantity"].")
      on duplicate key update name = values(name), category = values(category), quantity = values(quantity);"; 
      //duplicate key :  στα συγκεκριμενα ειναι το id του item (γιατι αυτο ειναι το primary key)
    }
    else {
      $query = "insert into item (id, name, category) VALUES
      (".$item["item_id"].", '".$item["item_name"]."', '".$item["item_category"]."')
      on duplicate key update name = values(name), category = values(category);";
    }

    $db_link->query($query);
  }

  echo "DONE";
?>