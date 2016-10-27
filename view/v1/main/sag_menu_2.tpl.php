<section id="yeni_sag_orta">
    <center class="reklam22" style="background:#eee;">
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- Sağ Orta -->
        <ins class="adsbygoogle"
             style="display:inline-block;width:300px;height:250px"
             data-ad-client="ca-pub-1034370367466687"
             data-ad-slot="9196107108"></ins>
        <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </center>

</section>
<section id="galeriler">
	<h4>SON EKLENEN 2.EL İLANLAR</h4>
	<div class="ilan-ana-sag">
	<? foreach($ilanlar as $ilan):?>
	<div class="ilan2">
		<div class="foto"><a href="/ilan/<?=$ilan->link.'-'.$ilan->ilan_id?>"><img src="/user/files/<?=$ilan->img?>"></a></div>
		<div class="baslik">
			<a href="/ilan/<?=$ilan->link.'-'.$ilan->ilan_id?>"><?=lifos::substr($ilan->baslik,60,'...')?></a><br>
			<span><?=$ilan->guzel_kategori?></span>
		</div>
	</div>
	<? endforeach;?>
	</div>
</section>
<? if($reklam_ust_sag2) : ?> 
<section id="reklam_ust_sag"><?=$reklam_ust_sag2->icerik?></section> 
<? elseif($galeri2):?>
<section id="sol_ust_galeri">
	<a href="<?=$galeri2->link.'-'.$galeri2->id?>"><img src="/user/files/<?=$galeri2->fotos[0]->id.'.'.$galeri2->fotos[0]->uzanti?>"></a>
	<div class="baslik"><?=$galeri2->baslik?></div>
</section>
<? endif; ?>
<section id="galeriler">
	<h4>PİSTON KAFALAR GALERİ<a href="/index.php?b=blog/galeriler/piston" style="margin-right:-2px;">Tümü →</a></h4>
	<div class="galeri-blok">
	<? foreach($galeriler['bizden'] as $galeri):?>
	<div class="galeri">
		<a href="<?=$galeri->link.'-'.$galeri->blog_id?>"><img src="/user/files/<?=$galeri->id.'.'.$galeri->uzanti?>"></a>
		<div class="baslik">
			<a href="<?=$galeri->link.'-'.$galeri->blog_id?>"><?=$galeri->blog_baslik?></a>
		</div>
	</div>
	<? endforeach;?>
	</div>
	
</section>

<? if($anket): ?>
<section id="anket">
	<form method="post" action="<?=$anket->link.'-'.$anket->id?>">
	<h4>PİSTON ANKET</h4>
	<h6><?=$anket->baslik?></h6>
	<ul>
		<? foreach($anket->icerik as $i=>$a):?>
		<li><label><input type="radio" name="oy" value="<?=$i?>"> <?=$a[0]?></label></li>
		<? endforeach;?>
	</ul>
	<input type="hidden" name="id" value="<?=$anket->id?>">
	<input type="submit" name="btnOyKullan" value="Oy Kullan" class="btn">
	</form>
</section>
<? endif; ?>

<section id="galeriler">
	<h4>ÜYE GALERİ<a href="/index.php?b=blog/galeriler/uye" style="margin-right:-2px;">Diğer Galeriler →</a></h4>
	<div class="galeri-blok">
	<? foreach($galeriler['sizden'] as $galeri):?>
	<div class="galeri">
		<a href="<?=$galeri->link.'-'.$galeri->blog_id?>"><img src="/user/files/<?=$galeri->id.'.'.$galeri->uzanti?>"></a>
		<div class="baslik">
			<a href="<?=$galeri->link.'-'.$galeri->blog_id?>"><?=$galeri->blog_baslik?></a>
		</div>
	</div>
	<? endforeach;?>
	</div>
</section>