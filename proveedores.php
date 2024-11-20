<?php
// Aquí podrías agregar cualquier código PHP, por ejemplo para manejar el registro de clientes, conectar con base de datos, etc.
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
    <title>Registro de Clientes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .content {
            text-align: center;
            padding: 20px;
        }
        .btn {
            background-color: #4CAF50; /* color verde */
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #45a049; /* cambio de color al pasar el ratón */
        }
    </style>
</head>
<body>

    <h1>Registro de Clientes</h1>
    <div class="content">
        <p>Esta página está destinada a gestionar la información de los clientes. Aquí podrás añadir y editar sus datos.</p>
        
        <!-- Opciones de acción -->
        <a href="#" class="btn">Agregar cliente</a> <!-- Aquí puedes poner un formulario o acción con PHP -->
        <a href="#" class="btn">Ver datos</a> <!-- Aquí podrías poner una acción para ver los datos -->
        <p><a href="index.php">Volver a la página principal</a></p>
    </div>

</body>
</html>




