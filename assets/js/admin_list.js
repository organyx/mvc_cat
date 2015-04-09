$(document).ready(function(){
    $('#user_list').on('change', make_a_call(0));

    function make_a_call(page_n)
    {
        var page_num = parseInt(page_n);

        // var per_page = 0;
        // if(document.getElementById('perPage_html') != null)
        // {
        //     per_page = document.getElementById('perPage_html').value;
        // }
        // else
        // {
        //     per_page = 10;
        // }
        
        var data = { 
            //per_page: per_page,
            page_num: page_num
        };
        
        var pages_list = $(this).serialize() + "&" + $.param(data);

        $.ajax({
            type: 'post',
            url: '/admin/index/',
            dataType: 'json',
            data: pages_list,
            beforeSend: function ()
            {
                $('div#user_list').html('<div class="loading"><img src="../../assets/images/loader.gif" alt="Loading..." /></div>');
            },
            success: function (data_returned, func)
            {
                $('div.loading').addClass('off');
                create_main_table(data_returned);

            },
            error: function (x,y,z)
            {
                alert("X: " + x.responseCode + "; Y: " + y + "; Z: " + z);
            }
        });
    }

    function create_main_table(data)
    {
        var user_list = document.getElementById('user_list');
        var user_search = document.getElementById('user_search');

        var main_table = document.createElement('table');
        main_table.className = main_table.className + "width-670 center WidthAuto";

        var tr1 = document.createElement('tr');
        var tr2 = document.createElement('tr');
        var tr3 = document.createElement('tr');

        var td1 = document.createElement('td');
        var td2 = document.createElement('td');
        var td3 = document.createElement('td');

        td1.style.textAlign = 'right';
        td1.style.vAlign = 'top';

        td2.style.textAlign = 'center';
        td2.style.vAlign = 'top';

        td3.style.textAlign = 'right';
        td3.style.vAlign = 'top';

        tr1.appendChild(td1);

        for (var i = 0; i < data[data.length-1]['maxRows']; i++) {
            if()
            {
                var t = create_item_table(data[i]);
                td2.appendChild(document.createElement('br'));
                td2.appendChild(t);
                tr2.appendChild(td2);
            }
        }

        tr3.appendChild(td3);
        main_table.appendChild(tr1);
        main_table.appendChild(tr2);
        main_table.appendChild(tr3);
        user_list.insertAfter(main_table, user_search);
    }

    function create_item_table(data_item)
    {
        var item_table = document.createElement('table');
        item_table.className = item_table.className + "width-600 TableStyle center WidthAuto";

        var tr1 = document.createElement('tr');
        var tr2 = document.createElement('tr');

        var td1 = document.createElement('td');
        var td2 = document.createElement('td');
        var td3 = document.createElement('td');
        var td4 = document.createElement('td');

        td1.style.width = '300px';
        td1.innerHTML = "Registration Date: " + data_item['registration'];

        td2.style.width = '300px';
        if(data_item['approval']=="0000-00-00 00:00:00")
        {
            td2.style.color = 'red';
        }
        else
        {
            td2.style.color = 'green';
        }
        td2.innerHTML = "Approval Date: " + data_item['approval'];

        td3.style.width = '300px';
        td3.innerHTML = "User: " + data_item['first_name'] + data_item['last_name'] + " | Account: " + data_item['email'];

        td4.style.width = '300px';
        td4.innerHTML = "Status: ";
        if(data_item['approval']!="0000-00-00 00:00:00")
        {
            td4.innerHTML += "Approved";
        }
        else
        {
            td4.innerHTML += "Awaiting Approval";
        }
    }

    //create function, it expects 2 values.
    function insertAfter(newElement,targetElement) {
        //target is what you want it to go after. Look for this elements parent.
        var parent = targetElement.parentNode;
     
        //if the parents lastchild is the targetElement...
        if(parent.lastchild == targetElement) {
            //add the newElement after the target element.
            parent.appendChild(newElement);
            } else {
            // else the target has siblings, insert the new element between the target and it's next sibling.
            parent.insertBefore(newElement, targetElement.nextSibling);
            }
    }
});