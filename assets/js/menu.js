$(document).ready(function() {
    const urlParams = new URLSearchParams(window.location.search);
    const categoryId = urlParams.get('category_id');
    if (!categoryId) {
        $.ajax({
            url: 'ajax/get_products.php',
            type: 'POST',
            success: function(data) {
                $('.container-products-item').html(data);
            }
        });
    } else {
        $('.nav-link').click(function(e) {
            console.log('clicked')
            $('.nav-link').not(this).removeClass('hover');
            $(this).toggleClass('hover');
            e.preventDefault();
            var subcategoryId = $(this).data('id');
            $.ajax({
                url: 'ajax/get_products.php',
                type: 'POST',
                data: {
                    subcategory_id: subcategoryId,
                    category_id: categoryId
                },
                success: function(data) {
                    if (data.length > 0) {
                        $('.container-products-item').html(data);
                        $('.container-products-item').removeClass('d-flex justify-content-center align-items-center')
                    } else {
                        $('.container-products-item').addClass('d-flex justify-content-center align-items-center')
                        $('.container-products-item').html('No products found');
                    }

                }
            });
        });
    }

    if ($('.nav-link').first().data('id') === 'All') {
        $(this).addClass('hover');
        $('.nav-link').first().trigger('click');
    }

    $(document).on('click', '.view-product', function() {
        var productId = $(this).data('id');
        $.ajax({
            url: 'product/get_product_info.php',
            type: 'POST',
            data: {
                id: productId
            },
            success: function(response) {
                $('#product-info').html(response);
                $('#productModal').modal('show');
            }
        });
    });
});