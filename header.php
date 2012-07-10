<?php
include_once("settings.php");
function get_header() {
  return "
	<html lang='en'>

	<head>
	    <title>".page_name()."</title>
		<link rel='icon' 
		      type='image/png' 
		      href='favicon.png'>
	    <link rel='stylesheet' type='text/css' href='lip.css'>
	    <link rel='stylesheet' type='text/css' href='flags.css'>	    
	    <script type='text/javascript' src='http://code.jquery.com/jquery-1.7.2.js'></script>
	    <meta name='google' value='notranslate'>  <!-- don't want chrome's message saying 'do you want this page translated' -->
	    <meta http-equiv='Content-Language' content='en_US' /> 
		<script type='text/javascript'>

		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-33201912-1']);
		  _gaq.push(['_setDomainName', 'languageinplace.com']);
		  _gaq.push(['_setAllowLinker', true]);
		  _gaq.push(['_trackPageview']);

		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();

		</script>
	</head>

	<body>
    <div class='center_column'>

    <div class='header'>
	      <img class='header_logo' src='lip-logo.png'></img>
		  <a class='header_link' href='not-implemented.php'>Login</a>
		  <div id='change_language' class='header_link'>
		    <img src='' class='flag flag-us'/> &nbsp;to&nbsp; 
		    <img src='' class='flag flag-fr'/>
		  </div>	
    </div>
";
}
?>