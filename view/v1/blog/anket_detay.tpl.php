<?=$navi?>
<div class="haberler-detay">
<?=$message?>
	<h3><?=$blog->baslik?></h3>
	
	<table class="oran">
	<? foreach($blog->icerik as $o): ?>
	<tr><td><?=$o[0]?></td><td><?=$o[2]?> %</td><td><div class="progress"> 
		<div class="bar" style="width: <?=$o[2]?>%;"></div> </div>
		
		</td><td><?=$o[1]?> oy</td></tr>
	<? endforeach;?>
	</table>
	<br>
	<p>Toplam <?=$blog->toplam|0?> oy kullanıldı.</p>
	<br>
	
	<a href="?b=main/dialog_arkadasima_gonder&id=<?=$blog->id?>" data-toggle="modal" class="btn btn-small"><i class="icon-envelope"></i> Arkadaşıma Gönder</a>

	<br><br><span class="tarih"><?=lifos::to_web_date($blog->tarih_yayin)?></span><?=share()?><br>
	<br>	
	<div class="diger_haberler">
		<h4>Diğer Anketler</h4>
		<ul>
		<?if($digerleri):?>
			<? foreach($digerleri as $diger): ?>
			<li><a href="<?=$diger->link.'-'.$diger->id?>"><?=$diger->baslik?></a></li>			
			<? endforeach;?>
		<?endif;?>
		</ul>
	</div>

</div>
<div class="sag_menu_1">
	<?=$sag_menu?>
</div>
<div class="span12"></div>