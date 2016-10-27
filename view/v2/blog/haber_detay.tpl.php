<!-- MAIN CONTENT
                                      ================= -->
<main id="main-content" class="col-md-8">

	<?php echo $duyuru; ?>

	<!-- POST CONTENT -->
	<article class="article-large hentry">
		<?php if($foto): ?>
		<!--Image-->
		<div class="frame thick clearfix">
			<a href="/user/files/<?=$foto->id.'.'.$foto->uzanti?>" class="image" data-lightbox title="<?=$blog->ozet;?>">
				<figure class="image-holder">
					<img src="/user/files/<?=$foto->id.'.'.$foto->uzanti?>" alt="<?=$blog->ozet;?>">
				</figure>
				<div class="image-light"></div>
			</a>
			<div class="icons entry-footer">
				<a href="#"><i class="fa fa-comments"></i><span class="comment"><?=$blog->hit;?></span></a>
			</div>
			<p class="post-meta entry-footer pull-right">
				<a href="#" rel="bookmark"><time class="entry-date published updated" datetime="2014-01-08T11:42:20+00:00"><?=lifos::to_web_date($blog->tarih_yayin)?></time></a>
			</p>
		</div>
		<img src="<?php echo get_asset('shadow.png'); ?>" class="shadow" alt="shadow">
		<?php endif; ?>

		<header class="show">
			<h1 class="entry-title"><?=$blog->baslik; ?></h1>
		</header>

		<div class="entry-content">
			<? if($blog->kategori==2):?>
			<? $test = unserialize($blog->test);?>
			<div class="table-responsive">
				<table class="table">
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
					<tr><th><img src="/static/v2/img/ok.png"></th><td><?=$test['arti']?></td></tr>
					<tr><th><img src="/static/v2/img/nok.png"></th><td><?=$test['eksi']?></td></tr>
					<tr><th>PistonKafalar Skor</th><td><?=lifos::star_rating($test['rating'],false)?></td></tr>
				</table>
			</div>
			<?php endif; ?>
			<?=$blog->icerik?>
		</div><!-- .entry-content -->

	</article><!-- .hentry -->

    <?php $etiketler = get_etiket($blog); ?>

    <?php if($etiketler): ?>
        <!-- POST TAGS -->
        <section class="post-tags clearfix">
            <h5>Etiketler: </h5>
            <ul class="tags">
                <?php foreach($etiketler as $etiket): ?>
                    <li><a href="/etiket/<?=$etiket->tag?>"><?=$etiket->tag;?></a></li>
                <?php endforeach; ?>
            </ul>
        </section>
    <?php endif; ?>

    <section class="widget" style="margin-top: 10px;">
        <h5>Paylaş:</h5>
	    <?php echo share(); ?>
    </section>


	<? if(count($blog->fotolar)>1): ?>
    <section class="widget">
		<header class="clearfix"><h4>Fotoğraflar</h4></header>
		<div class="row clearfix">
			<? foreach($blog->fotolar as $foto):?>
				<div class="col-xs-4" style="margin-bottom: 5px;">
					<a href="/user/files/<?=$foto->id.'.'.$foto->uzanti?>" class="image" data-lightbox-gallery="blog-gallery" title="<?=$blog->ozet;?>"><img class="img-responsive img-thumbnail" src="/user/files/wrap_<?=$foto->id.'.'.$foto->uzanti?>"></a>
				</div>
			<? endforeach; ?>
		</div>
    </section>
	<? endif; ?>

	<? if( $blog->video ): ?>
        <section class="widget">
            <header class="clearfix"><h4>Video</h4></header>
		<? foreach( preg_split('/,/',$blog->video) as $a): ?>
			<div class="row">
				<iframe width="650" height="475" src="//www.youtube-nocookie.com/embed/<?=$a?>?rel=0" frameborder="0" allowfullscreen></iframe>
			</div>
		<? endforeach; ?>
    </section>
<? endif; ?>
	<!-- SHARE POST -->
<!--	<section class="share-post clearfix">-->
<!--		<h5>Share:</h5>-->
<!--		<ul>-->
<!--			<li><a href="#"><i class="sc-sm sc-facebook"></i><span>426</span></a></li>-->
<!--			<li><a href="#"><i class="sc-sm sc-twitter"></i><span>526</span></a></li>-->
<!--			<li><a href="#"><i class="sc-sm sc-pinterest"></i><span>283</span></a></li>-->
<!--			<li><a href="#"><i class="sc-sm sc-linkedin"></i><span>329</span></a></li>-->
<!--			<li><a href="#"><i class="sc-sm sc-googleplus"></i><span>429</span></a></li>-->
<!--		</ul>-->
<!--	</section>-->

	<!-- ADS -->
	<section class="widget">

		<!-- Widget Content -->
		<div class="frame thick">
			<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			<!-- Haber İçi Alt - Yatay -->
			<ins class="adsbygoogle"
				 style="display:block"
				 data-ad-client="ca-pub-1034370367466687"
				 data-ad-slot="8837237508"
				 data-ad-format="auto"></ins>
			<script>
				(adsbygoogle = window.adsbygoogle || []).push({});
			</script>
		</div>
		<img src="<?php echo get_asset('shadow.png'); ?>" alt="shadow" class="shadow">
	</section>

	<!-- RELATED POSTS -->
	<section class="widget">
		<!--Widget header-->
		<header class="clearfix"><h4>Diğer <?=$baslik?></h4></header>

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