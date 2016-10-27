<!-- MAIN CONTENT
                                      ================= -->
<main id="main-content" class="col-md-8">

	<?php echo $duyuru; ?>

	<!-- POST CONTENT -->
	<article class="article-large hentry">

		<header class="show">
			<h1 class="entry-title"><?=$video->baslik; ?></h1>
		</header>

		<div class="entry-content">
			<div class="row">
				<? foreach( preg_split('/,/',$video->ozet) as $a): ?>
					<div class="col-xs-12" style="margin-bottom: 5px;">
						<iframe width="650" height="475" src="//www.youtube-nocookie.com/embed/<?=$a?>?rel=0" frameborder="0" allowfullscreen></iframe>
					</div>
				<? endforeach; ?>
			</div>
			<?=$video->icerik?>
			<br><span class="tarih"><?=lifos::to_web_date($video->tarih_yayin)?></span><br>
		</div><!-- .entry-content -->

	</article><!-- .hentry -->


	<section class="widget" style="margin-top: 10px;">
		<h5>Paylaş:</h5>
		<?php echo share(); ?>
	</section>

	<section class="widget">

		<!-- Widget Content -->
		<div class="frame thick">
			<div style="text-align: center">
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<!-- Haber Detay Alt -->
				<ins class="adsbygoogle"
					 style="display:inline-block;width:468px;height:60px"
					 data-ad-client="ca-pub-1034370367466687"
					 data-ad-slot="1672840300"></ins>
				<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
				</script>
			</div>
		</div>
		<img src="<?php echo get_asset('shadow.png'); ?>" alt="shadow" class="shadow">
	</section>

	<!-- RELATED POSTS -->
	<section class="widget">
		<!--Widget header-->
		<header class="clearfix"><h4>Diğer Videolar</h4></header>

		<?if($digerleri):?>
			<!--Widget Contents-->

			<div class="row">
				<? foreach($digerleri as $key => $diger): ?>
					<div class="article-small col-md-3 col-sm-6">
						<a href="<?=$diger->link.'-'.$diger->id?>" class="image">
							<figure class="image-holder">
								<img src="/user/files/wrap_<?=$diger->foto?>">
							</figure>
							<div class="image-light"></div>
							<span class="dashicons dashicons-format-link"></span>
						</a>
						<h5><a href="<?=$diger->link.'-'.$diger->id?>"><?=$diger->baslik?></a></h5>
						<p class="post-meta">
							<a href="#"><span class="fa fa-clock-o"></span> <?php echo lifos::to_web_date($diger->tarih_yayin); ?></a> &nbsp;
							<a href="#"><span class="fa fa-eye"></span> <?php echo $diger->hit; ?></a>
						</p>
						<hr class="visible-sm visible-xs">
					</div>
					<?php if(($key + 1) % 4 == 0): ?>
						<div class="clearfix"></div>
					<?php endif; ?>
				<? endforeach;?>
			</div>
		<?endif;?>
	</section>

	<a href="/?b=main/dialog_arkadasima_gonder&id=<?=$video->id?>" data-toggle="modal" class="btn btn-info"><i class="icon-envelope"></i> Arkadaşıma Gönder</a>

	<section class="widget">
		<div id="fb-root"></div>

		<script>(function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) return;
				js = d.createElement(s); js.id = id;
				js.src = "//connect.facebook.net/tr_TR/all.js#xfbml=1";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
		<div class="yorumlar">
			<header class="clearfix"><h4>Yorumlar</h4></header>
			<div class='fb-comments' data-href='<?php echo "http://www.pistonkafalar.com/".$_SERVER['REQUEST_URI'].""; ?>' data-num-posts='10' data-width='100%'></div>
		</div>
		<br>
	</section>

	<?=$pager?>

</main><!--#main-content-->

<?=$sag_menu_2?>