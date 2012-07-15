<?php
header('Content-type: text/html; charset=utf-8');


include_once("header.php");
include_once("footer.php");

echo get_header();

echo "
<div class='content_area'>
<p>Features for teachers:</p>
<li>Get a unique webpage that you can send to your students.</li>
<li>Upload or send us your own text for your students to read.</li>
<li>Input your own definitions for words & phrases.</li>
<li>See which students read the text, and what words students needed help with</li>
<br>
<p>If you'd like to try Language In Place in your classroom, please <a href='mailto:languageinplace@gmail.com'>contact us</a>.</p>
</div>";

echo get_footer();
?>