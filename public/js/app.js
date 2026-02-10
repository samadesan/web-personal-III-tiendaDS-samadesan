(function(){
    const infoProduct = $("#infoProduct");

    $("a.open-info-product").on('click', function(event) {
        event.preventDefault();
        const id = $(this).attr('data-id');
        const href = `/api/show/${id}`;

        $.get(href, function(data) {
            $(infoProduct).find("#productName").text(data.name);
            $(infoProduct).find("#productPrice").text(data.price);
            // IMPORTANTE: Ajustamos la ruta a /img/products/
            $(infoProduct).find("#productImage").attr("src", "/img/products/" + data.photo);

            infoProduct.modal('show');
        });
    });

    $(".closeInfoProduct").on('click', function() {
        infoProduct.modal('hide');
    });
})();