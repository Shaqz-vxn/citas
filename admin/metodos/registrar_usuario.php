<?php
require_once '../model/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre     = $_POST["nombre"];
    $username   = $_POST["username"];
    $password   = $_POST["password"];
    $cargo_id   = intval($_POST["cargo_id"]);

    // Cifrar contraseña
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert con cargo y área
    $query = "INSERT INTO usuarios (nombre, username, password, cargo_id)
              VALUES (:nombre, :username, :password, :cargo_id)";

    $stmt = $db->prepare($query);

    // Bind seguro
    $stmt->bindParam(":nombre", $nombre);
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":password", $hashed_password);
    $stmt->bindParam(":cargo_id", $cargo_id);

    if ($stmt->execute()) {
        echo "Registro exitoso. ¡Bienvenido, $nombre!";
    } else {
        echo "Error en el registro. Por favor, inténtalo de nuevo.";
    }
}
?>
