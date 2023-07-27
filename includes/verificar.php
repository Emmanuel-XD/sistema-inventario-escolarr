<?php
include_once("db.php");

$notifications = array();

$SQL = mysqli_query($conexion, "SELECT * FROM recursos WHERE existencia <= minimo ORDER BY existencia ASC LIMIT 5 ");
if (mysqli_num_rows($SQL) > 0) {
    while ($result = mysqli_fetch_assoc($SQL)) {
        // Aquí puedes personalizar el mensaje de notificación según tus necesidades
        $notification = array(
            'fecha' => $result['fecha'], // Reemplaza 'fecha' con el campo que contiene la fecha de la notificación en tu tabla
            'descripcion' => 'El producto ' . $result['producto'] . ' tiene una cantidad mínima de ' . $result['minimo'] . ' unidades.', // Personaliza el mensaje según la estructura de tu tabla
        );

        array_push($notifications, $notification);
    }
}

// Devuelve la lista de notificaciones en formato JSON
echo json_encode($notifications);
