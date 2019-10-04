$('body').on('click', '.add_task', function () {
    $.ajax({
        type: 'POST',
        url: '/site/addtask/',
        dataType: 'JSON',
        data: $('.form-add-task').serialize(),
        success: function (response) {
            if(response.success == 1){
                $('.success').show();
                $('.error').html('');
                $('.form_model').val('');
            }else{
                $('.success').hide();
                $('.error').html('');
                for (val in response)
                    $('.error-'+val).html(response[val]);
            }

        },
        error: function () {

        }
    });
});

$('body').on('click', '.edit_task', function () {
    $.ajax({
        type: 'POST',
        url: '/site/updatetask/',
        dataType: 'JSON',
        data: $('.form-add-task').serialize(),
        success: function (response) {
            if(response.success == 1 || response.success == 2 || response.success == 3){
                if(response.success == 3)
                    window.location.href = '/user/login';
                $('.success').show();
                $('.error').html('');
                if(response.success == 1)
                    $('.form_model').val('');
            }else{
                $('.success').hide();
                $('.error').html('');
                for (val in response)
                    $('.error-'+val).html(response[val]);
            }

        },
        error: function () {

        }
    });
});

$('body').on('click', '.login', function (e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: '/user/login/',
        dataType: 'JSON',
        data: $('.form-login').serialize(),
        success: function (response) {
            if(response.success == 1){
                window.location.href = "/";
            }else{
                $('.error').html('');
                for (val in response)
                    $('.error-'+val).html(response[val]);
            }

        },
        error: function () {

        }
    });
});

$('body').on('click', '.sort', function () {
    var sort = $(this).attr('data-sort');
    $.ajax({
        type: 'POST',
        url: '/site/sort/',
        data: {sort: sort},
        success: function (response) {
             $('.main-sort').html(response);
        },
        error: function () {

        }
    });
});