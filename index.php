<?php
// Aquí podrías agregar cualquier código PHP que necesites, como por ejemplo incluir un archivo de configuración de base de datos

// Ejemplo: Conexión a la base de datos
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "mi_base_de_datos";
// $conn = new mysqli($servername, $username, $password, $dbname);
// if ($conn->connect_error) {
//     die("Conexión fallida: " . $conn->connect_error);
// }
// echo "Conectado correctamente";
// Fin del código PHP
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a Kokogest</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif; 
            margin: 0;
            display: flex;
            flex-direction: column;
            height: 100vh; 
            background-image: url('fondo.jpg'); /* Ruta relativa para fondo */
            background-size: cover; 
            background-repeat: no-repeat; 
            background-position: center; 
        }

        h1 {
            color: #d50b0b;
            text-align: center;
            margin-top: 20px;
        }

        p {
            color: #6432e3;
            font-size: 18px;
            line-height: 1.6;
            text-align: center;
            margin: 10px 20px; 
        }

        .container {
            display: flex;
            flex-direction: column; 
            align-items: center;
            flex-grow: 1;
            justify-content: flex-start;
            margin-top: 40px;
        }

        .section {
            display: flex;
            justify-content: center;
            margin: 20px;
            text-align: center;
            width: 80%; 
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            cursor: pointer; 
        }

        .section img {
            width: 150px;
            height: 150px;
            margin-right: 20px;
            border-radius: 10px;
        }

        .section h2 {
            color: #564caf; 
        }

        .section p {
            color: #333;
            font-size: 16px;
            width: 60%;
        }

        footer {
            margin-top: auto;
            text-align: center;
            background-color: rgba(0, 0, 0, 0.7); 
            color: #fff; 
            padding: 10px;
        }

        a {
            text-decoration: none; 
            color: inherit; 
        }

        .section:hover {
            background-color: rgba(255, 255, 255, 1); 
        }
    </style>
</head>
<body>

    <h1>Bienvenido a Kokogest</h1>
    <p>Bienvenido a Kokogest, la solución integral para la gestión de tu almacén. Con nuestro sistema, podrás gestionar de manera eficiente tu inventario. Kokogest se encarga de mantener actualizado el stock en tiempo real, lo que te permitirá tomar decisiones informadas. Ya sea que necesites registrar proveedores, clientes, nuestra plataforma te ofrece herramientas sencillas y potentes para optimizar la operación de tu negocio.</p>
    
    <div class="container">
        <a href="proveedores.php"> <!-- Cambié la extensión a .php -->
            <div class="section">
                <img src="proveedor.jpg" alt="Registro de Proveedores"> <!-- Ruta relativa para la imagen -->
                <div>
                    <h2>Registro de Proveedores</h2>
                    <p>Agrega y gestiona a tus proveedores con facilidad, manteniendo un registro detallado de sus datos y productos que suministran.</p>
                </div>
            </div>
        </a>

        <a href="clientes.php"> <!-- Cambié la extensión a .php -->
            <div class="section">
                <img src="cliente.jpg" alt="Registro de Clientes"> <!-- Ruta relativa para la imagen -->
                <div>
                    <h2>Registro de Clientes</h2>
                    <p>Administra los clientes que compran fiado, con opciones para autorizar pagos y controlar su deuda.</p>
                </div>
            </div>
        </a>

        <a href="roles.php"> <!-- Cambié la extensión a .php -->
            <div class="section">
                <img src="rol.jpg" alt="Administrar Roles"> <!-- Ruta relativa para la imagen -->
                <div>
                    <h2>Administrar roles</h2>
                    <p>En esta sección podrá administrar los distintos tipos de permisos.</p>
                </div>
            </div>
        </a>
    </div>

    <footer>
        <p>&copy; 2024 Kokogest. Todos los derechos reservados.</p>
    </footer>

</body>
</html>




