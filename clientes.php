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

// Procesar el formulario para editar los datos de un cliente
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_cliente'])) {
    $run = $_POST['run'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $celular = $_POST['celular'];
    $correo = $_POST['correo'];
    $fiado = $_POST['fiado'];

    // Actualizar los datos del cliente
    $sql = "UPDATE cliente SET nombre='$nombre', apellido='$apellido', celular='$celular', correo='$correo', fiado='$fiado' WHERE run='$run'";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green;'>Cliente actualizado exitosamente.</p>";
    } else {
        echo "<p style='color:red;'>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}

// Obtener los datos del cliente seleccionado para editar
$cliente = null;
if (isset($_GET['editar_cliente'])) {
    $run = $_GET['editar_cliente'];
    $sql = "SELECT * FROM cliente WHERE run='$run'";
    $result = $conn->query($sql);
    $cliente = $result->fetch_assoc();
}

// Obtener la lista de todos los clientes registrados
$sql = "SELECT * FROM cliente";
$clientes = $conn->query($sql);

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
        <p>Esta página está destinada a gestionar la información de los clientes. Aquí podrás añadir, editar y ver los datos de los clientes.</p>
        
        <!-- Opciones de acción -->
        <a href="#" class="btn" onclick="document.getElementById('addClientForm').style.display='block'">Agregar cliente</a>
        <a href="#" class="btn" onclick="document.getElementById('editClientForm').style.display='block'">Editar cliente</a>
        <a href="#" class="btn" onclick="document.getElementById('viewClientForm').style.display='block'">Ver datos</a>

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

        <!-- Formulario para editar un cliente -->
        <div id="editClientForm" style="display:none; margin-top: 20px; text-align: left;">
            <h2>Editar Cliente</h2>
            <form method="GET" action="">
                <input type="text" name="editar_cliente" placeholder="Ingrese el RUN del cliente" required>
                <input type="submit" value="Buscar Cliente">
            </form>
            <?php if ($cliente): ?>
                <!-- Si se ha encontrado el cliente -->
                <form method="POST" action="">
                    <input type="text" name="run" placeholder="RUN del cliente" value="<?php echo isset($cliente) ? $cliente['run'] : ''; ?>" required readonly>
                    <input type="text" name="nombre" placeholder="Nombre del cliente" value="<?php echo isset($cliente) ? $cliente['nombre'] : ''; ?>" required>
                    <input type="text" name="apellido" placeholder="Apellido del cliente" value="<?php echo isset($cliente) ? $cliente['apellido'] : ''; ?>" required>
                    <input type="text" name="celular" placeholder="Número de celular" value="<?php echo isset($cliente) ? $cliente['celular'] : ''; ?>" required>
                    <input type="email" name="correo" placeholder="Correo electrónico" value="<?php echo isset($cliente) ? $cliente['correo'] : ''; ?>" required>
                    <label for="fiado">¿Fiado?</label>
                    <select name="fiado" required>
                        <option value="1" <?php echo (isset($cliente) && $cliente['fiado'] == 1) ? 'selected' : ''; ?>>Sí</option>
                        <option value="0" <?php echo (isset($cliente) && $cliente['fiado'] == 0) ? 'selected' : ''; ?>>No</option>
                    </select>
                    <input type="submit" name="edit_cliente" value="Editar Cliente">
                </form>
            <?php elseif (isset($_GET['editar_cliente'])): ?>
                <p>No se encontró ningún cliente con ese RUN.</p>
            <?php endif; ?>
        </div>

        <!-- Ver los datos de los clientes -->
        <div id="viewClientForm" style="display:none; margin-top: 20px; text-align: left;">
            <h2>Clientes Registrados</h2>
            <table>
                <thead>
                    <tr>
                        <th>RUN</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Celular</th>
                        <th>Correo</th>
                        <th>Fiado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $clientes->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['run']; ?></td>
                            <td><?php echo $row['nombre']; ?></td>
                            <td><?php echo $row['apellido']; ?></td>
                            <td><?php echo $row['celular']; ?></td>
                            <td><?php echo $row['correo']; ?></td>
                            <td><?php echo $row['fiado'] ? 'Sí' : 'No'; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <p><a href="index.php">Volver a la página principal</a></p>
    </div>

</body>
</html>
