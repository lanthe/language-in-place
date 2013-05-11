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

function page_type() {
	return from_language();
}

function page_name() {
    switch (page_type()) {
	    case "es":
			return "Spanish in Place";
		case "it":
			return "Italian in Place";
		case "de":
			return "German in Place";
        case "hi":
            return "Hindi in Place";
		case "fr":
		default:
			return "French in Place";	
	}
}

function from_language() {
    switch ($_SERVER["SERVER_NAME"]) {
	    case "spanishinplace.com":
			return "es";
		case "italianinplace.com":
			return "it";
		case "germaninplace.com":
			return "de";
		case "frenchinplace.com":
			return "fr";
        case "localhost":
        default:
        case "hindiinplace.com":
            return "hi";
	}
}

function to_language() {
	session_start();
	if(array_key_exists('to_lang', $_SESSION) == False)
	  $_SESSION["to_lang"] = "en";
	return $_SESSION["to_lang"];
}

function get_source_text() {
    switch (page_type()) {
	    case "es":
			$rss_url = "http://fulltextrssfeed.com/www.eluniversal.com.mx/rss/mundo.xml";
			$article_source = "El Mundo";
			break;
	    case "it":
			$rss_url = "http://fulltextrssfeed.com/lastampa.feedsportal.com/c/32418/f/637885/index.rss";
			$article_source = "La Stampa";
			break;
		case "de":
			$rss_url = "http://fulltextrssfeed.com/newsfeed.zeit.de/index";
			$article_source = "Zeit Online";
			break;
		case "fr":
			$rss_url = "http://fulltextrssfeed.com/rss.leparisien.fr/leparisien/rss/actualites-a-la-une.xml";
			$article_source = "Le Parisien";
			break;
        case "hi":
            $rss_url = "http://fulltextrssfeed.com/rss.jagran.com/local/uttar-pradesh/kanpur-city.xml";
            $rss_url = "http://fulltextrssfeed.com/feeds.bbc.co.uk/hindi/index.xml";
            $article_source = "BBC Hindi Feed";
            break;
	}

    //unfortunately, fulltextrssfeed sometimes throws PHP warnings and breaks everything
    $stuff = file_get_contents($rss_url);
    $stuff = substr($stuff,strpos($stuff,"<?xml"));
    $stuff = substr($stuff,0,strpos($stuff,"</rss>")+6);

    $article_xml = new SimpleXMLElement($stuff);
    $article_text = $article_xml->channel->item[article_num()]->description;
	$article_title = $article_xml->channel->item[article_num()]->title;
	//handle HTML tags 
	// TODO keep formatting for strong and em
	// TODO support in-article images somehow
	//$bad_tags = array("</div>", "<div>", "<p>","</p>","<strong>","</strong>","<em>","</em>");
	//$carriage_returns = array("<br/>","<br>");
	//$article_text = str_replace($bad_tags, "", $article_text);
	//$article_text = str_replace($carriage_returns,"\n",$article_text);
    return new Article($article_title,$article_text,$article_source);
}

function article_num() {
	if (array_key_exists("num",$_REQUEST) and intval($_REQUEST["num"]) >= 0 and intval($_REQUEST["num"]) < 5)
	  $item_num = intval($_REQUEST["num"]);
    else
      $item_num = 0;
    return $item_num;	
}


?>