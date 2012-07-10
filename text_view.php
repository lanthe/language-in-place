<?php
include_once("text_parsing.php"); 
include_once("settings.php");
function text_view() {

	$article = get_source_text();
	$lines = preg_split("/[\r\n]+/",$article->text);
	return "<div class='title_text'>".
		"<div class='title_source'>".$article->source."</div>".
		"<div class='title_article_name'>".$article->title."</div>".
	"</div>".
	"<div class='place_text'>".render_text($lines)."</div>";
}
?>