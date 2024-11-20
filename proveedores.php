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

// Procesar el formulario para agregar un nuevo proveedor
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_proveedor'])) {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $direccion = $_POST['direccion'];
    $descripcion = $_POST['descripcion'];

    $id = uniqid(); // Generar ID único

    // Insertar en la base de datos
    $sql = "INSERT INTO proovedor (id, nombre, telefono, correo, direccion, descripcion) 
            VALUES ('$id', '$nombre', '$telefono', '$correo', '$direccion', '$descripcion')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green;'>Proveedor agregado exitosamente.</p>";
    } else {
        echo "<p style='color:red;'>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}

// Obtener todos los proveedores para mostrarlos
$sql_proveedores = "SELECT * FROM proovedor";
$proveedores = $conn->query($sql_proveedores);

// Procesar el formulario para editar los datos de un proveedor
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_proveedor'])) {
    $nombre = $_POST['edit_nombre']; // Nombre del proveedor que se quiere editar
    $telefono = $_POST['edit_telefono'];
    $correo = $_POST['edit_correo'];
    $direccion = $_POST['edit_direccion'];
    $descripcion = $_POST['edit_descripcion'];

    // Actualizar los datos del proveedor solo si existe
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

    // Eliminar el proveedor
    $sql = "DELETE FROM proovedor WHERE nombre='$nombre'";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green;'>Proveedor eliminado exitosamente.</p>";
    } else {
        echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
    }
}

// Obtener los datos del proveedor seleccionado para editar
$proveedor = null;
$proveedor_no_existe = false;
if (isset($_POST['buscar_proveedor'])) {
    $nombre = $_POST['nombre'];
    $sql = "SELECT * FROM proovedor WHERE nombre='$nombre'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // Si el proveedor existe, mostramos sus datos para editar
        $proveedor = $result->fetch_assoc();
    } else {
        // Si no existe, mostramos un mensaje de error
        $proveedor_no_existe = true;
    }
}

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
            background-color: #800080; /* Color morado */
            background-image: url('infoProveedor.jpg'); /* Ruta de la imagen */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
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
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 10px;
            color: white;
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
        /* Estilos para los modales */
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
            margin: 5% auto;
            border-radius: 10px;
            width: 50%;
            max-width: 600px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        input[type="text"], input[type="number"], input[type="email"], textarea, input[type="submit"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            font-size: 16px;
        }
        textarea {
            resize: vertical;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        /* Estilo para los placeholders */
        input::placeholder, textarea::placeholder {
            color: #888;
        }

        /* Cambiar color de los títulos dentro de los formularios */
        .modal-content h2 {
            color: #333; /* Color oscuro para los títulos */
        }

        /* Ajuste del tamaño de los modales */
        #addModal, #editModal, #deleteModal, #detailsModal {
            width: 50%; /* Reducido un poco */
        }

        /* Ajustar la visibilidad en el modal de detalles */
        #detailsModal .modal-content p {
            color: black;
            font-size: 16px;
        }
    </style>
</head>
<body>

    <h1>Registro de Proveedores</h1>
    <div class="content">
        <p>Esta es la página donde se gestionan los proveedores. Aquí podrás añadir, editar o eliminar proveedores según sea necesario.</p>

        <div class="buttons">
            <a href="#" onclick="openModal('add')">Agregar nuevo proveedor</a>
            <a href="#" onclick="openModal('edit')">Editar proveedor</a>
            <a href="#" onclick="openModal('delete')">Eliminar proveedor</a>
            <a href="#" onclick="openModal('details')">Ver detalles del proveedor</a>
        </div>

        <!-- Modal para agregar proveedor -->
        <div id="addModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('add')">&times;</span>
                <h2>Agregar Nuevo Proveedor</h2>
                <form method="POST" action="">
                    <input type="text" id="nombre" name="nombre" placeholder="Ingrese el nombre del proveedor" required>
                    <input type="number" id="telefono" name="telefono" placeholder="Ingrese el teléfono" required>
                    <input type="email" id="correo" name="correo" placeholder="Ingrese el correo electrónico" required>
                    <input type="text" id="direccion" name="direccion" placeholder="Ingrese la dirección" required>
                    <textarea name="descripcion" placeholder="Descripción del proveedor"></textarea>
                    <input type="submit" name="add_proveedor" value="Agregar Proveedor">
                </form>
            </div>
        </div>

        <!-- Modal para editar proveedor -->
        <div id="editModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('edit')">&times;</span>
                <h2>Editar Proveedor</h2>
                <form method="POST" action="">
                    <input type="text" name="edit_nombre" placeholder="Ingrese el nombre del proveedor a editar" required>
                    <input type="number" name="edit_telefono" placeholder="Ingrese el teléfono" value="<?php echo $proveedor ? $proveedor['telefono'] : ''; ?>" required>
                    <input type="email" name="edit_correo" placeholder="Ingrese el correo electrónico" value="<?php echo $proveedor ? $proveedor['correo'] : ''; ?>" required>
                    <input type="text" name="edit_direccion" placeholder="Ingrese la dirección" value="<?php echo $proveedor ? $proveedor['direccion'] : ''; ?>" required>
                    <textarea name="edit_descripcion" placeholder="Descripción del proveedor"><?php echo $proveedor ? $proveedor['descripcion'] : ''; ?></textarea>
                    <input type="submit" name="edit_proveedor" value="Actualizar Proveedor">
                </form>
                <?php if ($proveedor_no_existe) echo "<p style='color:red;'>Proveedor no encontrado.</p>"; ?>
            </div>
        </div>

        <!-- Modal para eliminar proveedor -->
        <div id="deleteModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('delete')">&times;</span>
                <h2>Eliminar Proveedor</h2>
                <form method="POST" action="">
                    <input type="text" name="delete_nombre" placeholder="Ingrese el nombre del proveedor a eliminar" required>
                    <input type="submit" name="delete_proveedor" value="Eliminar Proveedor">
                </form>
            </div>
        </div>

        <!-- Modal para ver detalles -->
        <div id="detailsModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('details')">&times;</span>
                <h2>Detalles de Proveedores</h2>
                <?php if ($proveedores->num_rows > 0): ?>
                    <table border="1" style="width: 100%; text-align: left;">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Dirección</th>
                            <th>Descripción</th>
                        </tr>
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
                    </table>
                <?php else: ?>
                    <p style="color:red;">No hay proveedores registrados.</p>
                <?php endif; ?>
            </div>
        </div>

    </div>

    <script>
        function openModal(modalName) {
            var modal = document.getElementById(modalName + 'Modal');
            modal.style.display = "block";
        }
        function closeModal(modalName) {
            var modal = document.getElementById(modalName + 'Modal');
            modal.style.display = "none";
        }
    </script>

</body>
</html>
