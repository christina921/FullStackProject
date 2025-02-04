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
require_once("../../connect_to_db.php"); // Ensuring the database connection file is properly included


$response = [];

if (isset($_POST['itemName']) && is_array($_POST['itemName'])) {
    $allSuccessful = true; // Flag to check if all operations were successful

    foreach ($_POST['itemName'] as $itemName) {
        $db_link->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
        try {
            $itemQuery = $db_link->prepare("SELECT id FROM item WHERE name = ?");
            $itemQuery->bind_param("s", $itemName); // 's' to denote string type
            $itemQuery->execute();
            $result = $itemQuery->get_result();
            $item = $result->fetch_assoc();

            if (!$item) {                  //goes to the catch exceptioon part
                throw new Exception("Item not found: $itemName");
            }

            // Insert a new announcement
            $announceQuery = $db_link->prepare("INSERT INTO announcement (created_date) VALUES (CURRENT_TIMESTAMP)");
            $announceQuery->execute();
            $announcementId = $db_link->insert_id;

            // Link the announcement to the item
            $linkQuery = $db_link->prepare("INSERT INTO announProd (announcementId, item_id) VALUES (?, ?)");
            $linkQuery->bind_param("ii", $announcementId, $item['id']); // 'ii' because both are integers
            $linkQuery->execute();

            // Commit transaction
            $db_link->commit();

        } catch (Exception $e) { //catch every exception in the try part
            $db_link->rollback(); //rolback the transaction gia na mhn ginoun merikes allages sthn bash
            $response[] = ['error' => $e->getMessage()];
            $allSuccessful = false; // Set flag to false as there was an error
        }
    }

    if ($allSuccessful) {
        echo json_encode("done"); // Echo 'done' only if all announcements were successful
    } else {
        echo json_encode($response); // Otherwise, output errors
    }

} 


