<?php
require_once("../includes/db.php");


$searchTerm = $_GET['term'];

$query = "SELECT * FROM recursos WHERE codigo LIKE '%$searchTerm%' OR producto LIKE '%$searchTerm%' ";

$result = mysqli_query($conexion, $query);

$data = array();
while ($fila = mysqli_fetch_assoc($result)) {
    $data[] = array(
        'idPrd' => $fila['id'],
        'codigo' => $fila['codigo'],
        'producto' => $fila['producto'],
        'existencia' => $fila['existencia'],
        'compra' => $fila['compra']
    );
}


echo json_encode($data);
