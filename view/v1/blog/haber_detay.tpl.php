
<div class="haberler-detay">
	<?=$navi?>
	<h3><?=$blog->baslik?></h3>
	<p><?=$blog->ozet?></p>
	
	<? if($foto):?> <img src="/user/files/<?=$foto->id.'.'.$foto->uzanti?>"><br><br> <? endif; ?>
	
	<div> 
		<? if($blog->kategori==2):?>
		<? $test = unserialize($blog->test);?>
		<div class="testler">
			<table>
				<tr><th>Model</th><td><?=$test['model']?></td></tr>
				<tr><th>Motor</th><td><?=$test['motor']?></td></tr>
				<tr><th>Şanzıman</th><td><?=$test['sanziman']?></td></tr>
				<tr><th>Güç</th><td><?=$test['guc']?></td></tr>
				<tr><th>Tork</th><td><?=$test['tork']?></td></tr>
				<tr><th>0-100</th><td><?=$test['100']?></td></tr>
				<tr><th>Maksimum Hız</th><td><?=$test['hiz']?></td></tr>
				<tr><th>Ortalama Tüketim</th><td><?=$test['ort']?></td></tr>
				<tr><th>Bagaj Hacmi</th><td><?=$test['bagaj']?></td></tr>
				<tr><th>Ağırlık</th><td><?=$test['agirlik']?></td></tr>
				<tr><th><img src="/static/v1/img/ok.png"></th><td><?=$test['arti']?></td></tr>
				<tr><th><img src="/static/v1/img/nok.png"></th><td><?=$test['eksi']?></td></tr>
				<tr><th>PistonKafalar Skor</th><td><?=lifos::star_rating($test['rating'],false)?></td></tr>
			</table>
		</div>
		<? endif;?>
		<?=$blog->icerik?> 
		<br><br>
		<span class="tarih"><?=lifos::to_web_date($blog->tarih_yayin)?></span>
		<?=share()?>
	</div>
	
	<center class="yeni_haber_alt">
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Haber Detay Alt -->
<ins class="adsbygoogle"
     style="display:inline-block;width:468px;height:60px"
     data-ad-client="ca-pub-1034370367466687"
     data-ad-slot="1672840300"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
	</center>
	
	<? if(count($blog->fotolar)>1): ?>
	<h4>Fotoğraflar</h4>
	<div class="row-fluid">
		<? foreach($blog->fotolar as $foto):?>
		<div class="galeridetay">
			<a href="/user/files/<?=$foto->id.'.'.$foto->uzanti?>" rel="galeri" class="box"><img src="/user/files/wrap_<?=$foto->id.'.'.$foto->uzanti?>"></a>
		</div>
		<? endforeach; ?>
	</div>
	<script src="/static/lib/fancybox/jquery.fancybox.pack.js"></script>
	<script>
		$(document).ready(function(){
			$(".box").fancybox({
				openEffect	: 'none',
				closeEffect	: 'none'
			});
		});
	</script>
	<? endif; ?>
	
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
	
	<a href="?b=main/dialog_arkadasima_gonder&id=<?=$blog->id?>" data-toggle="modal" class="btn btn-small"><i class="icon-envelope"></i> Arkadaşıma Gönder</a>

	<div id="fb-root"></div>
	
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
		
	<div class="diger_haberler">
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

	<?if($etiketler):?>
	<div class="etiketler">
		<? foreach($etiketler as $etiket): ?>
			<a href="/etiket/<?=$etiket->tag?>"><span class="label"><?=$etiket->tag?></span></a>	
		<? endforeach;?>
	</div>
	<?endif;?>
	<br>
	Bu sayfa toplam <strong><?=$blog->hit?></strong> kez okundu.
</div>
<div class="sag_menu_1">
	<?=$sag_menu?>
</div>
<div class="span12"></div>