<?php 
// whitespace and punctuation constant
$reg = "/([\s.,\%\/\\\(\)\:\?\[\]\"]+)|(<.*?>)/i";

// we need the individual words so we can build a dictionary later
function parse_words($lines) {
	global $reg;  //use the global macro

	$allwords = array();
	foreach ($lines as $line) {
	  $words = preg_split($reg, $line, -1, PREG_SPLIT_NO_EMPTY); //no need to capture the delimiters here
	  foreach ($words as $w) {
	    if (preg_match($reg, $w) == 0) {
	      $allwords[] = $w;
	    }
	  }
	}
	return $allwords;	
}

function build_dictionary($allwords, $from_lang, $to_lang) {
	$dictionary = array();
	$batch = array();
	$len = 0;
	$w = "";
	foreach ($allwords as $w) {
	  if (!array_key_exists($w,$dictionary)) {
	    $batch[] = $w;
	    $len += strlen($w);
	  }
	  // the limit on URL length is 2000, including the api key and a &q= for each word
	  // the maximum batch size is 128, though this appears to be under documented
	  if ($len > 200 || sizeof($batch) > 127) {
	    $dictionary += process_batch($batch, $from_lang, $to_lang);
	    $len = 0;
	    $batch = array();
	  }
	}
	// have to do this again to capture the last batch
	$dictionary += process_batch($batch, $from_lang, $to_lang);
    return $dictionary;
}

function process_batch($batch, $from_lang, $to_lang) {
  $d = array();
  $urlstr = "https://www.googleapis.com/language/translate/v2?"
             ."key=AIzaSyCFJsVSuNWcvMyghuMMQRSXHgrx3AiY0Gc&"
             ."target=".$to_lang."&"
             ."source=".$from_lang;
  foreach ($batch as $b) {
    $urlstr .= "&q=".urlencode($b);
  }
  $json = json_decode(file_get_contents($urlstr), true);
  foreach ($batch as $i => $b) {
    $translation = $json['data']['translations'][$i]['translatedText'];
    $d[$b] = $translation;
  }
  return $d;
}
$areg = "(<[aA].*?>|</[aA]>)";
function render_text($lines) {
	global $reg;
	global $areg;
	foreach ($lines as $line) {
		$words = preg_split($reg, $line, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
		foreach ($words as $w) {   
			if (preg_match($reg, $w) > 0) {     // if this "word" is a string of delimiters (ie punctuation)
				if (!preg_match($areg,$w))
					echo $w;
			} else {
				echo get_trans_display($w);
			}
		}
	}
}

function get_trans_display($w) { //not clear how independent this really is
    return "<span class='word_holder'>".    //CSS magic that does the little fake bubble
           "<span class='trans_word_positioner'>".
             "<span class='trans_word_tip'>▲</span>".
             "<span class='trans_word'>OOPS</span>".
           "</span>".
          "<span class='original_word'>".$w."</span>".
          "</span>";	
}
?>