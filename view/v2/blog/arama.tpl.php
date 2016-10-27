<main id="main-content" class="col-md-8">
	<?php echo $duyuru; ?>
	<?= $message ?>

	<? if($sayi):?>
		<article class="article-medium">
			<div class="row">
				<div class="col-xs-12">
				<h3>"<?php echo $aranan; ?>" arama sonucunda toplam <strong><?=$sayi?></strong> sonuç bulundu.</h3>
				<ul class="list-group">
					<? foreach($sonuclar as $sonuc):?>
						<li class="list-group-item">
							<a href="/<?=$sonuc->link.'-'.$sonuc->id?>"><?=$sonuc->baslik?></a
						</li>
					<? endforeach; ?>
				</ul>
				<?= $pager ?>
				</div>
			</div>
		</article>
	<? endif ?>

</main><!--#main-content-->

<?= $sag_menu_2 ?>