<?php
// Aquí podrías agregar cualquier código PHP necesario, por ejemplo para conectar con la base de datos, manejar formularios, etc.
// Ejemplo: Conexión a la base de datos
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "mi_base_de_datos";
// $conn = new mysqli($servername, $username, $password, $dbname);
// if ($conn->connect_error) {
//     die("Conexión fallida: " . $conn->connect_error);
// }
// Fin del código PHP
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Proveedores</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #800080; /* Color morado */
            background-image: url('infoProveedor.jpg'); /* Ruta de la imagen */
            background-size: cover; /* Hace que la imagen cubra toda la pantalla */
            background-position: center; /* Centra la imagen */
            background-attachment: fixed; /* Fija la imagen en el fondo */
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #d50b0b;
            text-align: center;
            margin-top: 20px;
        }
        .content {
            text-align: center;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.5); /* Fondo semitransparente para que el texto sea legible */
            border-radius: 10px;
            color: white; /* Color del texto en el contenido */
        }
        .buttons {
            margin-top: 20px;
        }
        .buttons a {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            margin: 5px;
            border-radius: 5px;
            font-size: 16px;
        }
        .buttons a:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <h1>Registro de Proveedores</h1>
    <div class="content">
        <p>Esta es la página donde se gestionan los proveedores. Aquí podrás añadir, editar o eliminar proveedores según sea necesario.</p>
        <div class="buttons">
            <a href="#">Agregar nuevo proveedor</a>
            <a href="#">Editar proveedor</a>
            <a href="#">Eliminar proveedor</a>
            <a href="#">Ver detalles del proveedor</a>
        </div>
        <p><a href="index.php" style="color: white; text-decoration: none;">Volver a la página principal</a></p>
    </div>

</body>
</html>





