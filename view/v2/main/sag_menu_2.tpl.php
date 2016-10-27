<!--</main><!--#main-content-->
<!-- SIDEBAR
============ -->
<aside class="col-md-4">
	<div class="row">
        <!-- ADS WIDGET -->
        <section class="widget col-sm-6 col-md-12 no-mobile">
            <div class="frame thick" style="text-align: center;">
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<!-- 300 X 250 - 1 -->
				<ins class="adsbygoogle"
					 style="display:inline-block;width:300px;height:250px"
					 data-ad-client="ca-pub-1034370367466687"
					 data-ad-slot="8295840708"></ins>
				<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
				</script>
            </div>
        </section>

		<!-- CAROUSEL SMALL WIDGET -->
		<section class="col-sm-6 col-md-12 widget no-mobile">
			<!-- Widget Header -->
			<header class="clearfix">
				<h4><a href="/index.php?b=blog/galeriler/piston">Galeri</a></h4>
				<a href="#carousel-small" class="control" data-slide="next">
					<i class="fa fa-chevron-right"></i>
				</a>
				<a href="#carousel-small" class="control" data-slide="prev">
					<i class="fa fa-chevron-left"></i>
				</a>

			</header>

			<!-- Widget content: carousel gallery -->
			<div id="carousel-small" class="carousel slide carousel-small frame" data-ride="carousel">
				<div class="carousel-inner">
					<? foreach($galeriler['bizden'] as $index=>$galeri):?>
					<a class="item <?php echo $index === 0 ? 'active':''; ?>"
					   href="/<?=$galeri->link.'-'.$galeri->blog_id?>"
					   title="<?=$galeri->blog_baslik?>">
						<div data-src="/user/files/<?=$galeri->id.'.'.$galeri->uzanti?>" data-alt="<?=$galeri->blog_baslik?>"></div>
						<div class="image-light"></div>
						<div class="caption">
							<h5><?=$galeri->blog_baslik?></h5>
						</div>
					</a>
					<? endforeach;?>

				</div><!--.carousel-inner-->
			</div><!--.carousel-->

			<!--Shadow-->
			<img src="<?php echo get_asset('shadow.png'); ?>" class="shadow" alt="shadow">
		</section>

		<!-- FEEDBURNER WIDGET -->
		<section class="col-sm-6 col-md-12 widget feedburner">
			<!-- Widget Header -->
			<header class="clearfix"><h4>Haber Bülteni</h4></header>

			<!-- Widget Content -->
			<form action="index.php" method="post">
				<div class="input-group">
					<i class="fa fa-envelope"></i>
					<input type="text" name="email" placeholder="Email adresi" />
				</div>
				<input type="submit" name="postala" value="Gönder" />
			</form>
		</section>

		<!-- YOUTUBE WIDGET -->
		<section class="col-sm-6 col-md-12 widget">
			<? if($reklam_ust_sag2) : ?>
				<section id="reklam_ust_sag"><?=$reklam_ust_sag2->icerik?></section>
			<? elseif($galeri2):?>
				<header class="clearfix"><h4><?=$galeri2->baslik?></h4></header>
				<a href="/<?=$galeri2->link.'-'.$galeri2->id?>"><img src="/user/files/<?=$galeri2->fotos[0]->id.'.'.$galeri2->fotos[0]->uzanti?>" width="100%"></a>
			<?php endif;?>
		</section>

		<!-- TABS WIDGET -->
		<section class="col-sm-6 col-md-12 widget">
			<!-- Tab menus -->
			<ul class="nav nav-tabs">
				<li class="active"><a href="#haberler-aside" data-toggle="tab">Haberler</a></li>
				<li><a href="#sektorel-aside" data-toggle="tab">Sektörel</a></li>
				<li><a href="#yenilikler-aside" data-toggle="tab">Yenilikler</a></li>
			</ul>

			<!-- Tab contents -->
			<div class="tab-content">

				<div class="tab-pane active fade in" id="haberler-aside">
                    <? foreach($cok['haber'] as $haber):?>
                        <div class="article-tiny">
                            <a href="/<?=$haber->link.'-'.$haber->id?>" class="image">
                                <figure class="image-holder">
                                    <img src="/user/files/wrap_<?=$haber->foto?>" alt="<?=lifos::convert_case_title($haber->baslik);?>">
                                </figure>
                                <div class="image-light"></div>
                                <span class="dashicons dashicons-format-gallery"></span>
                            </a>
                            <h5><a href="/<?=$haber->link.'-'.$haber->id?>"><?=lifos::substr($haber->baslik,42,'..')?></a></h5>
                            <p class="post-meta">
                                <a href="#"><span class="fa fa-clock-o"></span> <?php echo lifos::to_web_date($haber->tarih_yayin); ?></a> &nbsp;
                                <a href="#"><span class="fa fa-eye"></span> <?php echo $haber->hit; ?></a>
                            </p>
                        </div>
                        <hr>
                    <? endforeach;?>
				</div>

				<div class="tab-pane fade" id="sektorel-aside">
                    <? foreach($cok['sektorel'] as $haber):?>
                        <div class="article-tiny">
                            <a href="/<?=$haber->link.'-'.$haber->id?>" class="image">
                                <figure class="image-holder">
                                    <img src="/user/files/wrap_<?=$haber->foto?>" alt="<?=lifos::convert_case_title($haber->baslik);?>">
                                </figure>
                                <div class="image-light"></div>
                                <span class="dashicons dashicons-format-gallery"></span>
                            </a>
                            <h5><a href="/<?=$haber->link.'-'.$haber->id?>"><?=lifos::substr($haber->baslik,42,'..')?></a></h5>
                            <p class="post-meta">
                                <a href="#"><span class="fa fa-clock-o"></span> <?php echo lifos::to_web_date($haber->tarih_yayin); ?></a> &nbsp;
                                <a href="#"><span class="fa fa-eye"></span> <?php echo $haber->hit; ?></a>
                            </p>
                        </div>
                        <hr>
                    <? endforeach;?>
				</div>

				<div class="tab-pane fade" id="yenilikler-aside">
                    <? foreach($cok['yenilik'] as $haber):?>
                        <div class="article-tiny">
                            <a href="/<?=$haber->link.'-'.$haber->id?>" class="image">
                                <figure class="image-holder">
                                    <img src="/user/files/wrap_<?=$haber->foto?>" alt="<?=lifos::convert_case_title($haber->baslik);?>">
                                </figure>
                                <div class="image-light"></div>
                                <span class="dashicons dashicons-format-gallery"></span>
                            </a>
                            <h5><a href="/<?=$haber->link.'-'.$haber->id?>"><?=lifos::substr($haber->baslik,42,'..')?></a></h5>
                            <p class="post-meta">
                                <a href="#"><span class="fa fa-clock-o"></span> <?php echo lifos::to_web_date($haber->tarih_yayin); ?></a> &nbsp;
                                <a href="#"><span class="fa fa-eye"></span> <?php echo $haber->hit; ?></a>
                            </p>
                        </div>
                        <hr>
                    <? endforeach;?>
				</div>
			</div>
		</section>

		<!-- ADS WIDGET -->
		<section class="widget col-sm-6 col-md-12 no-mobile">
			<div class="frame thick" style="text-align: center;">
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<!-- 300 X 250 - 2 -->
				<ins class="adsbygoogle"
					 style="display:inline-block;width:300px;height:250px"
					 data-ad-client="ca-pub-1034370367466687"
					 data-ad-slot="9772573903"></ins>
				<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
				</script>
			</div>
		</section>

		<section class="col-sm-6 col-md-12 widget">
			<header class="clearfix"><h4>Editör</h4></header>
			<div class="article-tiny">
				<a href="<?=$akin_son->link.'-'.$akin_son->id?>" class="image">
					<figure class="image-holder">
						<img src="/user/akin2.jpg" alt="<?=lifos::convert_case_title($haber->baslik);?>">
					</figure>
					<div class="image-light"></div>
					<span class="dashicons dashicons-format-gallery"></span>
				</a>
				<h5><a href="<?=$akin_son->link.'-'.$akin_son->id?>"><?=lifos::substr($akin_son->baslik,50,'..')?></a></h5>
				<p class="post-meta">
					<a href="<?=$akin_son->link.'-'.$akin_son->id?>"><span class="fa fa-users"></span> Akın Dağyaran</a> &nbsp;
				</p>
			</div>
			<hr>
		</section>



		<?php /* ?>
		<!-- VIMEO WIDGET -->
		<section class="col-sm-6 col-md-12 widget">
			<!-- Widget header -->
			<header class="clearfix"><h4>Vimeo Video</h4></header>

			<!-- Widget content: Vimeo embed code -->
			<iframe src="//player.vimeo.com/video/83480879" width="360" height="203" allowfullscreen></iframe>
		</section>
 		<?php */ ?>

		<!-- TABS: CATEGORIES AND TAGS -->
		<section class="col-sm-6 col-md-12 widget">
			<!-- Widget header: tab menu -->
			<ul class="nav nav-tabs">
				<li class="active"><a href="#categories" data-toggle="tab">Kategoriler</a></li>
				<li><a href="#tags" data-toggle="tab">Etiketler</a></li>
			</ul><!--.nav-tabs-->

			<!-- Tab contents -->
			<div class="tab-content">
				<!-- Categories-->
				<div class="tab-pane active fade in" id="categories">
					<ul class="categories">
						<li><a href="/blog/haberler"><i class="fa fa-angle-right"></i> Haberler </a></li>
						<li><a href="/blog/sektorel"><i class="fa fa-angle-right"></i> Sektörel  </a></li>
						<li><a href="/blog/yenilikler"><i class="fa fa-angle-right"></i> Yenilikler </a></li>
						<li><a href="/blog/test"><i class="fa fa-angle-right"></i> Test </a></li>
						<li><a href="/blog/motorspor"><i class="fa fa-angle-right"></i> Motor Sporları </a></li>
						<li><a href="/blog/modifiye"><i class="fa fa-angle-right"></i> Modifiye </a></li>
						<li><a href="/blog/lifestyle"><i class="fa fa-angle-right"></i> Life Style </li>
						<li><a href="/blog/diescast"><i class="fa fa-angle-right"></i> Model Otomobiller </a></li>
					</ul>
				</div>

				<!-- Tags -->
				<div class="tab-pane fade" id="tags">
					<ul class="tags clearfix">
						<?php if($etiketler): ?>
							<?php foreach($etiketler as $etiket): ?>
						<li><a href="/etiket/<?=$etiket->tag;?>"><?=$etiket->tag;?></a></li>
								<?php endforeach; ?>
						<?php endif; ?>
					</ul>
				</div>
			</div><!--.tab-content-->
		</section>

		<!-- ADS WIDGET -->
		<section class="widget col-sm-6 col-md-12 no-mobile">
			<div class="frame thick" style="text-align: center;">
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<!-- 300x600 Sağ Alt -->
				<ins class="adsbygoogle"
					 style="display:inline-block;width:300px;height:600px"
					 data-ad-client="ca-pub-1034370367466687"
					 data-ad-slot="3069905505"></ins>
				<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
				</script>
			</div>
		</section>

        <?php /* ?>
		<!-- ACCORDION -->
		<section class="col-sm-6 col-md-12 widget">
			<!--Widget header-->
			<header class="clearfix"><h4>Accordion</h4></header>

			<!--Widget content-->
			<div class="accordion">
				<div class="header active"><h5>Home</h5><i class="fa fa-plus"></i></div>
				<div class="content">
					<p>
						Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer
						ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit
						amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut
						odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.
					</p>
				</div>

				<div class="header"><h5>Profile</h5><i class="fa fa-plus"></i></div>
				<div class="content">
					<p>
						Sed non urna. Donec et ante. Phasellus eu ligula. Vestibulum sit amet
						purus. Vivamus hendrerit, dolor at aliquet laoreet, mauris turpis porttitor
						velit, faucibus interdum tellus libero ac justo. Vivamus non quam. In
						suscipit faucibus urna.
					</p>
				</div>

				<div class="header"><h5>Messages</h5><i class="fa fa-plus"></i></div>
				<div class="content">
					<p>
						Nam enim risus, molestie et, porta ac, aliquam ac, risus. Quisque lobortis.
						Phasellus pellentesque purus in massa. Aenean in pede. Phasellus ac libero
						ac tellus pellentesque semper. Sed ac felis. Sed commodo, magna quis
						lacinia ornare, quam ante aliquam nisi, eu iaculis leo purus venenatis dui.
					</p>
				</div>

				<div class="header"><h5>Settings</h5><i class="fa fa-plus"></i></div>
				<div class="content">
					<p>
						Cras dictum. Pellentesque habitant morbi tristique senectus et netus
						et malesuada fames ac turpis egestas. Vestibulum ante ipsum primis in
						faucibus orci luctus et ultrices posuere cubilia Curae; Aenean lacinia
						mauris vel est.
					</p>
				</div>
			</div>
		</section>
        <?php */ ?>
	</div><!--.row-->
</aside>

</div><!-- row finish -->
