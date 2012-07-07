<?php 
header('Content-type: json; charset=utf-8');

include_once("settings.php");
include_once("text_parsing.php");

$article = get_source_text();
$wrapped_lines = wordwrap($article->text,105,"\n");
$lines = preg_split("/[\r\n]+/",$wrapped_lines);


$allwords = parse_words($lines);
$dictionary = build_dictionary($allwords, from_language(), to_language());

echo json_encode($dictionary);
?>