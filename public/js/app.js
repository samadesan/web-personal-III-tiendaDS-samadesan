// Ventana de Info de Producto
(function(){
    const infoProduct = $("#infoProduct");

    $("a.open-info-product").on('click', function(event) {
        event.preventDefault();
        const id = $(this).attr('data-id');
        const href = `/api/show/${id}`;

        $.get(href, function(data) {
            $(infoProduct).find("#productName").text(data.name);
            $(infoProduct).find("#productPrice").text(data.price);
            $(infoProduct).find("#productImage").attr("src", "/img/products/" + data.photo);

            // --- LÍNEA CLAVE ---
            // Buscamos el botón de añadir al carrito DENTRO de la modal y le pasamos el ID
            $(infoProduct).find(".add-to-cart").attr('data-id', data.id);

            infoProduct.modal('show');
        });
    });

    $(".closeInfoProduct").on('click', function() {
        infoProduct.modal('hide');
    });
})();

// Carrito de Compra
$(document).ready(function() {
    // 1. ABRIR MODAL DE DETALLES (OJO: Asegúrate de que el botón tiene la clase .open-info-product)
    $(document).on('click', '.open-info-product', function() {
        const id = $(this).data('id');
        $.get('/api/show/' + id, function(data) {
            $('#productName').text(data.name);
            $('#productPrice').text(data.price);
            $('#productImage').attr('src', '/img/products/' + data.photo);
            // Actualizamos el ID en el botón de compra dentro de la modal
            $('#infoProduct .add-to-cart').data('id', data.id);

            $('#infoProduct').modal('show');
        });
    });

    // 2. AÑADIR AL CARRITO (Desde el botón de la tarjeta o desde Detalles)
    $(document).on('click', '.add-to-cart', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        const url = '/cart/add/' + id;

        $.get(url, function(data) {
            // Cerramos la modal de detalles si estuviera abierta
            $('#infoProduct').modal('hide');

            // Rellenamos la modal del carrito con los datos recibidos
            $('#cart-name').text(data.name);
            $('#cart-img').attr('src', '/img/products/' + data.photo);
            $('#cart-quantity').val(data.quantity);
            $('#base-price').val(data.price);

            // Calculamos el subtotal inicial
            const total = (data.price * data.quantity).toFixed(2);
            $('#cart-total-price').text(total);

            // MOSTRAMOS LA MODAL DEL CARRITO
            $('#cart-modal').modal('show');
        }).fail(function() {
            alert("Error al añadir al inventario");
        });
    });

    // 3. ACTUALIZAR PRECIO DINÁMICO EN LA MODAL
    $(document).on('input', '#cart-quantity', function() {
        const basePrice = parseFloat($('#base-price').val());
        const qty = parseInt($(this).val());
        if (!isNaN(basePrice) && !isNaN(qty)) {
            $('#cart-total-price').text((basePrice * qty).toFixed(2));
        }
    });
});