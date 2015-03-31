$(document).ready(function ()
{
         $("#results").load( "/admin/index/"); //load initial records
      
      //executes code below when user click on pagination links
      $("#results").on( "click", ".pagination a", function (e){
        e.preventDefault();
        $(".loading-div").show(); //show loading element
        var page = $(this).attr("data-page"); //get page number from link
        $("#results").load("/admin/index/",{"page":page}, function(){ //get content from PHP page
          $(".loading-div").hide(); //once done, hide loading element
        });
        
      });


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
        reset_data();
    });

    function makeAjaxRequest()
    {
        data = {
                action: 'search',
                name: $('input.email').val()
            }
        data = $(this).serialize() + "&" + $.param(data);
        $.ajax(
        {
            
            type: 'post',
            url: '/admin/index/',
            data: data,
            success: function (response)
            {
                reset_data();
                //alert(response);
                obj = JSON.parse(response);
                //alert(obj['found']);
                $('div.result').html(obj['result']);
                //alert(obj['result']);

                if(obj['found'] == true)
                 {

                    //TABLE DATA
                    $('table#result_table').removeClass("off");
                    $('#found_title').append(obj['user']['title']);
                    $('#found_reg').append(obj['user']['registration']);
                    $('#found_url').append(obj['user']['url']);
                    $('a#found_url_href').attr("href", obj['user']['url']);
                    $('img#found_img').attr("src", "../../"+obj['user']['preview_thumb']);
                    $('a#found_img_href').attr("href", "../../"+obj['user']['preview_thumb']);
                    $('#found_lang').append(obj['user']['language']);
                    $('#found_descr').append(obj['user']['description']);
                    $('input.DeleteUserHiddenField').attr("value", obj['user']['userID']);
                    $('input.ApproveIDhiddenField').attr("value", obj['user']['userID']);


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
            },
            error: function (x, y)
            {
                alert("X: " + x.responseCode + "; Y: " + y);
            }
        });
    }


    function reset_data()
    {
        $('.result').empty();
        $('.returnmessage').empty();
        $('.searchForm').closest('.searchForm').find("input[type=text]").val("");
        //TABLE DATA
        $('table#result_table').addClass("off");
        $('span#found_title').empty();
        $('span#found_reg').empty();
        $('span#found_url').empty();
        $('a#found_url_href').attr("href", "");
        $('img#found_img').attr("src", "");
        $('a#found_img_href').attr("href", "");
        $('span#found_lang').empty();
        $('span#found_descr').empty();
        $('input.DeleteUserHiddenField').attr("value", "");
        $('input.ApproveIDhiddenField').attr("value", "");
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
                obj = JSON.parse(response);
                $('div.returnmessage').html(obj['function_result']);
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
                obj = JSON.parse(response);
                //alert(obj);
                $('div.returnmessage').html(obj['function_result']);
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