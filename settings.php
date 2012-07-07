<?php
class Article
{

  public $title;
  public $text;
  public $source;

  public function __construct($title = "", $text = "", $source = "")
  {
    $this->text = $text;
    $this->title = $title;
    $this->source = $source;
  }
}

function from_language() {
	// TODO: based on the URL, choose which language to translate from
	return "fr";
}

function to_language() {
	// TODO: based on browser and cookie settings, choose which language to translate to
	return "en";
}

function get_source_text() {

//	return file_get_contents("./french2.txt");
    $article_xml = new SimpleXMLElement(file_get_contents("http://fulltextrssfeed.com/blogs.france24.com/blog_feed.rss/fr"));
    $article_text = strip_tags($article_xml->channel->item[0]->description);
	$article_title = $article_xml->channel->item[0]->title;
	$article_source = "France 24";
	//handle HTML tags 
	// TODO keep formatting for strong and em
	// TODO support in-article images somehow
	//$bad_tags = array("</div>", "<div>", "<p>","</p>","<strong>","</strong>","<em>","</em>");
	//$carriage_returns = array("<br/>","<br>");
	//$article_text = str_replace($bad_tags, "", $article_text);
	//$article_text = str_replace($carriage_returns,"\n",$article_text);
    return new Article($article_title,$article_text,$article_source);    
}




?>