<?php

require_once './bd.php';

$bd = new BDHandler();
$bd->connect();

$query = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/asaed4a.sql');
$res = $bd->query($query);
if (!$res) die("Failed query: " . $query);

$bd->disconnect();

header('Location: /index.php');

