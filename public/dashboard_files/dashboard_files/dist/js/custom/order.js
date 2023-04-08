var i=0;

$(document).ready(function () {

    $('.add-book-btn').on('click', function (e) {
        e.preventDefault();

        var book_name = $(this).data('name');
        var id = $(this).data('id');
        var cat_name = $(this).data('category_name');
        var num_pages = $(this).data('num_pages');

        $(this).removeClass('btn-success').addClass('btn-default disabled');


    // <td> <input type='number' name='quantities[]' class='form-control input-sm' min='1' value='1'/> </td>


        var html = `
            <tr>
                <td>${book_name}</td>
                <input type='hidden' name='books[]' value='${id}' />
                <td>${cat_name}</td>
                <td>${num_pages}</td>
                <td> <button class='btn btn-danger btn-sm remove-book-btn'  data-id='${id}'> <span class='fa fa-trash'> </span> </button> </td>
            </tr>
        `;

        $('.order-list').append(html);

        $('body').on('click', '.disabled', function (e) {
            e.preventDefault();
        });// end of disabled


        $('body').on('click', '.remove-book-btn', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            $(this).closest('tr').remove();
            $('#book-' + id).removeClass('btn-default disabled').addClass('btn-success');
        });// end of remove book btn

    });




    // show books of brower
    $('.order-books').on('click', function (e) {
        e.preventDefault();

        $('#loading').css('display', 'flex');

        var url = $(this).data('url');
        var method = $(this).data('method');
        var brower = $(this).data('brower');

        $.ajax({
            type: method,
            url: url,
            success: function (response) {
                $('#order-book-list').empty();
                $('#loading').css('display', 'none');
                $('#order-book-list').append(response);
            }
        });

    });


});// end of ready








