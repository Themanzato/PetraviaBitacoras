<?php
$servername = "bitacora-digital.chiqsu2wgpks.us-east-2.rds.amazonaws.com";
$username = "admin";
$password = "Aymimadreelbicho*7";
$dbname = "bitacorasMantenimientoOP2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>