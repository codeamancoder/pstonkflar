<main id="main-content" class="col-md-8">
	<?php echo $duyuru; ?>
	<!-- ADS WIDGET -->
	<?=$message?>
	<section class="widget">
		<!-- Widget Content -->
		<div class="frame thick">
			<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			<!-- Haber Detay Üst - Yatay -->
			<ins class="adsbygoogle"
				 style="display:block"
				 data-ad-client="ca-pub-1034370367466687"
				 data-ad-slot="7360504306"
				 data-ad-format="auto"></ins>
			<script>
				(adsbygoogle = window.adsbygoogle || []).push({});
			</script>
		</div>
		<img src="<?php echo get_asset('shadow.png'); ?>" alt="shadow" class="shadow">
	</section>

<!--	--><?//=$navi?>
<!--	<h3>--><?//=$baslik?><!--</h3>-->

	<? foreach($haberler as $blog):?>
	<article class="article-medium">
		<div class="row">
			<!--Image-->
			<div class="col-sm-6">
				<div class="frame">
					<a class="image" href="/<?=$blog->link.'-'.$blog->id?>">
						<figure class="image-holder">
							<img src="/user/files/wrap_<?=$blog->foto?>" alt="<?=$blog->baslik?>">
						</figure>
						<div class="image-light"></div>
						<span class="dashicons dashicons-format-gallery"></span>
					</a>
				</div>
				<img src="<?php echo get_asset('shadow.png'); ?>" class="shadow" alt="shadow">
			</div>

			<!--Content-->
			<div class="col-sm-6">
				<h4><a href="/<?=$blog->link.'-'.$blog->id?>"><?=$blog->baslik?></a></h4>
				<p class="post-meta">
					<a href="#"><span class="fa fa-clock-o"></span> <?php echo lifos::to_web_date($blog->tarih_yayin); ?></a> &nbsp;
					<a href="#"><span class="fa fa-folder"></span> <?php echo $blog->tip; ?></a> &nbsp;
					<a href="#"><span class="fa fa-eye"></span> <?php echo $blog->hit; ?></a>
				</p>
				<p>
					<?php echo $blog->ozet; ?>
				</p>
			</div>
		</div>

		<!--Footer-->
		<?php $etiketler = get_etiket($blog); ?>
		<div class="footer">
			<?php if($etiketler): ?>
			<ul class="tags">
				<?php foreach($etiketler as $etiket): ?>
					<li><a href="/etiket/<?=$etiket->tag?>"><?=$etiket->tag?></a></li>
				<?php endforeach; ?>
			</ul>
			<?php endif; ?>
			<div class="read-more">
				<a href="<?=$blog->link.'-'.$blog->id?>"><button class="btn btn-primary btn-sm">Devamını Oku</button></a>
			</div>
		</div>
	</article>
	<? endforeach;?>


	<?=$pager?>

</main><!--#main-content-->

<?=$sag_menu_2?>