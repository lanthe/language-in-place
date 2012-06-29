<?php 
header('Content-type: text/html; charset=utf-8');
?>

<html>

<head>
    <title> test </title>
    <link rel="stylesheet" type="text/css" href="lip.css">
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.js"></script>
</head>

<body>

<?php
  echo 'a';
// get the text from a flat file for now
$all_text = file_get_contents("./french.txt");
$lines = preg_split("/[\r\n]+/",$all_text);

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
    echo $w;
  }
  if ($len > 200) {
    process_batch($batch);
    $len = 0;
    $batch = array();
  }
}
process_batch($batch);

function process_batch($batch) {
  $urlstr = "https://www.googleapis.com/language/translate/v2?key=AIzaSyCFJsVSuNWcvMyghuMMQRSXHgrx3AiY0Gc&target=en&source=fr";
  foreach ($batch as $b) {
    $urlstr .= "&q=".urlencode($b);
  }
  $json = json_decode(file_get_contents($urlstr), true);
  foreach ($batch as $i => $b) {
    $translation = $json['data']['translations'][$i]['translatedText'];
    echo $translation . "<br>";
    $dictionary[$b] = $translation;
    var_dump($dictionary);
  }
}

var_dump($dictionary);

  /*foreach ($lines as $line) {
  $words = preg_split($reg, $line, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

  foreach ($words as $w) {
    if (preg_match($reg, $w) > 0) {
      echo "<span class='a'>".$w."</span>";
    } else {
      if (!array_key_exists($dictionary, $w)) {
	$dictionary[$w] = trans($w);
	$trans = $dictionary[$w];
      }
      echo "<span class='b'>".
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

function trans($x) {
  //$j = json_decode(
  //  var_dump($j);
  //return $j['data']['translations'][0]['translatedText'];
  return "x";
}

?>
<script type='text/javascript'>
<?php
  //echo "var dict = ".json_encode($dictionary).";\n";
?>
$("span.b").click(function() {
  $(this).children().toggle();
});
</script>

</body>

</html>
*/