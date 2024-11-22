<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registroproovedores_kokositas";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Procesar el formulario para agregar un nuevo proveedor
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_proveedor'])) {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $direccion = $_POST['direccion'];
    $descripcion = $_POST['descripcion'];
    $id = uniqid(); // Generar ID único

    $sql = "INSERT INTO proovedor (id, nombre, telefono, correo, direccion, descripcion) 
            VALUES ('$id', '$nombre', '$telefono', '$correo', '$direccion', '$descripcion')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green;'>Proveedor agregado exitosamente.</p>";
    } else {
        echo "<p style='color:red;'>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}

// Procesar el formulario para editar los datos de un proveedor
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_proveedor'])) {
    $nombre = $_POST['edit_nombre'];
    $telefono = $_POST['edit_telefono'];
    $correo = $_POST['edit_correo'];
    $direccion = $_POST['edit_direccion'];
    $descripcion = $_POST['edit_descripcion'];

    $sql = "UPDATE proovedor SET telefono='$telefono', correo='$correo', direccion='$direccion', descripcion='$descripcion' WHERE nombre='$nombre'";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green;'>Proveedor actualizado exitosamente.</p>";
    } else {
        echo "<p style='color:red;'>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}

// Procesar el formulario para eliminar un proveedor
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_proveedor'])) {
    $nombre = $_POST['delete_nombre'];
    $sql = "DELETE FROM proovedor WHERE nombre='$nombre'";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green;'>Proveedor eliminado exitosamente.</p>";
    } else {
        echo "<p style='color:red;'>Error: " . $sql . "</p>";
    }
}

// Obtener todos los proveedores para mostrarlos
$sql_proveedores = "SELECT * FROM proovedor";
$proveedores = $conn->query($sql_proveedores);

$conn->close();
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
            background-color: #800080;
            background-image: url('infoProveedor.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #d50b0b;
            text-align: center;
        }
        .content {
            text-align: center;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 10px;
            color: white;
        }
        .buttons a {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            margin: 5px;
            border-radius: 5px;
        }
        .buttons a:hover {
            background-color: #45a049;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            padding-top: 50px;
            overflow-y: auto;
        }
        .modal-content {
            background-color: #fff;
            padding: 20px;
            margin: auto;
            border-radius: 10px;
            width: calc(90% - 40px);
            max-width: 600px;
        }
        input, textarea {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        #detailsModal table {
            width: 100%;
            background-color: #fff;
            border-collapse: collapse;
        }
        #detailsModal th, #detailsModal td {
            padding: 10px;
            border: 1px solid #ccc;
        }
        #detailsModal th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h1>Registro de Proveedores</h1>
    <div class="content">
        <p>Gestiona los proveedores: agregar, editar o eliminar registros según sea necesario.</p>
        <div class="buttons">
            <a href="#" onclick="openModal('add')">Agregar nuevo proveedor</a>
            <a href="#" onclick="openModal('edit')">Editar proveedor</a>
            <a href="#" onclick="openModal('delete')">Eliminar proveedor</a>
            <a href="#" onclick="openModal('details')">Ver detalles del proveedor</a>
        </div>
        <!-- Modales para las diferentes operaciones -->
        <div id="addModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('add')">&times;</span>
                <h2>Agregar Nuevo Proveedor</h2>
                <form method="POST" action="">
                    <input type="text" name="nombre" placeholder="Nombre" required>
                    <input type="number" name="telefono" placeholder="Teléfono" required>
                    <input type="email" name="correo" placeholder="Correo" required>
                    <input type="text" name="direccion" placeholder="Dirección" required>
                    <textarea name="descripcion" placeholder="Descripción"></textarea>
                    <input type="submit" name="add_proveedor" value="Agregar">
                </form>
            </div>
        </div>
        <div id="editModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('edit')">&times;</span>
                <h2>Editar Proveedor</h2>
                <form method="POST" action="">
                    <input type="text" name="edit_nombre" placeholder="Nombre del proveedor a editar" required>
                    <input type="number" name="edit_telefono" placeholder="Teléfono" required>
                    <input type="email" name="edit_correo" placeholder="Correo" required>
                    <input type="text" name="edit_direccion" placeholder="Dirección" required>
                    <textarea name="edit_descripcion" placeholder="Descripción"></textarea>
                    <input type="submit" name="edit_proveedor" value="Editar">
                </form>
            </div>
        </div>
        <div id="deleteModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('delete')">&times;</span>
                <h2>Eliminar Proveedor</h2>
                <form method="POST" action="">
                    <input type="text" name="delete_nombre" placeholder="Nombre del proveedor a eliminar" required>
                    <input type="submit" name="delete_proveedor" value="Eliminar">
                </form>
            </div>
        </div>
        <div id="detailsModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('details')">&times;</span>
                <h2>Detalles de Proveedores</h2>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th>Dirección</th>
                        <th>Descripción</th>
                    </tr>
                    <?php if ($proveedores->num_rows > 0): ?>
                        <?php while ($row = $proveedores->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['nombre']; ?></td>
                                <td><?php echo $row['telefono']; ?></td>
                                <td><?php echo $row['correo']; ?></td>
                                <td><?php echo $row['direccion']; ?></td>
                                <td><?php echo $row['descripcion']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">No hay proveedores registrados.</td>
                        </tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>

    <script>
        function openModal(type) {
            document.getElementById(type + 'Modal').style.display = 'block';
        }
        function closeModal(type) {
            document.getElementById(type + 'Modal').style.display = 'none';
        }
    </script>
</body>
</html>

