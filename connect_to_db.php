<?php 
  //orizw to variable db_link se ayto to arxeio 
  // mysqli(URL ths bashs, username, password, onoma ths bashs)
  $db_link = new mysqli('localhost', 'root', 'root', 'web_project_2024'); //object που το εχω ονομασει db_link της κλασης mysqli

  if (mysqli_connect_error()) {
    die('Error connecting to database. Error: '. mysqli_connect_errno());
  }

  $db_link->query('SET CHARACTER SET utf8');    //η κλαση εχει μεθοδο query ,το query ειναι για να λειτουργησει η βαση σε ελληνικους χαρακτηρες
  $db_link->query('SET COLLATION_CONNECTION=utf8_general_ci');
 
?>