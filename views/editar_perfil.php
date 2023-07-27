<?php
header('Content-Type: application/json');

if (isset($_POST['accion'])) {
    switch ($_POST['accion']) {


        case 'editar_perfil':
            editar_perfil();
            break;
    }
}
function editar_perfil()
{
    include "../includes/db.php";
    extract($_POST);

    // Verificar si se ha seleccionado una nueva imagen
    if (!empty($_FILES['imagen']['name'])) {
        $imagen_tmp = $_FILES['imagen']['tmp_name'];
        $imagen_ruta = 'images/' . $_FILES['imagen']['name'];
        move_uploaded_file($imagen_tmp, $imagen_ruta);

        // Actualizar la ruta de la imagen en la base de datos
        $consulta = "UPDATE users SET usuario = '$usuario', sexo = '$sexo', correo = '$correo', imagen = '$imagen_ruta' WHERE id = '$id' ";
    } else {
        // No se ha seleccionado una nueva imagen, actualizar solo los datos sin cambiar la imagen
        $consulta = "UPDATE users SET usuario = '$usuario', sexo = '$sexo', correo = '$correo' WHERE id = '$id' ";
    }

    $resultado = mysqli_query($conexion, $consulta);
    if ($resultado === true) {
        echo json_encode("updated");
    } else {
        echo json_encode("error");
    }
}
