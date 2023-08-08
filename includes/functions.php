<?php
if (isset($_POST['accion'])) {
    switch ($_POST['accion']) {
            //casos de registros
        case 'insertar_categoria':
            insertar_categoria();
            break;

        case 'insertar_area':
            insertar_area();
            break;

        case 'insertar_inventario':
            insertar_inventario();
            break;
        case 'saveItms':
            saveItms();
            break;

        case 'editar_inv':
            editar_inv();
            break;

        case 'editar_cat':
            editar_cat();
            break;

        case 'editar_area':
            editar_area();
            break;


        case 'editar_user':
            editar_user();
            break;

        case 'editar_perfil':
            editar_perfil();
            break;
    }
}
function saveItms(){
    try{
    global $conexion;
    include "db.php";
    session_start();
    $usuario = $_SESSION['usuario'];
    $total = $_POST['total'];
    $area = $_POST['area'];
    $currentDate = date("Y-m-d");
    $addsalida = $conexion->query("INSERT INTO `salidas`(`total`, `usuario`, `id_area`, `fecha`) VALUES ('$total', '$usuario', $area, '$currentDate')") ? null : null;
    $lastInsertedId = $conexion->insert_id;
    $productos = json_decode($_POST['productos'], true);
    foreach ($productos as $value) {
        $id = $value['idprd'];
        $cantidad = $value['cantidad'];
        $result = $conexion->query("INSERT INTO `output_product`(`id_producto`, `cantidad`, `id_salida`) VALUES ('$id','$cantidad','$lastInsertedId')") ? null : null;
    }
   $response = array("status" => "success", "last_inserted_id" => $lastInsertedId);
}
catch (Exception $e){
    $response = array("status" => "error", "message" => $e->getMessage());
}
echo json_encode($response);
}
function insertar_categoria()
{
    global $conexion;
    extract($_POST);
    include "db.php";

    $consulta = "INSERT INTO categorias (categoria) VALUES ('$categoria')";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        $response = array(
            'status' => 'success',
            'message' => 'Los datos se guardaron correctamente'
        );
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Ocurrió un error inesperado'
        );
    }

    echo json_encode($response);
}

function insertar_area()
{
    global $conexion;
    extract($_POST);
    include "db.php";

    $consulta = "INSERT INTO areas (descripcion) VALUES ('$descripcion')";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        $response = array(
            'status' => 'success',
            'message' => 'Los datos se guardaron correctamente'
        );
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Ocurrió un error inesperado'
        );
    }

    echo json_encode($response);
}




function insertar_inventario()
{
    global $conexion;
    extract($_POST);
    include "db.php";

    $consulta = "INSERT INTO recursos (codigo, producto, existencia,minimo,compra,unidad,id_categoria, id_area) 
    VALUES ('$codigo', '$producto','$existencia','$minimo','$compra','$unidad','$id_categoria', '$id_area')";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        $response = array(
            'status' => 'success',
            'message' => 'Los datos se guardaron correctamente'
        );
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Ocurrió un error inesperado'
        );
    }

    echo json_encode($response);
}




function editar_inv()
{
    require_once("db.php");

    extract($_POST);


    $consulta = "UPDATE recursos SET codigo = '$codigo', producto = '$producto', 
        compra = '$compra', existencia = '$existencia',
		minimo = '$minimo', unidad='$unidad', id_categoria = '$id_categoria',id_area = '$id_area' WHERE id = '$id' ";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        echo json_encode("correcto");
    } else {
        echo json_encode("error");
    }
}



function editar_cat()
{
    require_once("db.php");

    extract($_POST);


    $consulta = "UPDATE categorias SET categoria = '$categoria' WHERE id = '$id' ";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        echo json_encode("correcto");
    } else {
        echo json_encode("error");
    }
}

function editar_area()
{
    require_once("db.php");

    extract($_POST);


    $consulta = "UPDATE areas SET descripcion = '$descripcion' WHERE id = '$id' ";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        echo json_encode("correcto");
    } else {
        echo json_encode("error");
    }
}

function editar_user()
{
    require_once("db.php");
    extract($_POST);
    $password = trim($_POST['password']);
    $password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 5]);
    $consulta = "UPDATE users SET usuario = '$usuario', correo = '$correo', password = '$password',
		telefono='$telefono', id_rol='$id_rol' WHERE id = '$id' ";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        echo json_encode("correcto");
    } else {
        echo json_encode("error");
    }
}
