<?php
function get_header() {

  return "
	<html lang='en'>

	<head>
	    <title> test </title>
	    <link rel='stylesheet' type='text/css' href='lip.css'>
	    <script type='text/javascript' src='http://code.jquery.com/jquery-1.7.2.js'></script>
	    <meta name='google' value='notranslate'>  <!-- don't want chrome's message saying 'do you want this page translated' -->
	    <meta http-equiv='Content-Language' content='en_US' /> 
	</head>

	<body>


<div class='header'>
		<a href='/'>
			<img class='header_logo' src='logo2.png'></img>
		</a>
		<a class='header_link' href='not-implemented.php'>Login</a>
		<a class='header_link' href='not-implemented.php'>French to English</a>		
	<div class='change_language_button'></div>
</div>";
}
?>