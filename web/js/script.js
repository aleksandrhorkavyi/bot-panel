
$(document).on('submit', 'form#file-form', function () {
    let formData = new FormData($('form#file-form')[0]);
    $.ajax({
        url: $('form#file-form').attr('action'),
        type: 'POST',
        data: formData,
        beforeSend: function () {
            $('#preloader').removeClass('hidden');
        },
        success: function (response) {
            if (response.status == 'success') {
                $('#uploaded-data').html(response.html);
                $.pjax.reload({container: '#pjax-container', async: false});
                $('#preloader').addClass('hidden');
            }
        },
        error: function (response) {
            console.log(response);
        },

        cache: false,
        contentType: false,
        processData: false
    });

    return false;
});