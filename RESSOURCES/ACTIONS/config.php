<?php

define("DB",
    "mysql:" .
    "host=localhost;" .
    "dbname=asaed4a");
define("USER", "asaed4a");
define("PWD", "gakoF4sa");


require $_SERVER["DOCUMENT_ROOT"]."/RESSOURCES/ROOT/htmlConstructor.php";
$paraFile = new htmlConstructor();

session_start();
isset($_SESSION['isConnected']) ? $isConnected = $_SESSION['isConnected'] : $isConnected = false;
isset($_SESSION['isAdmin']) ? $isAdmin = $_SESSION['isAdmin'] : $isAdmin = false;

?>