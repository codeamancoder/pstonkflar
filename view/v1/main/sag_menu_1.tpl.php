<section id="yeni_sag_ust">
    <center class="reklam22" style="background:#eee;">
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Sağ Üst -->
<ins class="adsbygoogle"
     style="display:inline-block;width:300px;height:250px"
     data-ad-client="ca-pub-1034370367466687"
     data-ad-slot="9335707901"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
    </center>
</section>

<? if($reklam_ust_sag) : ?> 
<section id="reklam_ust_sag"><?=$reklam_ust_sag->icerik?></section> 
<? elseif($galeri && 1==2):?>


<section id="sol_ust_galeri">
	<a href="<?=$galeri->link.'-'.$galeri->id?>"><img src="/user/files/<?=$galeri->fotos[0]->id.'.'.$galeri->fotos[0]->uzanti?>"></a>
	<div class="baslik"><?=$galeri->baslik?></div>
</section>


<? endif; ?>
<h4>Çok Okunanlar</h4>
	<div class="tabbable">
	  <ul class="nav nav-tabs">
	    <li class="active"><a href="#pane1" data-toggle="tab">Haberler</a></li>
	    <li><a href="#pane2" data-toggle="tab">Testler</a></li>
	    <li><a href="#pane3" data-toggle="tab">Yenilikler</a></li>
	  </ul>
	  <div class="tab-content">
	    <div id="pane1" class="tab-pane active">
	      <ul>
	      	<? foreach($cok['haber'] as $haber):?>
	      	<li><a href="/<?=$haber->link.'-'.$haber->id?>"><?=lifos::substr($haber->baslik,42,'..')?></a></li>
	      	<? endforeach;?>
	      </ul>
	    </div>
	    <div id="pane2" class="tab-pane">
	      <ul>
	      	<? foreach($cok['test'] as $haber):?>
	      	<li><a href="/<?=$haber->link.'-'.$haber->id?>"><?=$haber->baslik?></a></li>
	      	<? endforeach;?>
	      </ul>
	    </div>
	    <div id="pane3" class="tab-pane">
	      <ul>
	      	<? foreach($cok['yenilik'] as $haber):?>
	      	<li><a href="/<?=$haber->link.'-'.$haber->id?>"><?=$haber->baslik?></a></li>
	      	<? endforeach;?>
	      </ul>
	    </div>

	  </div><!-- /.tab-content -->
	</div><!-- /.tabbable -->
	
	
<section id="genel_yayin">
	<img src="/user/akin.png">
	<a href="<?=$akin_son->link.'-'.$akin_son->id?>"><?=lifos::substr($akin_son->baslik,50,'..')?></a>
</section>

<section id="yazarlar">
	<h4>Yazarlar</h4>
	<? foreach($yazarlar as $yazar):?>
	<div class="yazar">
		<div class="foto"><img src="/user/yazar/<?=$yazar->id?>.jpg"></div>
		<div class="info"><h5><?=$yazar->ad?></h5><a href="<?=$yazar->link.'-'.$yazar->blog_id?>"><?=lifos::substr($yazar->baslik,40)?></a></div>
	</div>
	<? endforeach;?>
</section>