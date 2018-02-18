$(function () {
    $('#exampleInputEmail1').on('input', function () {
        var query = $(this).val();
        $.ajax('/search/find', {
            method: 'get',
            data: {
                'query': query
            },
            success : function (response) {
                $('.list-group').html('');
                $.each(response.suggest.suggest[0].options, function (index, value) {
                    $('.list-group').append('<a href="#" class="list-group-item list-group-item-action">'+value._source.title+'</a>');
                });
            }
        });
    });
});