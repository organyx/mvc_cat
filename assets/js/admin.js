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
        var no = $('.count').val();
        var del = $('.DeleteUserForm'+no).serialize();
        var formID = $('.DeleteUserHiddenField'+no).val();
        $.ajax(
        {
            type: 'post',
            url: '/admin/',
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
        var no = $('#count%d').val();
        alert(no);
        var app = $('.ApproveUserForm'+no).serialize();
        var formID = $('.ApproveIDhiddenField'+no).val();
        alert(formID);
        $.ajax(
        {
            type: 'post',
            url: '/admin/',
            data: {
                action: 'approve',
                id: formID,
            },
            success: function (data)
            {
                $('div.result').html(data);
            }
        });
        return false;
    }  
});
// JavaScript Document