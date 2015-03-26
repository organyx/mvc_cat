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
                name: $('input.email').val()
            },
            success: function (response)
            {
                $('div.result').html(response);
            }
        });
    }


    $('.DeleteUserButton').click(function ()
    {
        deleteUser();
    });
    $('.ApproveUserButton').click(function ()
    {
        approveUser();
    });

    function deleteUser()
    {
        var del = $('.DeleteUserForm').serialize();
        //alert(del);
        var formID = $('.DeleteUserHiddenField').val();
        $.ajax(
        {
            type: 'post',
            url: '/admin/index/',
            data: {
                action: 'delete', 
                id: formID,
            },
            success: function (data)
            {
                $('div.result').html(data);
            }
        });
        return false;
    }

    function approveUser()
    {
        var app = $('.ApproveUserForm').serialize();
        var formID = $('.ApproveIDhiddenField').val();
        $.ajax(
        {
            type: 'post',
            url: '/admin/index/',
            data: {
                action: 'approve',
                id: formID,
            },
            success: function (data)
            {
                $('div.result').html(data);
            }
        });
        
    }  
});
// JavaScript Document