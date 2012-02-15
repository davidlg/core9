{* Smarty *}

<!doctype>
<html>
<head>
	<title>Welcome to Core9!</title>
	
	<link rel="stylesheet" type="text/css" href="styles/bootstrap.min.css" />
</head>

<body>
	<h1>Core9 test page</h1>
	
	<p>
	Hello! It seems that Core9 does work in your machine. Remember to properly configure the <em>config/config.inc.php</em>
	file to avoid any problems.
	</p>
	
	<h3>What now?</h3>
	
	<p>
	You may want to start building/modifying some Controllers. You will find them in <em>controllers/</em>. The main controller is
	<em>index.class.php</em> (the one that renders this very text!). You may modify it or add your own controllers using it as a
	template. Remember that every controller extends the <em>core/core9.controller.class.php</em> class file.
	</p>
	
	<p>
	Templates are located in <em>templates/</em> and each controller has it own folder in here (but you may change this to fit your
	needs, just remember to give the proper path when rendering them), JavaScript files are usually stored in <em>js/</em> (you 
	will find there the mooTools library) and css files have their home in <em>styles/</em> (you will find there the Bootstrap 
	library from Twitter). Finally, classes and models go to <em>class/</em>, but you won't find anything right now there :)
	</p>
	
	<h3>Any problems or ideas?</h3>
	
	<p>
	Visit us on <a href="http://core9.googlecode.com">core9.googlecode.com</a> and we will be more than happy to check out your 
	problems or ideas.
	</p>
	
	<p>
	Thanks for your support!
	</p>
</body>
</html>
