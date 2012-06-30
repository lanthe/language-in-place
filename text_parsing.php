<?php 
// whitespace and punctuation constant
$reg = "/([\s.,\%\/\\\(\)\:\?\[\]\"]+)/i";


// we need the individual words so we can build a dictionary later
function parse_words($lines) {
	global $reg;  //use the global macro

	$allwords = array();
	foreach ($lines as $line) {
	  $words = preg_split($reg, $line, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
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
	foreach ($allwords as $w) {
	  if (!array_key_exists($dictionary, $w)) {
	    $batch[] = $w;
	    $len += strlen($w);
	  }
	  // the limit on URL length is 2000, including the api key and a &q= for each word
	  // the maximum batch size is 128, though this appears to be under documented
	  if ($len > 1500 || sizeof($batch) > 127) {
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

function render_text($lines, $dictionary) {
	global $reg;
	foreach ($lines as $line) {
		$words = preg_split($reg, $line, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
		foreach ($words as $w) {   
			if (preg_match($reg, $w) > 0) {     // if this "word" is a string of delimiters (ie punctuation)
			    echo "<span class='delimiter'>".$w."</span>";     // just print the delimiter string
			} else {
				$trans = $dictionary[$w];
				if (!$trans) $trans = "OOPS"; // the word wasn't in the dictionary for some reason
				echo get_trans_display($w, $trans);
			}
		}
		echo "<div style='height:2.5em;'> </div><HR>\n";   // makes space between the lines for the floating trans bubbles
	}
}

function get_trans_display($w, $trans) { //not clear how independent this really is
    return "<span class='original_word'>".    //CSS magic that does the little fake bubble
           "<span class='trans_word_positioner'>".
             "<span class='trans_word_tip' >▲</span>".
             "<span class='trans_word'>".$trans."</span>".
           "</span>"
          .$w.
          "</span>";	
}
?>