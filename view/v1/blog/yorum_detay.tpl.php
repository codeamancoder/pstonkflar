<div class="span8">
	<?=$navi?>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/tr_TR/all.js#xfbml=1";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<div class="yorumlar">
		<h3>Yorumlar</h3>
		 <div class='fb-comments' data-href='<?php echo "https://www.pistonkafalar.com/".$_SERVER['REQUEST_URI'].""; ?>' data-num-posts='10' data-width='650'></div> 
	</div>
	<br>
	
</div>
<div class="span4"><?=$sag_menu?></div>
<div class="span12"></div>