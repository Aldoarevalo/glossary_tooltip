<?php

// Verifica si se ha recibido una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtén los valores enviados desde el formulario
    $word = $_POST['word'];
    $descripcion = $_POST['descripcion'];

    // Valida los datos recibidos si es necesario

    // Realiza la operación de guardado en la base de datos
    $servername = "localhost";
    $database = "drupal";
    $username = "root";
    $password = "";

    $conn = mysqli_connect($servername, $username, $password, $database);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "INSERT INTO glossary_table (word, descripcion) VALUES ('$word', '$descripcion')";

    if (mysqli_query($conn, $sql)) {
        echo "La palabra se ha guardado correctamente";
    } else {
        echo "Error al guardar la palabra: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo "Acceso denegado";
}
