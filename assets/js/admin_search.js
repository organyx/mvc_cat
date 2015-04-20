$(document).ready(function(){

	var pages_list = $(this).serialize();

	//$('#contentRight').on('change', create_table());

	// $('#btn').on('click', function(){
	// 	test_this();
	// });
	// $('#ret').on('load', function(){
	// 	create_table();
	// });

	$('#btnSearch').on('click', function(){
		create_table();
	});

	function test_this()
	{
		$.ajax({
			type: 'POST',
			url: '/test/index/',
			//dataType: 'json',
			data: pages_list,
			success: function(data) {
				create_table();

			},
			error: function (x,y,z)
			{
				alert("X: " + x.responseCode + "; Y: " + y + "; Z: " + z);
			}

		});
	}

	function create_table()
	{
		var ret = document.getElementById('ret');

		var result = document.createElement('div');
		result.className = result.className + "result";
		result.setAttribute('id', 'result');

		var return_message = document.createElement('div');
		return_message.className = return_message.className + 'returnmessage';
		return_message.setAttribute('id', 'returnmessage');

		var result_table = document.createElement('table');
		result_table.className = result_table.className + "width-700 center WidthAuto";
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
		inner_table.className = inner_table.className + "width-500 TableStyle center WidthAuto";

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
		td1_inner.innerHTML = "Status : <span id=\"found_approval\"></span>";

		td2_inner.style.vAlign = 'top';
		td2_inner.style.align = 'right';

		tr1_inner.appendChild(td1_inner);
		tr1_inner.appendChild(td2_inner);

		td3_inner.innerHTML = "Title: <span id=\"found_title\"></span> ";
		td4_inner.innerHTML = "<span id=\"found_reg\"></span>";

		tr2_inner.appendChild(td3_inner);
		tr2_inner.appendChild(td4_inner);

		td5_inner.innerHTML = "URL: <a id=\"found_url_href\" target=\"_blank\"><span id=\"found_url\"></span></a>";
		td6_inner.style.width = '150px';
		td6_inner.style.height = '150px';
		td6_inner.rowSpan = '3';
		td6_inner.className = td6_inner.className + "TableStyleBorderLeft";
		td6_inner.innerHTML = "<a class=\"fancybox\" id=\"found_img_href\"  href=\"../../\"><img src=\"../../\" alt=\"Preview Thumb\" height=\"140px\" width=\"140px\" class=\"img-thumbnail\" id=\"found_img\">";

        tr3_inner.appendChild(td5_inner);
        tr3_inner.appendChild(td6_inner);

        td7_inner.innerHTML = "Languages: <span id=\"found_lang\"></span>";

        tr4_inner.appendChild(td7_inner);

        td8_inner.innerHTML = "Description: ";

        tr5_inner.appendChild(td8_inner);

        td9_inner.colSpan = '2';
        td9_inner.innerHTML = "<span id=\"found_descr\"></span>";

        tr6_inner.appendChild(td9_inner);

        inner_table.appendChild(tr1_inner);
        inner_table.appendChild(tr2_inner);
        inner_table.appendChild(tr3_inner);
        inner_table.appendChild(tr4_inner);
        inner_table.appendChild(tr5_inner);
        inner_table.appendChild(tr6_inner);

        td2.appendChild(inner_table);

        var inner_table_btns_container = document.createElement('div');
        inner_table_btns_container.className = inner_table_btns_container.className + "list";

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
        var delete_id = document.createElement('input');

        delete_id.setAttribute('type', 'hidden');
        delete_id.setAttribute('name', 'DeleteUserHiddenField');
        delete_id.setAttribute('value', '');
        delete_id.className = delete_id.className + "DeleteUserHiddenField";

        delete_btn.setAttribute('type', 'submit');
        delete_btn.setAttribute('name', 'DeleteUserButton');
        delete_btn.setAttribute('value', 'Delete User');
        delete_btn.className = delete_btn.className + 'DeleteUserButton';

        form_delete.appendChild(delete_id);
        form_delete.appendChild(delete_btn);

        var form_approve = document.createElement('form');
        form_approve.className = form_approve.className + "ApproveUserForm";
        form_approve.name = "ApproveUserForm";
        form_approve.method = "POST";

        var approve_btn = document.createElement('input');
        var approve_id = document.createElement('input');
        var approve_date = document.createElement('input');

        approve_id.setAttribute('type', 'hidden');
        approve_id.setAttribute('name', 'ApproveIDhiddenField');
        approve_id.setAttribute('value', '');
        approve_id.className = approve_id.className + "ApproveIDhiddenField";

        approve_date.setAttribute('type', 'hidden');
        approve_date.setAttribute('name', 'ApproveUserHiddenField');
        approve_date.setAttribute('value', 'CURRENT_TIMESTAMP()');
        approve_date.className = approve_date.className + "ApproveUserHiddenField";

        approve_btn.setAttribute('type', 'submit');
        approve_btn.setAttribute('name', 'ApproveUserButton');
        approve_btn.setAttribute('value', 'Approve User');
        approve_btn.className = approve_btn.className + "ApproveUserButton";

        form_approve.appendChild(approve_date);
        form_approve.appendChild(approve_id);
        form_approve.appendChild(approve_btn);

        td1_inner_table_btns.appendChild(form_delete);
        td2_inner_table_btns.appendChild(form_approve);

        tr_inner_table_btns.appendChild(td1_inner_table_btns);
        tr_inner_table_btns.appendChild(td2_inner_table_btns);

        inner_table_btns.appendChild(tr_inner_table_btns);
        inner_table_btns_container.appendChild(inner_table_btns);

        td3.appendChild(inner_table_btns_container);

        tr1.appendChild(td1);
        tr2.appendChild(td2);
        tr3.appendChild(td3);

        result_table.appendChild(tr1);
        result_table.appendChild(tr2);
        result_table.appendChild(tr3);

        ret.appendChild(result);
        ret.appendChild(return_message);
        ret.appendChild(result_table);
	}
});