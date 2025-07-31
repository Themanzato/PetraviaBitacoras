<?php
include '../../Conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nombre'], $_POST['email'], $_POST['rol'], $_POST['password'])) {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $rol = $_POST['rol'];
    $contrasena = $_POST['password'];

    $query = "INSERT INTO usuarios (nombre, email, rol, contrasena, fecha_registro) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $nombre, $email, $rol, $contrasena);

    if ($stmt->execute()) {
        echo "<p>Usuario agregado correctamente.</p>";
        header("Location: usuarios_principal.php");
    } else {
        echo "<p>Error al agregar el usuario.</p>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<p>No se proporcionaron datos válidos para agregar el usuario.</p>";
}
?>
