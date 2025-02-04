<?php 
session_start();
if (!isset($_SESSION["username"]) || !isset($_SESSION["type"])) {
    header("Location:../../index.php");
    exit;
} else if ($_SESSION["type"] == "savior") {
    header("Location:../savior/saviorHomepage.php");
    exit;
} else if ($_SESSION["type"] == "citizen") {
    header("Location:../citizen/citizenHomepage.php");
    exit;
}

header("Content-Type: application/json; charset=UTF-8");
include_once("../../connect_to_db.php");

$id = $_GET["id"];

if ($id !== null) {
    $query = "SELECT * FROM detail WHERE item_id = ".$id."";    
    $result = $db_link->query($query);

    $data = array();
    $i = 0;
    while ($row = $result->fetch_assoc()) {
        $data[$i]["name"] = $row['name'];
        $data[$i]["value"] = $row['value'];
        $i ++;  //gia na parei ola ta details 
    }
    echo json_encode($data);
} 

?>