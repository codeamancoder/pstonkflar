<div class="haberler-liste">
<?=$navi?>
<br>
<?=$message?>


<? if($sayi):?>
	Arama sonucunda toplam <strong><?=$sayi?></strong> sonuç bulundu.<br><br>

	<ul>
	<? foreach($sonuclar as $sonuc):?>
		<li><a href="/<?=$sonuc->link.'-'.$sonuc->id?>"><?=$sonuc->baslik?></a></li>		
	<? endforeach;?>
	</ul>
	
<? endif ?>
</div>
<div class="sag_menu_1">
	<?=$sag_menu?>
</div>