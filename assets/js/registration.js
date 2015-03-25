$(document).ready(function ()
{

    function register()
    {
        //var msg   = $('#registrationForm').serialize();
        var formData = new FormData($('#registrationForm')[0]);
        $.ajax(
        {
            type: 'POST',
            url: '/register/index/',
            data: formData,
            async: false,
            success: function (data)
            {
                $('#returnmessage').html(data);
            },
            error: function (xhr, str)
            {
                alert('Error: ' + xhr.responseCode);
            },
            cache: false,
            contentType: false,
            processData: false
        });

        return false;
    }

    function reset_input()
    {
        $('#returnmessage').empty();
        $('#registrationForm').closest('form').find("input[type=text],input[type=email],input[type=password],input[type=file], textarea").val("");
    }

    $("#register").click(function (e)
    {
        register();
    });

    $("#reset").click(function (e)
    {
        reset_input();
    });

});
// JavaScript Document 
