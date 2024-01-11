<?php

$dbname = "stands";
$dbhost = "localhost";
$dbpass = "Greta1234!";
$dbuser = "greta";

try {
    $dsn = "mysql:dbname=".$dbname.";host=".$dbhost;
    $db = new PDO($dsn, $dbuser, $dbpass);
    $db->exec("SET NAMES utf8");
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    // echo "connecté à la bdd";
    

}catch(PDOException $e) {
    die($e->getMessage());
}

?>