<div class="galeriler-detay">
	<?=$navi?>
	<h3><?=$blog->baslik?></h3>
	

	<div class="row-fluid">
		<? foreach($blog->fotolar as $foto):?>
		<div class="galeridetay">
			<a href="/user/files/<?=$foto->id.'.'.$foto->uzanti?>" rel="galeri" class="box"><img src="/user/files/wrap_<?=$foto->id.'.'.$foto->uzanti?>"></a>
		</div>
		<? endforeach; ?>
	</div>
	
	<br>
	<div class="info"> <?=$blog->icerik?> </div>
	
	<br><br><span class="tarih"><?=lifos::to_web_date($blog->tarih_yayin)?></span><?=share()?><br>
	
	<script src="/static/lib/fancybox/jquery.fancybox.pack.js"></script>
	<script>
		$(document).ready(function(){
			$(".box").fancybox({
				openEffect	: 'none',
				closeEffect	: 'none'
			});
		});
	</script>
	
	<br>
	<a href="?b=main/dialog_arkadasima_gonder&id=<?=$blog->id?>" data-toggle="modal" class="btn btn-small"><i class="icon-envelope"></i> Arkadaşıma Gönder</a>

    <? if( $blog->video ): ?>
        <br>
        <h4>Video</h4>
        <? foreach( preg_split('/,/',$blog->video) as $a): ?>
            <div class="video">
                <iframe width="650" height="475" src="//www.youtube-nocookie.com/embed/<?=$a?>?rel=0" frameborder="0" allowfullscreen></iframe>
            </div>
        <? endforeach; ?>
    <? endif; ?>

    <br>
	
	
	
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
	<?=$pager?>
	<br>
		
	<div class="diger_videolar">
		<h4>Diğer Galeriler</h4>
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