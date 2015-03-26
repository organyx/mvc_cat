$(document).ready(function ()
{
    $("#update").click(function ()
    {
        update();
        //refresh();
    });


    function update()
    {
        var formData = new FormData($('#updateForm')[0]);
        $.ajax(
        {
            type: 'POST',
            url: '/update/index/',
            dataType: 'html',
            data: formData,
            async: false,
            success: function (data)
            {
                $('#returnmessage').html(data);
                $('#updateForm').closest('form').find("input[type=file]").val("");
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

    // $('#updateForm').submit(function (e)
    // {
    //     e.preventDefault();
    //     update();
    //     //refresh();
    //     return false;
    // });


    function refresh()
    {
        //$('#Content').load('/update/index/');
        setTimeout(function(){
        //Reload
        $.ajax(
        {
            type: 'POST',
            url: "/update/index/",
            context: document.body,
            success: function (s, x)
            {
                $('#Content').html(s);
            }
        });
        }, 5000 ); // 5 seconds
    }

});
// JavaScript Document 