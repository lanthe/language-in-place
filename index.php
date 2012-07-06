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

	return file_get_contents("./french2.txt");
/*    $article_xml = new SimpleXMLElement(file_get_contents("http://fulltextrssfeed.com/blogs.france24.com/blog_feed.rss/fr"));
    $article_text = $article_xml->channel->item[0]->description;

	//handle HTML tags 
	// TODO keep formatting for strong and em
	// TODO support in-article images somehow
	$bad_tags = array("</div>", "<div>", "<p>","</p>","<strong>","</strong>","<em>","</em>");
	$carriage_returns = array("<br/>","<br>");
	$article_text = str_replace($bad_tags, "", $article_text);
	$article_text = str_replace($carriage_returns,"\n",$article_text);

    return $article_text; */
    
}


$wrapped_lines = wordwrap(get_source_text(),105,"\n");
$lines = preg_split("/[\r\n]+/",$wrapped_lines);


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

function add_translations () {
  $("span.original_word").each(function () {
    $(this.firstChild.children[1]).text(dict[this.innerText]);
  });
}
document.onload = add_translations();
</script>

<?php echo get_footer();  ?>