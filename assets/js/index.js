$(document).ready(function(){
	var start_row = document.getElementById('startRow').value;
	var total_rows = document.getElementById('totalRows').value;
	var total_pages = document.getElementById('totalPages').value;
	var per_page = document.getElementById('maxRows').value;
	var page = document.getElementById('pageNum').value;

	$('a#next').click(function(){
		// update_table();
		var pages = {
			start_row: parseInt(start_row), 
			total_rows: parseInt(total_rows), 
			total_pages: parseInt(total_pages), 
			per_page: parseInt(per_page), 
			page: parseInt(page) + 1
		};
		$.post('/main/index/', pages, function(data){
			reset_data();
			fill_tables();
		}, 'json');
	});

	$('a#previous').click(function(){
		var pages = {
			start_row: parseInt(start_row), 
			total_rows: parseInt(total_rows), 
			total_pages: parseInt(total_pages), 
			per_page: parseInt(per_page), 
			page: parseInt(page) - 1
		};
		$.post('/main/index/', pages, function(data){
			//create_main(data);
		}, 'json');
	});

	function update_table()
	{
		data = { 
			limit: limit,
			per_page: per_page,
			start_row: start_row,
			total_rows: total_rows,
			page: page
		}
		data = $(this).serialize() + "&" + $.param(data);
		$.ajax({
			type: 'post',
			url: '/main/index/',
			dataType: 'json',
			data: data,
			beforeSend: function ()
			{
				//$('div#contentRight').html('<div class="loading"><img src="../../assets/images/loader.gif" alt="Loading..." /></div>');
			},
			success: function (data, func)
			{
				//alert(data);
				//alert(func);
				// var obj = JSON.parse(data);
	   //              alert(obj);
	   			pagination_numbers();
	   			//create_main(data);
			},
			error: function (x,y,z)
			{
				alert("X: " + x.responseCode + "; Y: " + y + "; Z: " + z);
			}
		});
	}

	function pagination_numbers()
	{
		var top_row = document.getElementById('top_row');
		var result_start_page = document.getElementById('result_start_page');
		var result_end_page = document.getElementById('result_end_page');
		var result_total = document.getElementById('result_total');
		result_start_page.innerHTML = parseInt(start_row) + 1;
		result_end_page.innerHTML = Math.min(parseInt(start_row) + parseInt(per_page), parseInt(total_rows));
		result_total.innerHTML = parseInt(total_rows);
		//top_row.innerHTML = "Showing results : " + (start_row + 1) + " to " + (Math.min(start_row + per_page, total_rows)) + " of " + total_rows;
	}

	function reset_data()
	{
        //TABLE DATA
        $('span#result_start_page').empty();
        $('span#result_end_page').empty();
        $('span#result_total').empty();
        $('span.main_item_title').empty();
        $('a.main_item_href').attr("href", "");
        $('a.main_item_img_href').attr("href", "");
        $('img.main_item_img_src').attr("src", "");
        $('a.main_item_url').attr("href", "");
        $('span.main_item_url').empty();

	}

	function fill_tables()
	{
		$('span#result_start_page').innerHTML = start_row;
        $('span#result_end_page').empty();
        $('span#result_total').empty();
        $('span.main_item_title').empty();
        $('a.main_item_href').attr("href", "");
        $('a.main_item_img_href').attr("href", "");
        $('img.main_item_img_src').attr("src", "");
        $('a.main_item_url').attr("href", "");
        $('span.main_item_url').empty();
	}

	function create_main(data)
	{
			// var content = document.getElementById("contentRight");
   // 			var main_table = document.createElement('table');
   // 			main_table.className = main_table.className + "width-670 center WidthAuto";

   // 			var next_link = document.createElement('a');
   // 			next_link.innerHTML = "Next";
   // 			next_link.href = "#";
   // 			var previous_link = document.createElement('a');
   // 			previous_link.innerHTML = "Previous";
   // 			previous_link.href = "#";

   // 			var tr1 = document.createElement('tr');
   // 			var tr2 = document.createElement('tr');
   // 			var tr3 = document.createElement('tr');

   // 			var td1 = document.createElement('td');
   // 			var td2 = document.createElement('td');
   // 			var td3 = document.createElement('td');

   // 			td1.style.align = 'right';
   // 			td1.style.vAlign = 'top';
   // 			td1.setAttribute('id', 'top_row');

   // 			td2.style.align = 'center';
   // 			td2.style.vAlign = 'top';

   // 			td3.style.align = 'right';
   // 			td3.style.vAlign = 'top';
   // 			td3.appendChild(previous_link);
   // 			td3.appendChild(next_link);

   // 			tr1.appendChild(td1);

   //          for (var i = 0; i < per_page; i++) 
   //          {
   //          	console.log(data[i]);
   //          	var t = create_item_table(data[i]);
   //          	td2.appendChild(t);
   //          	tr2.appendChild(td2);
   //          };

   //          tr3.appendChild(td3);

   //          main_table.appendChild(tr1);
   //          main_table.appendChild(tr2);
   //          main_table.appendChild(tr3);
   //          content.appendChild(main_table);
   //          pagination_numbers();
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