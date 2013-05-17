<?php
include_once("settings.php");
function get_header() {
  return "
 	<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 
Transitional//EN\">
	<html lang='en'>

	<head>
	    <title>".page_name()."</title>
		<link rel='icon' 
		      type='image/png' 
		      href='imgs/favicon.png'>
	    <link rel='stylesheet' type='text/css' href='lip.css'>
	    <link rel='stylesheet' type='text/css' href='flags.css'>	    
	    <script type='text/javascript' src='http://code.jquery.com/jquery-1.7.2.js'></script>
	    <meta name='google' value='notranslate'>  <!-- don't want chrome's message saying 'do you want this page translated' -->
	    <meta http-equiv='Content-Language' content='en_US' /> 


	</head>

	<body>


<script type='text/javascript'>
  var uvOptions = {};
  (function() {
    var uv = document.createElement('script'); uv.type = 'text/javascript'; uv.async = true;
    uv.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'widget.uservoice.com/x2Lggvetla8c7O2nniKk8w.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(uv, s);
  })();
</script>	

    <div class='center_column'>

    <div class='header'>
	      <a href='/'><img class='header_logo' src='imgs/lip-logo.png'></img></a>
		  <div id='change_language' class='header_link'>Change Language</div>
		  <div class='header_link'><a class='header_link' href='for_teachers.php'>For Teachers</a></div>
    </div>
";
}
?>
