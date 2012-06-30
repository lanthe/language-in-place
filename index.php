<?php 
header('Content-type: text/html; charset=utf-8');
?>

<html>

<head>
    <title> test </title>
    <link rel="stylesheet" type="text/css" href="lip.css">
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.js"></script>
    <meta name="google" value="notranslate">  <!-- don't want chrome's message saying "do you want this page translated" -->
</head>

<body>

<?php
include_once("text_parsing.php");

function from_language() {
	// TODO: based on the URL, choose which language to translate from
	return "fr";
}

function to_language() {
	// TODO: based on browser and cookie settings, choose which language to translate to
	return "en";
}

function get_source_text() {
	// TODO
	return file_get_contents("./french.txt");
}

// TODO we probably want our own line wrapping or sentence parsing
$lines = preg_split("/[\r\n]+/",get_source_text());

$allwords = parse_words($lines);
$dictionary = build_dictionary($allwords, from_language(), to_language());
render_text($lines, $dictionary);


?>
<script type='text/javascript'>
<?php
  echo "var dict = ".json_encode($dictionary).";\n";
?>
$("span.original_word").click(function() {
  $(this).children().toggle();
});
</script>

</body>

</html>