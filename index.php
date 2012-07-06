<?php 
header('Content-type: text/html; charset=utf-8');

include_once("settings.php");
include_once("text_parsing.php");
include_once("header.php");
include_once("footer.php");


$wrapped_lines = wordwrap(get_source_text(),150,"\n");
//$wrapped_lines = wordwrap(get_source_text(),105,"\n");
$lines = preg_split("/[\r\n]+/",$wrapped_lines);


//$allwords = parse_words($lines);
//$dictionary = build_dictionary($allwords, from_language(), to_language());
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
<div class='wordlist' style='visibility:hidden;'>
<div class='wordlist_header'>My Wordlist</div>
<div class='wordlist_words'>veille - eve</div>
</div>

<script type='text/javascript'>
$("span.word_holder").click(function() {
  $(this.firstChild).toggle();
});

function add_translations () {
	$.ajax({
	  url: "dictionary.php",
	}).done(function(data) { 
  		$("span.word_holder").each(function () {
    		$(this.firstChild.children[1]).text(data[$(this.children[1]).text()]);
  		});
	});
}
document.onload = add_translations();
</script>

<?php echo get_footer();  ?>