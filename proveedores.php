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
        }
        .modal-content {
            background-color: #fff;
            padding: 20px;
            margin: 10% auto;
            border-radius: 10px;
            width: 50%;
            max-width: 600px;
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
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9; /* Fondo gris claro para los campos */
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
            color: #888; /* Gris claro para el texto indicativo */
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
                    <label for="nombre">Nombre del proveedor:</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Ingrese el nombre del proveedor" required>

                    <label for="telefono">Teléfono:</label>
                    <input type="number" id="telefono" name="telefono" placeholder="Ingrese el teléfono" required>

                    <label for="correo">Correo electrónico:</label>
                    <input type="email" id="correo" name="correo" placeholder="Ingrese el correo electrónico" required>

                    <label for="direccion">Dirección:</label>
                    <input type="text" id="direccion" name="direccion" placeholder="Ingrese la dirección" required>

                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" placeholder="Descripción del proveedor"></textarea>

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
                    <input type="text" name="edit_nombre" placeholder="Nuevo nombre del proveedor" required>
                    <input type="number" name="edit_telefono" placeholder="Nuevo teléfono" required>
                    <input type="email" name="edit_correo" placeholder="Nuevo correo" required>
                    <input type="text" name="edit_direccion" placeholder="Nueva dirección" required>
                    <textarea name="edit_descripcion" placeholder="Nueva descripción"></textarea>
                    <input type="submit" name="edit_proveedor" value="Guardar cambios">
                </form>
            </div>
        </div>

        <!-- Modal para eliminar proveedor -->
        <div id="deleteModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('delete')">&times;</span>
                <h2>Eliminar Proveedor</h2>
                <form method="POST" action="">
                    <input type="text" name="delete_id" placeholder="ID del proveedor a eliminar" required>
                    <input type="submit" name="delete_proveedor" value="Eliminar Proveedor">
                </form>
            </div>
        </div>

        <!-- Modal para ver detalles del proveedor -->
        <div id="detailsModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('details')">&times;</span>
                <h2>Detalles del Proveedor</h2>
                <p>Aquí se mostrarán los detalles del proveedor seleccionado.</p>
            </div>
        </div>

        <p><a href="index.php" style="color: white; text-decoration: none;">Volver a la página principal</a></p>
    </div>

    <script>
        function openModal(modalName) {
            document.getElementById(modalName + 'Modal').style.display = "block";
        }

        function closeModal(modalName) {
            document.getElementById(modalName + 'Modal').style.display = "none";
        }

        // Cerrar el modal si se hace clic fuera de él
        window.onclick = function(event) {
            if (event.target.className === "modal") {
                closeModal('add');
                closeModal('edit');
                closeModal('delete');
                closeModal('details');
            }
        }
    </script>

</body>
</html>
