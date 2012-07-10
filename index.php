<?php 
header('Content-type: text/html; charset=utf-8');
session_start();
include_once("settings.php");
include_once("text_parsing.php");
include_once("header.php");
include_once("footer.php");

$article = get_source_text();
$lines = preg_split("/[\r\n]+/",$article->text);

echo get_header();
?>
<div class='title_text'>
	<div class='title_source'><?php echo $article->source; ?></div>
	<div class='title_article_name'><?php echo $article->title; ?></div>
</div>
<div class='place_text'>
<?php 
  render_text($lines);
?>
</div>
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
}

$(document).ready(function() {
	add_translations();
	add_click_handlers();
});
</script>

<?php echo get_footer();  ?>