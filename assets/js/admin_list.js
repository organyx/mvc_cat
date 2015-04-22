$(document).ready(function(){
    $('#user_list').on('load', make_a_call(0));

    function make_a_call(page_n)
    {
        var page_num = parseInt(page_n);

        var per_page = 0;
        if(document.getElementById('perPage_html') != null)
        {
            per_page = document.getElementById('perPage_html').value;
        }
        else
        {
            per_page = 10;
        }
        
        var data = { 
            per_page: per_page,
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

                $('#perPage_html').on('change', function()
                {
                    make_a_call(0);
                });

                $('#back_two').on('click', function()
                {
                    make_a_call(data['page_num'] - 2);
                });

                $('#back_one').on('click', function()
                {
                    make_a_call(data['page_num'] - 1);
                });

                $('#fwd_two').on('click', function()
                {
                    make_a_call(data['page_num'] + 2);
                });

                $('#fwd_one').on('click', function()
                {
                    make_a_call(data['page_num'] + 1);
                });

                $('#next_page').on('click', function()
                {
                    make_a_call(data['page_num'] + 1);
                });

                $('#prev_page').on('click', function()
                {
                    make_a_call(data['page_num'] - 1);
                });

                $('#first_page').on('click', function()
                {
                    make_a_call(0);
                });

                $('#last_page').on('click', function()
                {
                    make_a_call(Math.max(parseInt(data_returned[data_returned.length-1]['totalPages']), parseInt(data_returned[data_returned.length-1]['pageNum']) + 1));
                });
            },
            error: function (x,y,z)
            {
                alert("X: " + x.responseCode + "; Y: " + y + "; Z: " + z);
            }
        });
    }

    function create_main_table(data)
    {
        var current_opt = 0;
            switch(parseInt(data[data.length-1]['maxRows']))
            {
                case 10:
                    current_opt = 1;
                    break;
                case 20: 
                    current_opt = 2;
                    break;
                case 50:
                    current_opt = 3;
                    break;
            }

        var user_list = document.getElementById('user_list');
        var user_search = document.getElementById('user_search');

        var main_table = document.createElement('table');
        main_table.className = main_table.className + "width-670 center width_auto";

        var tr1 = document.createElement('tr');
        var tr2 = document.createElement('tr');
        var tr3 = document.createElement('tr');

        var td1 = document.createElement('td');
        var td2 = document.createElement('td');
        var td3 = document.createElement('td');

        td1.style.textAlign = 'right';
        td1.style.vAlign = 'top';

        var span_from = document.createElement('span');
        var span_per_page = document.createElement('span');
        var span_total = document.createElement('span');

        span_from.setAttribute('id','span_from');
        span_per_page.setAttribute('id','span_per_page');
        span_total.setAttribute('id','span_total');

        this_page = data[data.length-1]['pageNum'];
            
        span_from.appendChild(document.createTextNode("Showing: " + (parseInt(data[data.length-1]['startRow'] + 1))));
        span_per_page.appendChild(document.createTextNode(" - to - " + Math.min(parseInt(data[data.length-1]['startRow']) + parseInt(data[data.length-1]['maxRows']), parseInt(data[data.length-1]['totalRows']))));
        span_total.appendChild(document.createTextNode(" - of - " + parseInt( data[data.length-1]['totalRows']) + " - by - "));

        td1.appendChild(span_from);
        td1.appendChild(span_per_page);
        td1.appendChild(span_total);

        td2.style.textAlign = 'center';
        td2.style.vAlign = 'top';

        td3.style.textAlign = 'right';
        td3.style.vAlign = 'top';

        td3.appendChild(create_page_btns(data[data.length-1]));

        tr1.appendChild(td1);

        for (var i = 0; i < data[data.length-1]['maxRows']; i++) {
            if(typeof data[i] !== 'undefined' && ("userID" in data[i]))
            {
                var t = create_item_table(data[i]);
                td2.appendChild(document.createElement('br'));
                td2.appendChild(t);
                tr2.appendChild(td2);
            }
        }

        tr3.appendChild(td3);

        td1.appendChild(create_page_limit(current_opt));
        main_table.appendChild(tr1);
        main_table.appendChild(tr2);
        main_table.appendChild(tr3);
        user_list.appendChild(main_table);

        insertAfter(user_list, user_search);
    }

    function create_item_table(data_item)
    {
        var item_table = document.createElement('table');
        item_table.className = item_table.className + "width-600 table_style center width_auto";

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

        tr1.appendChild(td1);
        tr1.appendChild(td2);
        tr2.appendChild(td3);
        tr2.appendChild(td4);

        item_table.appendChild(tr1);
        item_table.appendChild(tr2);

        return item_table;
    }

    function create_page_limit(current_opt)
    {
        var select = document.createElement('select');
        var opt1 = document.createElement('option');
        var opt2 = document.createElement('option');
        var opt3 = document.createElement('option');

        opt1.innerHTML = "10";
        opt2.innerHTML = "20";
        opt3.innerHTML = "50";

        opt1.value = 10;
        opt2.value = 20;
        opt3.value = 50;

        select.setAttribute('id', 'perPage_html');
        select.setAttribute('name', 'perPage_html');
        select.style.width = '100px';

        select.appendChild(opt1);
        select.appendChild(opt2);
        select.appendChild(opt3);

        var o = 0;
        switch(current_opt)
        {
            case 1:
                o = 10;
                break;
            case 2: 
                o = 20;
                break;
            case 3:
                o = 50;
                break;
        }
        select.value = o;

        return select;
    }

    function create_page_btns(pages)
    {
        var btns = document.createElement('div');
        btns.setAttribute('id', 'btns');
        btns.appendChild(document.createElement('br'));
        
        if (pages['pageNum'] > 0) {
            var first = document.createElement('a');
            first.setAttribute('href', '#');
            first.setAttribute('id', 'first_page');
            first.title = 'First Page';
            first.innerHTML = '<<';
            btns.appendChild(first);

            btns.appendChild(document.createTextNode(' | '));

            var prev = document.createElement('a');
            prev.setAttribute('href', '#');
            prev.setAttribute('id', 'prev_page');
            prev.title = 'Previous Page';
            prev.innerHTML = '<';
            btns.appendChild(prev);

            if(pages['pageNum'] >= 2)
            {
                btns.appendChild(document.createTextNode(' | '));

                var back_two = document.createElement('a');
                back_two.setAttribute('href', '#');
                back_two.setAttribute('id', 'back_two');
                back_two.title = 'Page: ' + (parseInt(pages['pageNum']) - 1);
                back_two.innerHTML = (parseInt(pages['pageNum']) - 1);
                btns.appendChild(back_two);
            }

            btns.appendChild(document.createTextNode(' | '));

            var back_one = document.createElement('a');
            back_one.setAttribute('href', '#');
            back_one.setAttribute('id', 'back_one');
            back_one.title = 'Page: ' + parseInt(pages['pageNum']);
            back_one.innerHTML = parseInt(pages['pageNum']);
            btns.appendChild(back_one);
        }

        var current_inner = document.createElement('span');
        var current_outer = document.createElement('span');
        current_inner.innerHTML = (parseInt(pages['pageNum']) + 1);
        current_inner.className = current_inner.className + "current_page";
        current_outer.appendChild(document.createTextNode(" | "));
        current_outer.appendChild(current_inner);
        current_outer.appendChild(document.createTextNode(" | "));
        btns.appendChild(current_outer);

        if (pages['pageNum'] < pages['totalPages']) {

            var fwd_one = document.createElement('a');
            fwd_one.setAttribute('href', '#');
            fwd_one.setAttribute('id', 'fwd_one');
            fwd_one.title = 'Page: ' + (parseInt(pages['pageNum']) + 2);
            fwd_one.innerHTML = (parseInt(pages['pageNum']) + 2);
            btns.appendChild(fwd_one);

            if (pages['pageNum'] <= pages['totalPages'] - 2) 
            {
                btns.appendChild(document.createTextNode(' | '));

                var fwd_two = document.createElement('a');
                fwd_two.setAttribute('href', '#');
                fwd_two.setAttribute('id', 'fwd_two');
                fwd_two.title = 'Page: ' + (parseInt(pages['pageNum']) + 3);
                fwd_two.innerHTML = (parseInt(pages['pageNum']) + 3);
                btns.appendChild(fwd_two);
            }

            btns.appendChild(document.createTextNode(' | '));

            var next = document.createElement('a');
            next.setAttribute('href', '#');
            next.setAttribute('id', 'next_page');
            next.title = 'Next Page';
            next.innerHTML = '>';
            btns.appendChild(next);

          

            btns.appendChild(document.createTextNode(' | '));

            var last = document.createElement('a');
            last.setAttribute('href', '#');
            last.setAttribute('id', 'last_page');
            last.title = 'Last Page';
            last.innerHTML = '>>';
            btns.appendChild(last);
        };
        
        return btns;
    }

    //create function, it expects 2 values.
    function insertAfter(newElement,targetElement) 
    {
        //target is what you want it to go after. Look for this elements parent.
        var parent = targetElement.parentNode;
     
        //if the parents lastchild is the targetElement...
        if(parent.lastchild == targetElement) 
        {
            //add the newElement after the target element.
            parent.appendChild(newElement);
        } 
        else 
        {
            // else the target has siblings, insert the new element between the target and it's next sibling.
            parent.insertBefore(newElement, targetElement.nextSibling);
        }
    }
});