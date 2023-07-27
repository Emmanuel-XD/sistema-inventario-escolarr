<?php
error_reporting(0);
session_start();

include "../includes/header.php";
include_once "../includes/db.php";

$consulta = "SELECT s.id,s.total, s.usuario, s.id_area, s.fecha, a.descripcion,
GROUP_CONCAT( r.codigo, '..',  r.producto, '..', op.cantidad SEPARATOR '__') AS productos
FROM salidas s LEFT JOIN output_product op ON op.id_salida = s.id LEFT JOIN recursos r ON r.id = op.id_producto 
LEFT JOIN areas a ON s.id_area = a.id GROUP BY s.id ORDER BY s.id;";

$resultado = mysqli_query($conexion, $consulta);
$salidas = array();
while ($salida = mysqli_fetch_assoc($resultado)) {
    $salidas[] = $salida;
}
?>

<body id="page-top">

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Historial De Recursos</h6>
                <br>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Productos Solicitados</th>
                                <th>Total</th>
                                <th>Imprimir</th>
                                <th>Solicitado por</th>
                                <th>Area</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($salidas as $salida) { ?>
                                <tr>
                                    <td><b><?php echo $salida['id'] ?></b></td>
                                    <td><?php echo $salida['fecha']; ?></td>

                                    <td>
                                        <table class="table table-bordered" id="table_id">
                                            <thead>
                                                <tr>
                                                    <th>Codigo</th>
                                                    <th>Descripcion</th>
                                                    <th>Cantidad</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach (explode("__", $salida['productos']) as $productosConcatenados) {
                                                    $producto = explode("..", $productosConcatenados)
                                                ?>
                                                    <tr>
                                                        <td><?php echo $producto[0] ?></td>
                                                        <td><?php echo $producto[1] ?></td>
                                                        <td><?php echo $producto[2] ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td><?php echo '$', $salida['total'] ?></td>

                                    <td><a class="btn btn-outline-secondary" target="_blank" href="<?php echo "../includes/docPDF.php?id=" . $salida['id'] ?>"><i class="fa fa-print"></i></a></td>
                                    <td><?php echo $salida['usuario'] ?></td>
                                    <td><?php echo $salida['descripcion'] ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>



                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
</body>

<?php include "../includes/footer.php"; ?>

</html>