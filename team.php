<?php
header('Content-type: text/html; charset=utf-8');


include_once("header.php");
include_once("footer.php");

echo get_header();

echo "
<div class='content_area'>
<p>We are a small team of engineers and language enthusiasts bent on changing the way people learn and retain language in their everyday lives.  We have several decades of collective technology and language learning experience on our team, but are always looking to add more.  <a href='mailto:languageinplace@gmail.com'>Email</a> us if you are interested in what we are doing and want to help.  Or if you ever just need someone to talk to. </p>
</div>";

echo get_footer();
?>