<?php
include "db.php";

$consult = mysqli_query($conexion, "SELECT COUNT(*) AS count FROM recursos WHERE existencia <= minimo");
$row = mysqli_fetch_assoc($consult);
$count = $row['count'];

echo $count;
