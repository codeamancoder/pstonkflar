<div class="videolar-detay">
	<?=$navi?>
	<h3><?=$video->baslik?></h3>

    <? foreach( preg_split('/,/',$video->ozet) as $a): ?>
	<div class="video">
    	<iframe width="650" height="475" src="//www.youtube-nocookie.com/embed/<?=$a?>?rel=0" frameborder="0" allowfullscreen></iframe>
    </div>
    <? endforeach; ?>
    
	<div> <?=$video->icerik?> </div>
	
	<br><br><span class="tarih"><?=lifos::to_web_date($video->tarih_yayin)?></span><?=share()?><br>
	<a href="?b=main/dialog_arkadasima_gonder&id=<?=$video->id?>" data-toggle="modal" class="btn btn-small"><i class="icon-envelope"></i> Arkadaşıma Gönder</a>
	
	
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/tr_TR/all.js#xfbml=1";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	
	<div class="yorumlar">
		<h4>Yorumlar</h4>
				<div class='fb-comments' data-href='<?php echo "http://www.pistonkafalar.com/".$_SERVER['REQUEST_URI'].""; ?>' data-num-posts='10' data-width='650'></div> 
		</div>
	<br>
	<?=$pager?>
	<br>
		
	<div class="diger_videolar">
		<h4>Diğer <?=$baslik?></h4>
		<ul>
		<?if($digerleri):?>
			<? foreach($digerleri as $diger): ?>
			<li><a href="<?=$diger->link.'-'.$diger->id?>"><?=$diger->baslik?></a></li>			
			<? endforeach;?>
		<?endif;?>
		</ul>
	</div>
	<br>
</div>
<div class="sag_menu_1"><?=$sag_menu?></div>
<div class="span12"></div>