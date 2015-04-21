$(document).ready(function(){

	var pages_list = $(this).serialize();

	$('#btnSearch').on('click', function(){
		test_this();
	});

	$('#reset').on('click', function(){
		reset_result();
	});

	var executed = false;

	function test_this()
	{
		data = {
                action: 'search',
                name: $('input.email').val()
            };
        data = $(this).serialize() + "&" + $.param(data);

		$.ajax({
			type: 'POST',
			url: '/test/index/',
			dataType: 'json',
			data: data,
			success: function(data) {

				reset_result();

				if(data['found'] == true && !executed)
				{
					create_table(data['user']);
					executed = true;
					//document.getElementById('email').readOnly = true;
				}
				else if(data['found'] == false)
				{
					not_found(data['result']);
				}

				$('#delete_btn').on('click', function(e){
					delete_web(data['user']['userID']);
					e.preventDefault();
				});

				$('#approve_btn').on('click', function(e){
					approve_web(data['user']['userID']);
					e.preventDefault();
				});
			},
			error: function (x,y,z)
			{
				alert("X: " + x.responseCode + "; Y: " + y + "; Z: " + z);
			}

		});
	}

	function approve_web(id)
	{
		data = {
			action: 'approve',
			id: id
		};

		data = $(this).serialize() + "&" + $.param(data);

		$.ajax({
			type: 'POST',
			url: '/test/index/',
			dataType: 'json',
			data: data,
			success: function(data) {
				var return_message = document.getElementById('returnmessage');
				return_message.innerHTML = data['function_result'];
			},
			error: function (x,y,z)
			{
				alert("X: " + x.responseCode + "; Y: " + y + "; Z: " + z);
			}
		});
	}

	function delete_web(id)
	{
		data = {
			action: 'delete',
			id: id
		};

		data = $(this).serialize() + "&" + $.param(data);

		$.ajax({
			type: 'POST',
			url: '/test/index/',
			dataType: 'json',
			data: data,
			success: function(data) {
				var return_message = document.getElementById('returnmessage');
				return_message.innerHTML = data['function_result'];
			},
			error: function (x,y,z)
			{
				alert("X: " + x.responseCode + "; Y: " + y + "; Z: " + z);
			}
		});
	}

	function check_browser()
	{
		var isOpera = !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;// Opera 8.0+ (UA detection to detect Blink/v8-powered Opera)
		var isFirefox = typeof InstallTrigger !== 'undefined';   // Firefox 1.0+
		var isSafari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0;// At least Safari 3+: "[object HTMLElementConstructor]"
		var isChrome = !!window.chrome && !isOpera;              // Chrome 1+
		var isIE = /*@cc_on!@*/false || !!document.documentMode; // At least IE6

		var version = bowser.version;

		if(isOpera)
		{
			return ['opera', version];
		}
		else if(isFirefox)
		{
			return ['ff', version];
		}
		else if(isSafari)
		{
			return ['safari', version];
		}
		else if(isChrome)
		{
			return ['chrome', version];
		}
		else if(isIE)
		{
			return ['ie', version];
		}

		return false;
	}

	function reset_result()
	{
		var check = check_browser();
		var table = document.getElementById('result_table');
		var return_message = document.getElementById('returnmessage');
		var user = document.getElementById('email');
			if(check != false)
			{
				switch(check[0])
				{
					case 'opera':
					case 'ff':
					case 'safari':
					case 'chrome':
						if(table)
							table.remove();
						if(return_message)
							return_message.remove();
						user.value = '';
						break;
					case 'ie':
						if (check[1] > 6)
						{
							if(table)
								table.remove();
							if(return_message)
								return_message.remove();
							user.value = '';
						}
						break;
					default:
						if(table)
							table.parentNode.removeChild(table);
						if(return_message)
							return_message.parentNode.removeChild(table);
						user.value = '';
						break;
				}
			}
		executed = false;
		//document.getElementById('email').readOnly = false;
	}

	function not_found(result_msg)
	{
		create_return_msg();
		var return_message = document.getElementById('returnmessage');
		return_message.innerHTML = result_msg;
	}

	function create_return_msg()
	{
		var ret = document.getElementById('ret');

		var return_message = document.createElement('div');
		return_message.className = return_message.className + 'returnmessage';
		return_message.setAttribute('id', 'returnmessage');

		ret.appendChild(return_message);
	}

	function create_table(user)
	{
		var ret = document.getElementById('ret');

		var result_table = document.createElement('table');
		result_table.className = result_table.className + "width-700 center width_auto";
		result_table.setAttribute('id', 'result_table');

		var tr1 = document.createElement('tr');
		var tr2 = document.createElement('tr');
		var tr3 = document.createElement('tr');

		var td1 = document.createElement('td');
		var td2 = document.createElement('td');
		var td3 = document.createElement('td');

		td1.style.textAlign = 'center';
		td1.innerHTML = "Account: ";

		var inner_table = document.createElement('table');
		inner_table.className = inner_table.className + "width-500 table_style center width_auto";

		var tr1_inner = document.createElement('tr');
		var tr2_inner = document.createElement('tr');
		var tr3_inner = document.createElement('tr');
		var tr4_inner = document.createElement('tr');
		var tr5_inner = document.createElement('tr');
		var tr6_inner = document.createElement('tr');

		var td1_inner = document.createElement('td');
		var td2_inner = document.createElement('td');
		var td3_inner = document.createElement('td');
		var td4_inner = document.createElement('td');
		var td5_inner = document.createElement('td');
		var td6_inner = document.createElement('td');
		var td7_inner = document.createElement('td');
		var td8_inner = document.createElement('td');
		var td9_inner = document.createElement('td');

		td1_inner.style.vAlign = 'top';
		td1_inner.innerHTML = "Status : " + user['approval'];

		td2_inner.style.vAlign = 'top';
		td2_inner.style.align = 'right';

		tr1_inner.appendChild(td1_inner);
		tr1_inner.appendChild(td2_inner);

		td3_inner.innerHTML = "Title: " + user['title'];
		td4_inner.innerHTML = user['registration'];

		tr2_inner.appendChild(td3_inner);
		tr2_inner.appendChild(td4_inner);

		td5_inner.innerHTML = "URL: <a id=\"found_url_href\" target=\"_blank\" href=\"" + user['url'] + "\">" + user['url'] + "</a>";
		td6_inner.style.width = '150px';
		td6_inner.style.height = '150px';
		td6_inner.rowSpan = '3';
		td6_inner.className = td6_inner.className + "border_left";
		td6_inner.innerHTML = "<a class=\"fancybox\" id=\"found_img_href\"  href=\"../../" + user['preview'] + "\"><img src=\"../../" + user['preview'] + "\" alt=\"Preview Thumb\" height=\"140px\" width=\"140px\" class=\"img-thumbnail\" id=\"found_img\">";

        tr3_inner.appendChild(td5_inner);
        tr3_inner.appendChild(td6_inner);

        td7_inner.innerHTML = "Languages: " + user['language'];

        tr4_inner.appendChild(td7_inner);

        td8_inner.innerHTML = "Description: ";

        tr5_inner.appendChild(td8_inner);

        td9_inner.colSpan = '2';
        td9_inner.innerHTML = user['description'];

        tr6_inner.appendChild(td9_inner);

        inner_table.appendChild(tr1_inner);
        inner_table.appendChild(tr2_inner);
        inner_table.appendChild(tr3_inner);
        inner_table.appendChild(tr4_inner);
        inner_table.appendChild(tr5_inner);
        inner_table.appendChild(tr6_inner);

        td2.appendChild(inner_table);

        td3.appendChild(create_inner_table_btns(user['userID']));

        tr1.appendChild(td1);
        tr2.appendChild(td2);
        tr3.appendChild(td3);

        result_table.appendChild(tr1);
        result_table.appendChild(tr2);
        result_table.appendChild(tr3);

        create_return_msg();
        ret.appendChild(result_table);
	}
	
	function create_inner_table_btns(id)
	{
		var inner_table_btns_container = document.createElement('div');
        inner_table_btns_container.className = inner_table_btns_container.className + "center";

        var inner_table_btns = document.createElement('table');
        inner_table_btns.className = inner_table_btns.className + "center";

        var tr_inner_table_btns = document.createElement('tr');

        var td1_inner_table_btns = document.createElement('td');
        var td2_inner_table_btns = document.createElement('td');

        var form_delete = document.createElement('form');
        form_delete.className = form_delete.className + "DeleteUserForm";
        form_delete.name = "DeleteUserForm";
        form_delete.method = "POST";

        var delete_btn = document.createElement('input');

        delete_btn.setAttribute('type', 'submit');
        delete_btn.setAttribute('name', 'DeleteUserButton');
        delete_btn.setAttribute('value', 'Delete User');
        delete_btn.setAttribute('id', 'delete_btn');
        delete_btn.className = delete_btn.className + 'DeleteUserButton';

        form_delete.appendChild(delete_btn);

        var form_approve = document.createElement('form');
        form_approve.className = form_approve.className + "ApproveUserForm";
        form_approve.name = "ApproveUserForm";
        form_approve.method = "POST";

        var approve_btn = document.createElement('input');

        approve_btn.setAttribute('type', 'submit');
        approve_btn.setAttribute('name', 'ApproveUserButton');
        approve_btn.setAttribute('value', 'Approve User');
        approve_btn.setAttribute('id', 'approve_btn');
        approve_btn.className = approve_btn.className + "ApproveUserButton";

        form_approve.appendChild(approve_btn);

        td1_inner_table_btns.appendChild(form_delete);
        td2_inner_table_btns.appendChild(form_approve);

        tr_inner_table_btns.appendChild(td1_inner_table_btns);
        tr_inner_table_btns.appendChild(td2_inner_table_btns);

        inner_table_btns.appendChild(tr_inner_table_btns);
        inner_table_btns_container.appendChild(inner_table_btns);

        return inner_table_btns_container;
	}	
});