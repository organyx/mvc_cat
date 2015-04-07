$(document).ready(function(){
	
	if(document.getElementById('start_row') != null)
	{
		var this_page = document.getElementById('start_row').value;
	}
	else
	{
		var this_page = 0;
	}

	pages_list = $(this).serialize();
	$('#contentRight').on('change', make_a_call(pages_list));

	function make_a_call()
	{
		var limit = 0;
		var per_page = 0;
		if(document.getElementById('perPage_html') != null)
		{
			per_page = document.getElementById('perPage_html').value;
		}
		else
		{
			per_page = 10;
		}
		var start_row = this_page;
		
		data = { 
			limit: limit,
			per_page: per_page,
			start_row: start_row
		}
		
		pages_list = $(this).serialize() + "&" + $.param(data);

		$.ajax({
			type: 'post',
			url: '/main/index/',
			dataType: 'json',
			data: pages_list,
			beforeSend: function ()
			{
				$('div#contentRight').html('<div class="loading"><img src="../../assets/images/loader.gif" alt="Loading..." /></div>');
			},
			success: function (data, func)
			{
	   			create_main(data, per_page, start_row);

	   			$('#perPage_html').on('change', function()
				{
					var p = document.getElementById('perPage_html').value
					var pages = {
						per_page: document.getElementById('perPage_html').value, 
					};
					$.post('/main/index/', pages, make_a_call(pages_list, p), 'json');
				});

				$('#next_page').on('click', function()
				{
					var pages = { page_to_go: (this_page + 1) };
					alert(pages['page_to_go']);
					$.post('/main/index/', pages, make_a_call(pages_list), 'json');
				});

				$('#prev_page').on('click', function()
				{
					var pages = { page_to_go: (this_page - 1) };
					alert(pages['page_to_go']);
					$.post('/main/index/', pages, make_a_call(pages_list), 'json');
				});
			},
			error: function (x,y,z)
			{
				alert("X: " + x.responseCode + "; Y: " + y + "; Z: " + z);
			}
		});
	}


	function pagination_numbers(data)
	{
		var one = document.createTextNode("Showing: ");
		var two = document.createTextNode(" - to - ");
		var three = document.createTextNode("- of - ");

		var span_from = document.getElementById('span_from');
   		var span_per_page = document.getElementById('span_per_page');
   		var span_total = document.getElementById('span_total');

   		span_from.innerHTML("one");
   		// span_per_page.appendChild(two);
   		// span_total.appendChild(three);
	}

	function create_page_limit()
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

		select.appendChild(opt1);
		select.appendChild(opt2);
		select.appendChild(opt3);

		return select;
	}

	function create_page_btns()
	{
		var divider = document.createTextNode(' | ');
		var btns = document.createElement('div');
		var next = document.createElement('a');
		var prev = document.createElement('a');

		next.setAttribute('href', '#');
		next.setAttribute('id', 'next_page');
		prev.setAttribute('href', '#');
		prev.setAttribute('id', 'prev_page');

		next.innerHTML = 'Next';
		prev.innerHTML = 'Previous';

		btns.appendChild(prev);
		btns.appendChild(divider);
		btns.appendChild(next);

		return btns;
	}

	function create_main(data, per_page,start_row_nr)
	{
			var start_row = document.createElement('input');
			start_row.type = 'hidden';
			start_row.setAttribute('id', 'start_row');
			start_row.value = start_row_nr;

			var content = document.getElementById("contentRight");
   			var main_table = document.createElement('table');
   			main_table.className = main_table.className + "width-670 center WidthAuto";

   			var tr1 = document.createElement('tr');
   			var tr2 = document.createElement('tr');
   			var tr3 = document.createElement('tr');

   			var td1 = document.createElement('td');
   			var td2 = document.createElement('td');
   			var td3 = document.createElement('td');

   			td1.style.align = 'right';
   			td1.style.vAlign = 'top';

   			var span_from = document.createElement('span');
   			var span_per_page = document.createElement('span');
   			var span_total = document.createElement('span');

   			span_from.setAttribute('id','span_from');
   			span_per_page.setAttribute('id','span_per_page');
   			span_total.setAttribute('id','span_total');

   			this_page = data[data.length-1]['startRow'];
   			//alert(this_page);

   			span_from.appendChild(document.createTextNode("Showing: " + (data[data.length-1]['startRow'] + 1)));
   			span_per_page.appendChild(document.createTextNode(" - to - " + Math.min(data[data.length-1]['startRow'] + data[data.length-1]['maxRows'], data[data.length-1]['totalRows'])));
   			span_total.appendChild(document.createTextNode(" - of - " + data[data.length-1]['totalRows']));

   			td1.appendChild(span_from);
   			td1.appendChild(span_per_page);
   			td1.appendChild(span_total);

   			td2.style.align = 'center';
   			td2.style.vAlign = 'top';

   			td3.style.align = 'right';
   			td3.style.vAlign = 'top';
   			td3.appendChild(create_page_btns());

   			tr1.appendChild(td1);

            for (var i = 0; i < per_page; i++) 
            {
            	// console.log(data[i]);
            	if(typeof data[i] !== 'undefined' && ("userID" in data[i]))
            	{
            		var t = create_item_table(data[i]);
	            	td2.appendChild(t);
	            	tr2.appendChild(td2);
            	}
            };

            tr3.appendChild(td3);

            main_table.appendChild(tr1);
            main_table.appendChild(tr2);
            main_table.appendChild(tr3);
            content.appendChild(create_page_limit());
            content.appendChild(start_row);
            content.appendChild(main_table);
	}

	function create_item_table(data_item)
	{
		    var content = document.getElementById("contentRight");
            var table = document.createElement('table');
            table.border = 1;
            table.className = table.className + "width-630 TableStyle center WidthAuto";

            var br = document.createElement('br');

            var tr1 = document.createElement('tr');
            var td1 = document.createElement('td');
            var td2 = document.createElement('td');
            var td3 = document.createElement('td');

            var tr2 = document.createElement('tr');
            var td4 = document.createElement('td');
            var td5 = document.createElement('td');
            
            td1.innerHTML = data_item['userID'];
            //ITEM LINK
           	var item_link = document.createElement('a');
           	item_link.href = '/webitem/index/?site='+data_item['userID'];
           	item_link.innerHTML = data_item['title'];
           	//IMAGE
           	var image_link = document.createElement('a');
           	image_link.href = '../../' + data_item['preview_thumb'];
           	image_link.className = image_link.className + 'fancybox';
           	var image = document.createElement('img');
           	image.src = '../../' + data_item['preview_thumb'];
           	image.className = image.className + 'img-thumbnail';
           	image.style.width = "140px";
           	image.style.height = "140px";
           	image.alt = "Preview Thumb";

           	td2.style.width = '400px';
           	td2.style.height = '50px';
           	td2.style.align = 'center';
           	td2.appendChild(item_link);

           	image_link.appendChild(image);
           	td3.style.width = '150px';
           	td3.rowSpan = '2';
           	td3.style.align = 'center';
           	td3.appendChild(image_link);

           	var url = document.createElement('a');
           	url.href = data_item['url'];
           	url.innerHTML = data_item['url'];
           	td5.style.height = '50px';
           	td5.style.align = 'center';
           	td5.appendChild(url);

            tr1.appendChild(td1);
            tr1.appendChild(td2);
            tr1.appendChild(td3);

            tr2.appendChild(td4);
            tr2.appendChild(td5);
           

            table.appendChild(tr1);
            table.appendChild(tr2);
            table.appendChild(br);

            return table;
	}
});