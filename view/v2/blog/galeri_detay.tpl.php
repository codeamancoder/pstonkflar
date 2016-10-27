<!-- MAIN CONTENT
                                      ================= -->
<main id="main-content" class="col-md-8">

	<?php echo $duyuru; ?>

	<!-- POST CONTENT -->
	<article class="article-large hentry">

		<header class="show">
			<h1 class="entry-title"><?=$blog->baslik; ?></h1>
		</header>

		<div class="entry-content">
			<div class="row">
				<? foreach($blog->fotolar as $foto):?>
					<div class="col-xs-3" style="margin-bottom: 5px;">
						<a href="/user/files/<?=$foto->id.'.'.$foto->uzanti?>" data-lightbox-gallery="gallery" class="box"><img class="img-responsive img-thumbnail" src="/user/files/wrap_<?=$foto->id.'.'.$foto->uzanti?>"></a>
					</div>
				<? endforeach; ?>
			</div>
			<?=$blog->icerik?>
			<br><span class="tarih"><?=lifos::to_web_date($blog->tarih_yayin)?></span><br>
		</div><!-- .entry-content -->

	</article><!-- .hentry -->


	<section class="widget" style="margin-top: 10px;">
		<h5>Paylaş:</h5>
		<?php echo share(); ?>
	</section>


	<? if( $blog->video ): ?>
		<section class="widget">
			<header class="clearfix"><h4>Video</h4></header>
			<? foreach( preg_split('/,/',$blog->video) as $a): ?>
				<div class="row">
					<div class="col-xs-12">
						<iframe width="650" height="475" src="//www.youtube-nocookie.com/embed/<?=$a?>?rel=0" frameborder="0" allowfullscreen></iframe>
					</div>
				</div>
			<? endforeach; ?>
		</section>
	<? endif; ?>

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
		<header class="clearfix"><h4>Diğer Galeriler</h4></header>

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

	<a href="/?b=main/dialog_arkadasima_gonder&id=<?=$blog->id?>" data-toggle="modal" class="btn btn-info"><i class="icon-envelope"></i> Arkadaşıma Gönder</a>

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