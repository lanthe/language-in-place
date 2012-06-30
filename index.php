<?php 
header('Content-type: text/html; charset=utf-8');
?>

<html>

<head>
    <title> test </title>
    <link rel="stylesheet" type="text/css" href="lip.css">
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.js"></script>
    <meta name="google" value="notranslate">  <!-- don't want chrome's message saying "do you want this page translated" -->
</head>

<body>

<?php

// get the text from a flat file for now
$all_text = file_get_contents("./french.txt");
$lines = preg_split("/[\r\n]+/",$all_text);

// whitespace and punctuation
$reg = "/([\s.,\%\/\\\(\)\:\?\[\]\"]+)/i";

$allwords = array();
foreach ($lines as $line) {
  $words = preg_split($reg, $line, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
  foreach ($words as $w) {
    if (preg_match($reg, $w) == 0) {
      $allwords[] = $w;
    }
  }
}

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
    $dictionary += process_batch($batch);
    $len = 0;
    $batch = array();
  }
}
// have to do this again to capture the last batch
$dictionary += process_batch($batch);

function process_batch($batch) {
  $d = array();
  $urlstr = "https://www.googleapis.com/language/translate/v2?key=AIzaSyCFJsVSuNWcvMyghuMMQRSXHgrx3AiY0Gc&target=en&source=fr";
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

foreach ($lines as $line) {
  $words = preg_split($reg, $line, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

  foreach ($words as $w) {
    if (preg_match($reg, $w) > 0) {
      echo "<span class='a'>".$w."</span>";
    } else {
      $trans = $dictionary[$w];
      if (!$trans) $trans = "OOPS"; // the word wasn't in the dictionary for some reason
      // the B contains the real word, the C contains two D's and a <br>
      echo "<span class='b'>".    //CSS magic that does the little fake bubble
             "<span class='c'>".
               "<span class='d'>^</span>".
               "<br>".
               "<span class='d'>(<u>".$trans."</u>)</span>".
             "</span>"
            .$w.
            "</span>";
    }
  }

  echo "<div style='height:2.5em;'> </div><HR>\n";
}

?>
<script type='text/javascript'>
<?php
  echo "var dict = ".json_encode($dictionary).";\n";
?>
$("span.b").click(function() {
  $(this).children().toggle();
});
</script>

</body>

</html>