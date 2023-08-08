<?php
include_once "../includes/header.php";
?>

<!-- Incluir la biblioteca jQuery y jQuery UI Autocomplete -->

<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/smoothness/jquery-ui.css">
<script src="../js/jquery-ui.js"></script>

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <style>
                .control {

                    /* width: 100%; */
                    height: calc(1.5em + 0.75rem + 2px);
                    padding: 0.375rem 0.75rem;
                    font-size: 1rem;
                    font-weight: 400;
                    line-height: 1.5;
                    color: #6e707e;
                    background-color: #fff;
                    background-clip: padding-box;
                    border: 1px solid #d1d3e2;
                    border-radius: 0.35rem;
                    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
                }
            </style>

            <br>

            <h4 class="text-center">Salida De Recursos</h4>
            <div class="row">
                <div class="col-lg-6">

                    <p style="font-size: 16px; text-transform: uppercase; "><i class="fas fa-user"></i> <?php echo $_SESSION['usuario']; ?></p>

                    <label for="cat" class="form-label"></label>
                    <select name="id_area" id="id_area" class="control" required>
                        <option value="0">Seleccionar Area</option>

                        <?php

                        include("../includes/db.php");
                        //Codigo para mostrar categorias desde otra tabla
                        $sql = "SELECT * FROM areas ";
                        $resultado = mysqli_query($conexion, $sql);
                        while ($consulta = mysqli_fetch_array($resultado)) {
                            echo '<option value="' . $consulta['id'] . '">' . $consulta['descripcion'] . '</option>';
                        }

                        ?>
                    </select>
                </div>

            </div>

            <br>
            <!-- BUSCADOR VENTA -->

            <label for="codigo">Buscador</label>
            <input width="100%" autofocus class="form-control" id="searchInput" required type="text" placeholder="Escribe el nombre o codigo del recurso..">

            <br>
            <div class="table-responsive">
                <table class="table table-striped" id="searchResults" width="100%">
                    <thead>
                        <tr class="bg-dark" style="color: white;">
                            <th>Código</th>
                            <th>Recurso</th>
                            <th>Existencia</th>
                            <th>Precio de compra</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                            <th>Quitar</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>




            <br>
            <h3>TOTAL : $<span id="granTotal">0</span></h3>
            <br>
            <form action="../includes/guardarSalida.php" method="POST">


                <button type="button"  id="save" class="btn btn-success">
                    <span class="glyphicon glyphicon-plus"></span> GUARDAR SALIDA
                </button>
            </form>

        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->



<script src="../js/salida.js"></script>
<?php include "../includes/footer.php"; ?>