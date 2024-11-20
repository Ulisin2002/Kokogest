<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registroproovedores_kokositas"; // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Procesar el formulario para agregar un nuevo cliente
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_cliente'])) {
    $run = $_POST['run'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $celular = $_POST['celular'];
    $correo = $_POST['correo'];
    $fiado = $_POST['fiado'];

    // Insertar en la base de datos
    $sql = "INSERT INTO cliente (run, nombre, apellido, celular, correo, fiado) 
            VALUES ('$run', '$nombre', '$apellido', '$celular', '$correo', '$fiado')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green;'>Cliente agregado exitosamente.</p>";
    } else {
        echo "<p style='color:red;'>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}

// Obtener los datos de los clientes para verlos
if (isset($_GET['ver_datos'])) {
    $sql = "SELECT * FROM cliente";
    $result = $conn->query($sql);
}

$conn->close();
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>

    <h1>Registro de Clientes</h1>
    <div class="content">
        <p>Esta página está destinada a gestionar la información de los clientes. Aquí podrás añadir y ver los datos de los clientes.</p>
        
        <!-- Opciones de acción -->
        <a href="#" class="btn" onclick="document.getElementById('addClientForm').style.display='block'">Agregar cliente</a>
        <a href="?ver_datos=true" class="btn">Ver datos</a>

        <!-- Formulario para agregar un cliente -->
        <div id="addClientForm" style="display:none; margin-top: 20px; text-align: left;">
            <h2>Agregar Cliente</h2>
            <form method="POST" action="">
                <input type="text" name="run" placeholder="RUN del cliente" required>
                <input type="text" name="nombre" placeholder="Nombre del cliente" required>
                <input type="text" name="apellido" placeholder="Apellido del cliente" required>
                <input type="text" name="celular" placeholder="Número de celular" required>
                <input type="email" name="correo" placeholder="Correo electrónico" required>
                <label for="fiado">¿Fiado?</label>
                <select name="fiado" required>
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </select>
                <input type="submit" name="add_cliente" value="Agregar Cliente">
            </form>
        </div>

        <?php
        // Mostrar datos de los clientes si se selecciona "Ver datos"
        if (isset($result) && $result->num_rows > 0) {
            echo "<h2>Clientes Registrados</h2>";
            echo "<table>";
            echo "<tr><th>RUN</th><th>Nombre</th><th>Apellido</th><th>Celular</th><th>Correo</th><th>Fiado</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row['run'] . "</td><td>" . $row['nombre'] . "</td><td>" . $row['apellido'] . "</td><td>" . $row['celular'] . "</td><td>" . $row['correo'] . "</td><td>" . ($row['fiado'] ? 'Sí' : 'No') . "</td></tr>";
            }
            echo "</table>";
        }
        ?>

        <p><a href="index.php">Volver a la página principal</a></p>
    </div>

</body>
</html>
