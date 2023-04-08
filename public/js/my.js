$(document).ready(function () {

    // search input filed
    // $('#search').keyup(function (){
    //
    //     const searchText = $(this).val().toLowerCase();
    //
    //     $('table tbody tr').each(function () {
    //         const currentRow = $(this);
    //         const currentRowText = currentRow.text().toLowerCase();
    //         if(currentRowText.indexOf(searchText) !== -1) {
    //             currentRow.show();
    //         }else {
    //             currentRow.hide();
    //         }
    //     });
    //
    // });// end of search field

    // another implementation for search input field
    $(document).ready(function () {
        $('#search').on('keyup', function () {
            const searchText = $(this).val().toLowerCase();
            $('table tbody tr').filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(searchText) > -1);
            });
        });
    });


    // delete user button
    $('.delete').click(function (e) {
        e.preventDefault();
        const form = $(this).closest('form');

        const noty = new Noty({
            // translations object is the jason encoded from the site lang file of localization in php
            // is found in script tag of dashboard/app.blade.php
            text: translations.confirm_delete,
            type: "warning",
            killer: true,
            buttons: [
                Noty.button(translations.yes, 'btn btn-success mr-2', function () {
                    form.submit();
                }),

                Noty.button(translations.no, 'btn btn-primary mr-2', function () {
                    noty.close();
                })
            ]
        });

        noty.show();

    });//end of delete



    $(".image").change(function () {
        //
        if (this.files && this.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.image-preview').attr('src', e.target.result);
            }

            reader.readAsDataURL(this.files[0]);
        }
    });

});// end of ready
