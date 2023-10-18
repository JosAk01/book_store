<?php
error_reporting(E_ALL);
define("DBNAME", "book_store");
define("DBUSER","root");
define("DBPASS","");

try{
  $conn = new PDO("mysql:host=localhost;dbname=".DBNAME,DBUSER,DBPASS);
  $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
  echo $e->getMessage();
}
?>