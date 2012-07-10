<?php 
header('Content-type: text/html; charset=utf-8');
session_start();
include_once("settings.php");
include_once("text_parsing.php");
include_once("header.php");
include_once("footer.php");
include_once("text_view.php");
$article_plus_one = article_num()+1;
$article_minus_one = article_num()-1;
echo get_header();  
echo "<button class='change_article_button' id='prev_button'>Prev</button>";
echo text_view_titles();
echo "<button class='change_article_button' id='next_button'>Next</button>";
echo text_view();
?>
<div class='wordlist' style='visibility:hidden;'>
<div class='wordlist_header'>My Wordlist</div>
<div class='wordlist_words'>veille - eve</div>
</div>
<div class='overlay'>
	<div "overlay_item">
		To learn other languages, try out our partner sites:<br>
		<a href="http://spanishinplace.com">Spanish in Place</a><br>
		<a href="http://italianinplace.com">Italian in Place</a><br>
		<a href="http://germaninplace.com">German in Place</a><br>
		<a href="http://frenchinplace.com">French in Place</a><br>		
	</div>
	<hr>
	<div "overlay_item">
	  <span class="overlay_text">What language should I translate to?</span>
	  <select id="to_lang"> 
	    <option value="en">English</option>
	    <option value="es">Spanish</option>
	    <option value="it">Italian</option>
	    <option value="fr">French</option>
	    <option value="de">German</option>
	  </select>
	</div>
	<br/>
	<div id="change_lang_button" class="overlay_go_button">Change</div>
</div>
<div class='overlay_background'></div>
<script type='text/javascript'>


function add_translations () {
	$.ajax({
	  url: "dictionary.php",
	  data: "num=" + <?php echo article_num(); ?>,
	}).done(function(dictionary) { 
  		$("span.word_holder").each(function () {
    		$(this.firstChild.children[1]).text(dictionary[$(this.children[1]).text()]);
  		});
	});
}

function add_click_handlers() {
	$("span.word_holder").click(function() {
	  $(this.firstChild).toggle();
	});
	$('#change_language').click(function() {
	  $('div.overlay_background').toggle();
	  $('div.overlay').toggle();
	});

	$('#change_lang_button').click(function() {  //TODO: make all the bubbles spinnies until this loads
	  $('div.overlay_background').toggle();
	  $('div.overlay').toggle();
	  $.ajax({
	    url: 'change_language.php?new_language=' + $("#to_lang option:selected").val(),
	    }).done(function(data) { 
  		  add_translations();
	    });
	});	

    <?php echo "var artnum = ".strval(article_num()).";"; ?>
	
	$('#prev_button').click(function () {
		var newnum = artnum -1;
		document.location.href = "?num=" + newnum;
	});
	$('#next_button').click(function() {
		var newnum = artnum +1;
		document.location.href ="?num=" + newnum;		
	});
	
	if (artnum == 0)
	  $('#prev_button').hide();
	if (artnum == 3)
	  $('#next_button').hide();
	
}

$(document).ready(function() {
	add_click_handlers();
	add_translations();
});
</script>

<?php echo get_footer();  ?>