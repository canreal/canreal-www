<?php
  $host = "localhost";
  $username = "root";
  $password = "";
  $database = "contributions";

  //Establish connection
  $dbconnection = new mysqli($host, $username, $password, $database);

  //Check connection
  if ($dbconnection->connect_error) {
    die("Connection failed: " . $dbconnection->connect_error);
  }
?>
