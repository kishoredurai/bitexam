<?php
$db = mysqli_connect('10.10.237.153', 'test', 'test', 'online_examination');
if (!$db) {
  die("Connection failed: " . mysqli_connect_error());
}
try
{
  $bdd = new PDO('mysql:host=10.10.237.153;dbname=online_examination;charset=utf8', 'test', 'test');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
?>


