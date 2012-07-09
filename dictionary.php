<?php 
header('Content-type: json; charset=utf-8');

include_once("settings.php");
include_once("text_parsing.php");

$article = get_source_text();
$lines = preg_split("/[\r\n]+/",$article->text);


$allwords = parse_words($lines);
$dictionary = build_dictionary($allwords, from_language(), to_language());

echo json_encode($dictionary);
?>