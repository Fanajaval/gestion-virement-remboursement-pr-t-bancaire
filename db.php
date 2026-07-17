<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "virement_pret_bancaire";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Echec de connexion :" . $conn->connect_error);
}
?>