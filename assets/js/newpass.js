$(document).ready(function ()
{
    function sendPass()
    {
        var msg = $('#sendPassForm').serialize();
        $.ajax(
        {
            type: 'POST',
            url: '/forgot_pass/index/',
            data: msg,
            success: function (data)
            {
                $('#returnmessage').html(data);
            },
            error: function (xhr, str)
            {
                alert('Error: ' + xhr.responseCode);
            }
        });
    }
    $("#sendPass").click(function ()
    {
        sendPass();
    });

    $("#sendPass").submit(function (e)
    {
        e.preventDefault();
        sendPass();
        return false;
    });

    $("#reset").click(function (e)
    {
        $('#returnmessage').empty();
        $('#sendPassForm').closest('form').find("input[type=email]").val("");
    });
});
// JavaScript Document 