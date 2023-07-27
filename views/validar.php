<?php
require_once("../includes/db.php");
if (isset($_POST)) {
    extract($_POST);
    $password = trim($_POST['password']);
    $password2 = trim($_POST['password2']);

    // Obtener la información de la imagen
    $imagen_nombre = $_FILES['imagen']['name'];
    $imagen_tmp = $_FILES['imagen']['tmp_name'];

    $sql = "SELECT * FROM users WHERE usuario = '$usuario'";
    $validuser = mysqli_query($conexion, $sql);
    $rows = mysqli_num_rows($validuser);
    if ($rows >= 1) {
        echo json_encode('mail');
        die();
    }
    if (strcmp($password, $password2) !== 0) {
        echo json_encode('pass');
    } else {
        $password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 5]);

        // Mover la imagen a una carpeta y obtener la ruta
        $carpeta_destino = 'images/';
        $imagen_ruta = $carpeta_destino . $imagen_nombre;
        move_uploaded_file($imagen_tmp, $imagen_ruta);

        $consulta = "INSERT INTO users (usuario, correo, telefono, password, id_rol, sexo, imagen)
        VALUES ('$usuario', '$correo ', '$telefono', '$password', '$id_rol', '$sexo', '$imagen_ruta')";
        $resultado = mysqli_query($conexion, $consulta);
        if ($resultado) {
            echo json_encode('success');
        } else {
            echo json_encode('error');
        }
    }
} else {
    echo 'No data';
}
