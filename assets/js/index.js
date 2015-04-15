$(document).ready(function(){

	var pages_list = $(this).serialize();
	$('#contentRight').on('change', make_a_call(0));

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
			url: '/main/index/',
			dataType: 'json',
			data: pages_list,
			beforeSend: function ()
			{
				$('div#contentRight').html('<div class="loading"><img src="../../assets/images/loader.gif" alt="Loading..." /></div>');
			},
			success: function (data_returned, func)
			{
				$('div.loading').addClass('off');
	   			create_main(data_returned);

	   			$('#perPage_html').on('change', function()
				{
					make_a_call(0);
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
		var divider = document.createTextNode(' | ');
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
		}

		var current = document.createTextNode(" | " + (parseInt(pages['pageNum']) + 1) + " ");
		btns.appendChild(current);
		btns.appendChild(divider);

		if (pages['pageNum'] < pages['totalPages']) {
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

	function create_main(data)
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

			var content = document.getElementById("contentRight");

   			var main_table = document.createElement('table');
   			main_table.className = main_table.className + "width-670 center WidthAuto";
   			main_table.setAttribute('id', 'main_table');

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

   			this_page = data[data.length-1]['pageNum'];
   			
   			span_from.appendChild(document.createTextNode("Showing: " + (parseInt(data[data.length-1]['startRow'] + 1))));
   			span_per_page.appendChild(document.createTextNode(" - to - " + Math.min(parseInt(data[data.length-1]['startRow']) + parseInt(data[data.length-1]['maxRows']), parseInt(data[data.length-1]['totalRows']))));
   			span_total.appendChild(document.createTextNode(" - of - " + parseInt( data[data.length-1]['totalRows'])));

   			td1.appendChild(span_from);
   			td1.appendChild(span_per_page);
   			td1.appendChild(span_total);

   			td2.style.align = 'center';
   			td2.style.vAlign = 'top';

   			td3.style.align = 'right';
   			td3.style.vAlign = 'top';
   			td3.appendChild(create_page_btns(data[data.length-1]));

   			tr1.appendChild(td1);

            for (var i = 0; i < parseInt(data[data.length-1]['maxRows']); i++) 
            {
            	// console.log(data[i]);
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
			main_table.appendChild(document.createElement('br'));
            main_table.appendChild(tr1);
            main_table.appendChild(tr2);
            main_table.appendChild(tr3);
            
            content.appendChild(main_table);
	}

	function create_item_table(data_item)
	{
		    //var content = document.getElementById("contentRight");
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
            
            td1.innerHTML = data_item['rn'];
            td1.style.textAlign = 'center';
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
           	//image.style.height = "140px";
           	image.alt = "Preview Thumb";

           	td2.style.width = '400px';
           	td2.style.height = '50px';
           	td2.style.textAlign = 'center';
           	td2.appendChild(item_link);

           	image_link.appendChild(image);
           	td3.style.width = '150px';
           	td3.rowSpan = '2';
           	td3.style.textAlign = 'center';
           	td3.appendChild(image_link);

           	var url = document.createElement('a');
           	url.href = data_item['url'];
           	url.innerHTML = data_item['url'];
           	td5.style.height = '50px';
           	td5.style.textAlign = 'center';
           	td5.appendChild(url);

            tr1.appendChild(td1);
            tr1.appendChild(td2);
            tr1.appendChild(td3);

            tr2.appendChild(td4);
            tr2.appendChild(td5);
           
            table.appendChild(tr1);
            table.appendChild(tr2);

            return table;
	}
});