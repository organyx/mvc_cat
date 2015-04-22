$(document).ready(function(){
	$('body').on('click', '#more_posts', function(e){
		e.preventDefault();

		var container = $('#load_more_posts');
		$(container).html('<div><img src="../../assets/images/loader.gif" alt="Loading..." /></div>');

		var newHtml = '';

		$.ajax({
			url: '/test/index/',
			type: 'post',
			data: {'page': $(this).attr('href')},
			cache: false,
			success: function(json)
			{
				$.each(json, function(i, item){
					if(typeof item == 'object')
					{
						newHtml += '<div class="user"> <a href="#" class="clearfix"> <img src="'+item.profile_pic+'" class="avi"> <h4>'+item.username+'</h4></a></div>';
					}
					else
					{
						return false;
					}
				});

				if(json.nextpage != 'end')
				{
					$(container).html('<a href="'+json.nextpage+'" id="more_posts" class="bigblue thinblue">Load more posts.</a>');
				}
				else
				{
					 $(container).html('<p></p>');
				}

				$('#followers').append(newhtml);
			},
			error: function(xhr, desc, err) 
			{
		        console.log(xhr + "\n" + err);
		    }
		});
	});
});