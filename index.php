<?php 
header('Content-type: text/html; charset=utf-8');

include_once("text_parsing.php");
include_once("header.php");
include_once("footer.php");

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
	return file_get_contents("./french2.txt");
}

// TODO we probably want our own line wrapping or sentence parsing
$lines = preg_split("/[\r\n]+/",get_source_text());

$allwords = parse_words($lines);
$dictionary = build_dictionary($allwords, from_language(), to_language());
echo get_header();
?>
<div class='title_text'>
	<div class='title_source'>Le Monde</div>
	<div class='title_article_name'>Pacte de croissance : Merkel fait état de 'progrès significatifs'</div>
</div>
<div class='place_text'>
<?php 
  render_text($lines, $dictionary);
?>
</div>
<div class='wordlist'>
<div class='wordlist_header'>My Wordlist</div>
<div class='wordlist_words'>veille - eve</div>
</div>

<script type='text/javascript'>
<?php
  echo "var dict = ".json_encode($dictionary).";\n";
?>
$("span.original_word").click(function() {
  $(this).children().toggle();
});
</script>

<?php echo get_footer();  ?>