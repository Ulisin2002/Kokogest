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
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $direccion = $_POST['direccion'];
    $descripcion = $_POST['descripcion'];

    // Generar un ID único para el proveedor
    $id = uniqid(); // Usamos un ID único basado en la función uniqid()

    // Preparar la consulta SQL para insertar los datos
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
        /* Estilos para el modal */
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
            margin: 15% auto;
            border-radius: 10px;
            width: 50%;
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
                    <input type="text" id="nombre" name="nombre" required>

                    <label for="telefono">Teléfono:</label>
                    <input type="number" id="telefono" name="telefono" required>

                    <label for="correo">Correo electrónico:</label>
                    <input type="email" id="correo" name="correo" required>

                    <label for="direccion">Dirección:</label>
                    <input type="text" id="direccion" name="direccion" required>

                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" name="descripcion"></textarea>

                    <input type="submit" name="add_proveedor" value="Agregar Proveedor">
                </form>
            </div>
        </div>

        <!-- Agregar los demás modales según sea necesario -->
        <!-- Modal de editar, eliminar y ver detalles -->

        <p><a href="index.php" style="color: white; text-decoration: none;">Volver a la página principal</a></p>
    </div>

    <script>
        // Funciones para mostrar y ocultar el modal
        function openModal(modalType) {
            document.getElementById(modalType + "Modal").style.display = "block";
        }

        function closeModal(modalType) {
            document.getElementById(modalType + "Modal").style.display = "none";
        }

        // Cerrar el modal si se hace clic fuera de él
        window.onclick = function(event) {
            if (event.target.className === "modal") {
                closeModal('add');
            }
        }
    </script>

</body>
</html>
