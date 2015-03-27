$(document).ready(function ()
{
    $('.btnSearch').click(function ()
    {
        makeAjaxRequest();
    });
    $('.searchForm').submit(function (e)
    {
        e.preventDefault();
        makeAjaxRequest();
        return false;
    });
    $(".reset").click(function (e)
    {
        $('.result').empty();
        $('.searchForm').closest('.searchForm').find("input[type=text]").val("");
    });

    function makeAjaxRequest()
    {
        $.ajax(
        {
            url: '/admin/index/',
            type: 'post',
            data: {
                name: $('input.email').val(),
                action: 'search'
            },
            success: function (response)
            {
                $('div.result').html(response);
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