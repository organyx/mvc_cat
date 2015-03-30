$(document).ready(function ()
{
    $('.btnSearch').click(function ()
    {
        makeAjaxRequest();
    });
    // $('.searchForm').submit(function (e)
    // {
    //     e.preventDefault();
    //     makeAjaxRequest();
    //     return false;
    // });
    $(".reset").click(function (e)
    {
        $('.result').empty();
        $('.searchForm').closest('.searchForm').find("input[type=text]").val("");
    });

    function makeAjaxRequest()
    {
        data = {
                action: 'search',
                name: $('input.email').val()
            }
        //data = $(this).serialize() + "&" + $.param(data);
        $.ajax(
        {
            url: '/admin/index/',
            type: 'post',
            //dataType: 'json',
            data: data,
            success: function (response)
            {
                $('div.result').html(response);

                // $('table#result_table').removeClass("off");
                // $('span#found_title').append(response['title']);

                    $('.DeleteUserButton').click(function ()
                    {
                        deleteUser();
                    });
                    $('.DeleteUserForm').submit(function (e)
                    {
                        e.preventDefault();
                        deleteUser();
                        return false;
                    });
                    $('.ApproveUserButton').click(function ()
                    {
                        approveUser();
                    });
                    $('.ApproveUserForm').submit(function (e)
                    {
                        e.preventDefault();
                        approveUser();
                        return false;
                    });
            }
        });
    }




    function deleteUser()
    {
        //var del = $('.DeleteUserForm').serialize();
        var formID = $('.DeleteUserHiddenField').val();
        $.ajax(
        {
            url: '/admin/index/',
            type: 'post',
            data: {
                action: 'delete', 
                id: formID,
            },
            success: function (response)
            {
                $('div.returnmessage').html(response);
            },
            error: function (response)
            {
                $('div.returnmessage').html(response);
            }
        });
        //return false;
    }

    function approveUser()
    {   
        //var app = $('.ApproveUserForm').serialize();
        var formID = $('.ApproveIDhiddenField').val();
        $.ajax(
        {
            url: '/admin/index/',
            type: 'post',
            data: {
                action: 'approve',
                id: formID,
            },
            success: function (response)
            {
                $('div.returnmessage').html(response);
            },
            error: function (response)
            {
                $('div.returnmessage').html(response);
            }
        });
       // return false;
    }  
});
// JavaScript Document