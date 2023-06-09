$(document).ready(function () {

    //add product btn
    $('.add-product-btn').on('click', function (e) {

        e.preventDefault();
        let name = $(this).data('name');
        let id = $(this).data('id');
        let price = $.number($(this).data('price'), 2);

        $(this).removeClass('btn-success').addClass('btn-default disabled');

        let html =
            `<tr>
                <td>${name}</td>
<!--                <td><input type="hidden" name="products_ids[]" value="${id}"></td>-->
                <td><input type="number" name="products[${id}][quantity]" data-price="${price}" class="form-control input-sm product-quantity" min="1" value="1" required></td>
                <td class="product-price">${price}</td>
                <td><button class="btn btn-danger btn-sm remove-product-btn" data-id="${id}"><span class="fa fa-trash"></span></button></td>
            </tr>`;

        $('.order-list').append(html);

        //to calculate total price
        calculateTotal();
    });

    // //disabled btn
    $('body').on('click', '.disabled', function (e) {

        e.preventDefault();

    });//end of disabled

    //remove product btn
    $('body').on('click', '.remove-product-btn', function (e) {

        e.preventDefault();
        let id = $(this).data('id');

        $(this).closest('tr').remove();
        $('#product-' + id).removeClass('btn-default disabled').addClass('btn-success');

        calculateTotal();

    });//end of remove product btn


    //change product quantity listen
    $('body').on('keyup change', '.product-quantity', function () {

        let quantity = Number($(this).val()); //2
        let unitPrice = parseFloat($(this).data('price').replace(/,/g, '')); //150
        $(this).closest('tr').find('.product-price').html($.number(quantity * unitPrice, 2));
        calculateTotal();

    });//end of product quantity change


    //list all order products
    $('.order-products').on('click', function (e) {

        e.preventDefault();

        $('#loading').css('display', 'flex');

        let url = $(this).data('url');
        let method = $(this).data('method');
        $.ajax({
            url: url,
            method: method,
            success: function (data) {

                $('#loading').css('display', 'none');
                $('#order-product-list').empty();
                $('#order-product-list').append(data);

            }
        })

    });//end of order products click


    // print order
    $(document).on('click', '.print-btn', function () {

        $('#print-area').printThis();

    });//end of click function

});//end of document ready

//calculate the total
function calculateTotal() {
    let price = 0;

    $('.order-list .product-price').each(function (index) {

        price += parseFloat($(this).html().replace(/,/g, ''));

    });//end of product price

    $('.total-price').html($.number(price, 2));

    if (price > 0) {
        $('#add-order-form-btn').removeClass('disabled')
    } else {
        $('#add-order-form-btn').addClass('disabled')

    }//end of else

}//end of calculate total












