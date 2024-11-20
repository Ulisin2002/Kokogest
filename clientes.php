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

// Procesar el formulario para eliminar un cliente
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_cliente'])) {
    $run = $_POST['run'];

    // Verificar si el cliente existe antes de eliminar
    $sql_check = "SELECT * FROM cliente WHERE run='$run'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        // Eliminar el cliente
        $sql_delete = "DELETE FROM cliente WHERE run='$run'";
        if ($conn->query($sql_delete) === TRUE) {
            echo "<p style='color:green;'>Cliente eliminado exitosamente.</p>";
        } else {
            echo "<p style='color:red;'>Error al eliminar el cliente: " . $conn->error . "</p>";
        }
    } else {
        echo "<p style='color:red;'>No se encontró ningún cliente con ese RUN.</p>";
    }
}

// Obtener los datos del cliente seleccionado para editar
$cliente = null;
$cliente_no_existe = false;
if (isset($_POST['buscar_cliente'])) {
    $run = $_POST['run'];
    $sql = "SELECT * FROM cliente WHERE run='$run'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // Si el cliente existe, mostramos sus datos para editar
        $cliente = $result->fetch_assoc();
    } else {
        // Si no existe, mostramos un mensaje de error
        $cliente_no_existe = true;
    }
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
            background-image: url('clientePagina.jpg'); /* Reemplaza con el nombre de tu imagen */
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 20px;
            color: white;
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .content {
            text-align: center;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.5); /* Fondo semitransparente para mejorar la legibilidad */
            border-radius: 8px;
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
        input[type="text"], input[type="email"], select {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        form {
            margin-top: 20px;
            text-align: left;
            width: 300px;
            margin: 0 auto;
        }
        .error {
            color: red;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <h1>Registro de Clientes</h1>
    <div class="content">
        <p>Esta página está destinada a gestionar la información de los clientes. Aquí podrás añadir, editar, eliminar y ver los datos de los clientes.</p>
        
        <!-- Opciones de acción -->
        <a href="#" class="btn" onclick="document.getElementById('addClientForm').style.display='block'">Agregar cliente</a>
        <a href="#" class="btn" onclick="document.getElementById('editClientForm').style.display='block'">Editar cliente</a>
        <a href="#" class="btn" onclick="document.getElementById('deleteClientForm').style.display='block'">Eliminar cliente</a>
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
            <form method="POST" action="">
                <input type="text" name="run" placeholder="Ingrese el RUN del cliente" required>
                <input type="submit" name="buscar_cliente" value="Buscar Cliente">
            </form>
            <?php if ($cliente_no_existe): ?>
                <p class="error">No se encontró ningún cliente con ese RUN.</p>
            <?php elseif ($cliente): ?>
                <form method="POST" action="">
                    <input type="text" name="run" value="<?php echo $cliente['run']; ?>" readonly>
                    <input type="text" name="nombre" value="<?php echo $cliente['nombre']; ?>" required>
                    <input type="text" name="apellido" value="<?php echo $cliente['apellido']; ?>" required>
                    <input type="text" name="celular" value="<?php echo $cliente['celular']; ?>" required>
                    <input type="email" name="correo" value="<?php echo $cliente['correo']; ?>" required>
                    <label for="fiado">¿Fiado?</label>
                    <select name="fiado" required>
                        <option value="1" <?php echo $cliente['fiado'] == 1 ? 'selected' : ''; ?>>Sí</option>
                        <option value="0" <?php echo $cliente['fiado'] == 0 ? 'selected' : ''; ?>>No</option>
                    </select>
                    <input type="submit" name="edit_cliente" value="Editar Cliente">
                </form>
            <?php endif; ?>
        </div>

        <!-- Formulario para eliminar un cliente -->
        <div id="deleteClientForm" style="display:none; margin-top: 20px; text-align: left;">
            <h2>Eliminar Cliente</h2>
            <form method="POST" action="">
                <input type="text" name="run" placeholder="Ingrese el RUN del cliente" required>
                <input type="submit" name="delete_cliente" value="Eliminar Cliente">
            </form>
        </div>

        <!-- Ver todos los clientes registrados -->
        <div id="viewClientForm" style="display:none; margin-top: 20px;">
            <h2>Lista de Clientes</h2>
            <?php if ($clientes->num_rows > 0): ?>
                <table border="1" cellpadding="10">
                    <tr>
                        <th>RUN</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Celular</th>
                        <th>Correo</th>
                        <th>Fiado</th>
                    </tr>
                    <?php while($row = $clientes->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['run']; ?></td>
                            <td><?php echo $row['nombre']; ?></td>
                            <td><?php echo $row['apellido']; ?></td>
                            <td><?php echo $row['celular']; ?></td>
                            <td><?php echo $row['correo']; ?></td>
                            <td><?php echo $row['fiado'] == 1 ? 'Sí' : 'No'; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            <?php else: ?>
                <p>No hay clientes registrados.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
