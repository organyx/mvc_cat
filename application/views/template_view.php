<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<title>Web Catalogue</title>
		<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css" />
		<link href="http://fonts.googleapis.com/css?family=Kreon" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="/assets/css/Layout.css" />
		<link rel="stylesheet" type="text/css" href="/assets/css/Menu.css" />
		<script src="/assets/js/jquery-2.1.3.min.js" type="text/javascript"></script>

		<link rel="stylesheet" href="/assets/js/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
		<script type="text/javascript" src="/assets/js/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>

		<!-- Optionally add helpers - button, thumbnail and/or media -->
		<link rel="stylesheet" href="/assets/js/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
		<script type="text/javascript" src="/assets/js/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
		<script type="text/javascript" src="/assets/js/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
		<link rel="stylesheet" href="/assets/js/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
		<script type="text/javascript" src="/assets/js/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
		<!-- Pop Up -->
		<script type="text/javascript">
			$(document).ready(function() {
				$(".fancybox").fancybox();
			});
		</script>
	</head>
	<body>
		<div id="Holder">
		  <div id="Header"></div>
		  <div id="NavBar">
		    	<nav>
		        	<ul>
		            	<li><a href="/">Main</a></li>
		                <li><a href="/register">Register</a></li>
		                <li><a href="/forgot_pass">Forgot Password</a></li>
		                
		            </ul>
		        </nav>
		  </div>
		  <div id="Content">
		  <?php include 'application/views/'.$content_view; ?>
		  </div>
		  <div id="Footer"></div>
		</div>
	</body>
</html>