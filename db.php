<?php
$host = 'localhost';
$user = 'root';
$pass = ''; // en XAMPP, el usuario root no tiene contraseña por defecto
$db = 'inscripciones_db';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
