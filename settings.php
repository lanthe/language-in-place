<?php
class Article
{

  public $title;
  public $text;
  public $source;

  public function __construct($title = "", $text = "", $source = "Newspaper")
  {
    $this->text = $text;
    $this->title = $title;
    $this->source = $source;
  }
}

function page_name() {
    switch ($_SERVER["SERVER_NAME"]) {
	    case "spanishinplace.com":
			return "Spanish in Place";
		case "italianinplace.com":
			return "Italian in Place";
		case "germaninplace.com":
			return "German in Place";
		case "localhost":
		case "frenchinplace.com":
		default:
			return "French in Place";	
	}
}

function from_language() {
    switch ($_SERVER["SERVER_NAME"]) {
		case "localhost":
	    case "spanishinplace.com":
			return "es";
		case "italianinplace.com":
			return "it";
		case "germaninplace.com":
			return "de";
		case "frenchinplace.com":
		default:
			return "fr";
	}
}

function to_language() {
	session_start();
	if(array_key_exists('to_lang', $_SESSION) == False)
	  $_SESSION["to_lang"] = "en";
	return $_SESSION["to_lang"];
}

function get_source_text() {
    switch ($_SERVER["SERVER_NAME"]) {
		case "localhost":
	    case "spanishinplace.com":
			$rss_url = "http://fulltextrssfeed.com/www.eluniversal.com.mx/rss/mundo.xml";
			$article_source = "El Mundo";
			break;
	    case "italianinplace.com":
			$rss_url = "http://fulltextrssfeed.com/lastampa.feedsportal.com/c/32418/f/637885/index.rss";
			$article_source = "La Stampa";
			break;
		case "germaninplace.com":
			$rss_url = "http://fulltextrssfeed.com/newsfeed.zeit.de/index";
			$article_source = "Zeit Online";
			break;
		case "frenchinplace.com":
		default:
			$rss_url = "http://fulltextrssfeed.com/blogs.france24.com/blog_feed.rss/fr";
			$article_source = "France 24";
			break;
	}

//	return file_get_contents("./french2.txt");
    $article_xml = new SimpleXMLElement(file_get_contents($rss_url));
    $article_text = $article_xml->channel->item[0]->description;
	$article_title = $article_xml->channel->item[0]->title;
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