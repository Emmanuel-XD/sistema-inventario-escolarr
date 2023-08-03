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
                cartItems.push({
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
                        <td><input class="cantidad" type="number" value="1"></td>
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


    //Actualizar Cant del carrito
    $(document).on('change', '.cantidad', function () {
        var cantidad = parseFloat($(this).val());
        var existencia = parseFloat($(this).closest('tr').find('td:eq(2)').text());
        var compra = parseFloat($(this).closest('tr').find('td:eq(3)').text());
        var total = 0;

        var codigo = $(this).closest('tr').find('td:first').text().trim();

        var cartItem = cartItems.find(function (item) {
            return item.codigo === codigo;
        });


        if (cartItem && cantidad > existencia) {
            alert('¡La cantidad ingresada, supera a la existencia del registro!');
            $(this).val(cartItem.cantidad);
            total = existencia * compra;
            cartItem.cantidad = existencia;
        } else {
            total = cantidad * compra;
            cartItem.cantidad = cantidad;
        }

        $(this).closest('tr').find('.total').text(total.toFixed(2));

        updateTotal();
    });

    // Eliminar el producto del carrito
    $(document).on('click', '.btn-quitar', function () {
        var codigo = $(this).data('codigo');


        cartItems = cartItems.filter(function (item) {
            return item.codigo !== codigo;
        });

        updateTotal();
        $(this).closest('tr').remove();
    });

    function updateTotal() {
        var granTotal = 0;

        cartItems.forEach(function (item) {
            var totalProducto = item.precio * item.cantidad;
            granTotal += totalProducto;
            $('table tbody').find(`td:contains('${item.codigo}')`).siblings('.total').text(totalProducto);
        });

        $('#granTotal').text(granTotal);
    }

    //Auto completadors

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
});