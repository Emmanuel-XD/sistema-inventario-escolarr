$(document).ready(function () {
    var originalRows = $('table tbody').html();
    var cartItems = [];
    function updateTable(data) {
        $.each(data, function (index, item) {
            var $row = $('table tbody').find(`td:contains('${item.codigo}')`).closest('tr');
            if ($row.length > 0) {
                var cantidad = parseInt($row.find('.cantidad').val());
                cantidad++;
                if (cantidad <= item.existencia) {
                    $row.find('.cantidad').val(cantidad);
                    var totalProducto = item.precio * cantidad;
                    $row.find('.total').text(totalProducto.toFixed(2));

                    // Actualizar la cantidad en cartItems
                    var existingItem = cartItems.find(function (cartItem) {
                        return cartItem.codigo === item.codigo;
                    });
                    if (existingItem) {
                        existingItem.cantidad = cantidad;
                    }
                } else {
                    alert('La cantidad ingresada supera la existencia en el inventario.');
                }
            } else {
                console.log(item)
                cartItems.push({
                    idprd: item.idPrd,
                    codigo: item.codigo,
                    producto: item.producto,
                    precio: item.compra,
                    cantidad: 1,
                });

                $('table tbody').append(`
                    <tr>
                        <td>${item.codigo}</td>
                        <td>${item.producto}</td>
                        <td>${item.existencia}</td>
                        <td>${item.compra}</td>
                        <td><input class="cantidad" type="number" value="1" min="1"></td>
                        <td class="total">${item.compra}</td>
                        <td><button class="btn btn-danger btn-sm btn-quitar" data-codigo="${item.codigo}"> <i class="fa fa-trash "></i></button></td>
                    </tr>
                `);
            }
        });

        updateTotal();
    }
    function updateTotal() {
        var granTotal = 0;

        cartItems.forEach(function (item) {
            var totalProducto = item.precio * item.cantidad;
            granTotal += totalProducto;
            $('table tbody').find(`td:contains('${item.codigo}')`).siblings('.total').text(totalProducto.toFixed(2));
            $('table tbody').find(`td:contains('${item.codigo}')`).siblings('.cantidad').val(item.cantidad); // Actualizar la cantidad en la tabla
        });

        $('#granTotal').text(granTotal.toFixed(2));
    }
    $("#id_area").click(function (e) { 
        e.preventDefault();
        $("#id_area").css('border-color', '');
        $("#granTotal").css('color', '');
    });
    $(document).on('change', '.cantidad', function ( ) {
        var cantidad = parseFloat($(this).val());
        var compra = parseFloat($(this).closest('tr').find('td:eq(3)').text());
        var total = 0;
        var codigo = $(this).closest('tr').find('td:first').text().trim();
        var cartItem = cartItems.find(function (item) {
            return item.codigo === codigo;
        });
        if(this.value == '' || this.value == null){
            this.value = 1;
            var cantidad = 1;
            total = cantidad * compra;
            cartItem.cantidad = cantidad;
            $(this).closest('tr').find('.total').text(total.toFixed(2));
            updateTotal();
        }
    })
    $(document).on('input', '.cantidad', function () {
        this.value =  !!this.value && Math.abs(this.value) >= 1 ? Math.abs(this.value) : null
        var cantidad = parseFloat($(this).val());
        var existencia = parseFloat($(this).closest('tr').find('td:eq(2)').text());
        var compra = parseFloat($(this).closest('tr').find('td:eq(3)').text());
        var total = 0;
        var codigo = $(this).closest('tr').find('td:first').text().trim();
        var cartItem = cartItems.find(function (item) {
            return item.codigo === codigo;
        });
        if(Number.isNaN(cantidad))
        {
            cantidad = 1;
        }
        if (cartItem && cantidad > existencia) {
            alert('¡La cantidad ingresada, supera a la existencia del registro!');
            $(this).val(cartItem.cantidad);
            total = existencia * compra;
            cartItem.cantidad = existencia;
            this.value = cartItem.cantidad
        } else {
            total = cantidad * compra;
            cartItem.cantidad = cantidad;
        }
        console.log(total.toFixed(2))
        $(this).closest('tr').find('.total').text(total.toFixed(2));
        updateTotal();
    });
 $(document).on('click', '.btn-quitar', function () {
        var codigo = String($(this).data('codigo'));


        cartItems = cartItems.filter(function (item) {
            return item.codigo !== codigo;
        });
        updateTotal();
        $(this).closest('tr').remove();
    });
    $('#searchInput').autocomplete({
        source: function (request, response) {
            $.ajax({
                type: 'GET',
                url: 'search.php',
                data: {
                    term: request.term
                },
                dataType: 'json',
                success: function (data) {
                    response($.map(data, function (item) {
                        return {
                            label: item.codigo + ' - ' + item.producto,
                            value: item.producto
                        };
                    }));
                }
            });
        },
        minLength: 2,
        select: function (event, ui) {
            $('#searchInput').val(ui.item.value);
            $.ajax({
                type: 'GET',
                url: 'search.php',
                data: {
                    term: ui.item.value
                },
                dataType: 'json',
                success: function (data) {
                    updateTable(data);
                    $('#searchInput').val('');
                }
            });
            return false;
        },
        close: function (event, ui) {
            var searchTerm = $('#searchInput').val().trim();
            if (searchTerm === '') {
                $('table tbody').html(originalRows);
            }
        }
    });
    // function updateTotal() {
    //     var granTotal = 0;
    //     cartItems.forEach(function (item) {
    //         var totalProducto = item.precio * item.cantidad;
    //         granTotal += totalProducto;
    //         $('table tbody').find(`td:contains('${item.codigo}')`).siblings('.total').text(totalProducto);
    //     });
    //     $('#granTotal').text(granTotal);
    // }
    $("#save").click(function (e) { 
        e.preventDefault();
        if(cartItems.length === 0 || $("#id_area").val() == '' || $("#id_area").val() == 0){
            Swal.fire({
                icon: 'warning',
                title: 'Rellene los datos correctamente',
                text: 'verifique que tenga agregado todo correctamente',
              })
              $("#id_area").css('border-color', 'red')
              $("#granTotal").css('color','red')
            return;
        }

        cartItems.filter(function (item) { 
            datos
         })
        var datos = new FormData();
        var items =  JSON.stringify(cartItems)

        datos.append('accion', 'saveItms')
        datos.append('total', parseFloat($("#granTotal").text()));
        datos.append('area', $("#id_area").val())
        datos.append('productos', items)

        fetch('../includes/functions.php',{
            method: "POST",
            body: datos
        }).then(response => response.json())
        .then(function (response) {
            if(response.status == 'success'){
                let params = `scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=800,height=600,left=-1000,top=-1000`;
                open(`../includes/docPDF.php?id=${response.last_inserted_id}`, 'pdf', params);
                Swal.fire({
                    icon: 'success',
                    title: 'Datos agregados',
                    text: 'Se agregaron los datos de forma correcta',
                  })
                  $('#searchInput').val("");
                  $('table tbody').html(originalRows);
                  cartItems = [];
                  updateTotal();
             }
             if(response.status == 'error'){
                Swal.fire({
                    icon: 'error',
                    title: 'No se pudo acceder a la base de datos',
                    text: 'contacte al administrador',
                  })
             }
        })
    });
});