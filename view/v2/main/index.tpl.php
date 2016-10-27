<!-- MAIN CONTENT
            ================= -->
<main id="main-content" class="col-md-8">
    <?php echo $duyuru; ?>
<!-- CAROUSEL  -->
<section class="widget no-mobile">
	<div class="frame thick">
		<div id="carousel-medium" class="carousel slide carousel-medium" data-ride="carousel">
			<!-- Carousel contents -->
			<div class="carousel-inner">
                <? foreach($haber_manset as $i=>$manset) :?>
                    <div class="item <?php echo $i === 0 ? 'active': ''; ?>">
                        <div data-src="/user/files/<?=$manset->foto?>" data-alt="<?=$manset->tip=='video' ? 'Video : ' : ($manset->tip=='galeri' ? 'Galeri : ':'')?><?=$manset->baslik?>"></div>
                        <div class="carousel-caption">
                            <div><a href="<?=$manset->link.'-'.$manset->id?>"><h1><?=$manset->baslik?></h1></a></div>
                            <div class="hidden-xs">
                                <a href="<?=$manset->link.'-'.$manset->id?>">
                                    <p>
                                        <?=$manset->ozet;?>
                                    </p>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
			<!-- Light -->
			<div class="image-light"></div>

			<!-- Carousel Controls -->
			<a class="left carousel-control" href="#carousel-medium" data-slide="prev"><span class="fa fa-chevron-left"></span></a>
			<a class="right carousel-control" href="#carousel-medium" data-slide="next"><span class="fa fa-chevron-right"></span></a>
		</div>
	</div>
	<img src="<?php echo get_asset('shadow.png'); ?>" class="shadow" alt="shadow">
</section>

<!-- ARTICLES V1 WIDGET -->
<section class="widget articles-v1">
	<!-- Widget Header -->
	<header class="clearfix">
		<h4>Haberler</h4>
		<a href="/index.php?b=blog/haberler" class="control"><i class="fa fa-plus"></i></a>
	</header>

    <? foreach($haberler as $i=>$haber) :?>
        <!-- Widget Contents: Articles-->
        <div class="article-medium">
            <div class="row">
                <!--Image-->
                <div class="col-sm-6">
                    <div class="frame">
                        <a class="image" href="<?=$haber->link?>-<?=$haber->id?>">
                            <figure class="image-holder">
                                <img src="/user/files/wrap_<?=$haber->foto?>" alt="<?=lifos::convert_case_title($haber->baslik);?>">
                            </figure>
                            <div class="image-light"></div>
                            <span class="dashicons dashicons-format-standard"></span>
                        </a>
                    </div>
                    <img src="<?php echo get_asset('shadow.png'); ?>" class="shadow" alt="shadow">
                </div>

                <!--Content-->
                <div class="col-sm-6">
                    <h4><a href="<?=$haber->link?>-<?=$haber->id?>" title="<?=lifos::convert_case_title($haber->baslik);?>"><?=lifos::substr($haber->baslik,65,'..')?></a></h4>
                    <p class="post-meta">
                        <a href="#"><span class="fa fa-clock-o"></span> <?php echo lifos::to_web_date($haber->tarih_yayin); ?></a> &nbsp;
                        <a href="#"><span class="fa fa-folder"></span> <?php echo $haber->tip; ?></a> &nbsp;
                        <a href="#"><span class="fa fa-eye"></span> <?php echo $haber->hit; ?></a>
                    </p>
                    <p>
                        <?=lifos::substr($haber->ozet,200,'..')?>
                    </p>
                </div>
            </div>
        </div>
        <hr>
    <?php endforeach; ?>

</section>

<!-- ADS -->
<section class="widget">
	<!-- Widget Content -->
	<div class="frame thick">
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- Ana Sayfa Üst Yatay - 1 -->
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-client="ca-pub-1034370367466687"
             data-ad-slot="4407037905"
             data-ad-format="auto"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>
	<img src="<?php echo get_asset('shadow.png'); ?>" alt="shadow" class="shadow">
</section>

<!-- ARTICLES V2 WIDGET -->
<section class="widget articles-v2">
	<!-- Widget Header -->
	<header class="clearfix">
		<h4>Sektörel</h4>
		<a href="/index.php?b=blog/sektorel" class="control"><i class="fa fa-plus"></i></a>
	</header>

	<!-- Widget Contents -->
	<div class="content row">

        <? foreach($sektorel as $i=>$haber) :?>
            <?php if($i === 0): ?>
            <div class="col-sm-6 article-medium">
                <!--frame-->
                <div class="frame">
                    <!--image-->
                    <a class="image" href="<?=$haber->link?>-<?=$haber->id?>">
                        <figure class="image-holder">
                            <img src="/user/files/wrap_<?=$haber->foto?>" alt="<?=lifos::convert_case_title($haber->baslik);?>">
                        </figure>
                        <div class="image-light"></div>
                        <span class="dashicons dashicons-format-quote"></span>
                    </a>
                </div>
                <img src="<?php echo get_asset('shadow.png'); ?>" class="shadow" alt="shadow">

                <h4><a href="<?=$haber->link?>-<?=$haber->id?>"><?=lifos::substr($haber->baslik,65,'..')?></a></h4>
                <p class="post-meta">
                    <a href="#"><span class="fa fa-clock-o"></span> <?php echo lifos::to_web_date($haber->tarih_yayin); ?></a> &nbsp;
                    <a href="#"><span class="fa fa-eye"></span> <?php echo $haber->hit; ?></a>
                </p>

                <!--content-->
                <p>
                    <?=lifos::substr($haber->ozet,200,'..')?>
                </p>
                <hr>
            </div>
            <?php else: ?>

                <div class="col-sm-6 article-tiny">
                    <!-- image -->
                    <a href="<?=$haber->link?>-<?=$haber->id?>" class="image">
                        <figure class="image-holder">
                            <img src="/user/files/wrap_<?=$haber->foto?>" alt="<?=lifos::convert_case_title($haber->baslik);?>">
                        </figure>
                        <div class="image-light"></div>
                        <span class="dashicons dashicons-format-link"></span>
                    </a>

                    <!--content-->
                    <h5><a href="<?=$haber->link?>-<?=$haber->id?>"><?=lifos::substr($haber->baslik,65,'..')?></a></h5>
                    <p class="post-meta">
                        <a href="#"><span class="fa fa-clock-o"></span> <?php echo lifos::to_web_date($haber->tarih_yayin); ?></a> &nbsp;
                        <a href="#"><span class="fa fa-eye"></span> <?php echo $haber->hit; ?></a>
                    </p>
                    <hr>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>

	</div><!--.content-->
</section><!--.widget-->


<div class="row">
	<!-- ARTICLES V3 WIDGET -->
	<section class="widget articles-v3 col-sm-6">
		<!-- Widget header -->
		<header class="clearfix">
			<h4>Motor Sporları</h4>
			<a href="/index.php?b=blog/modifiye" class="control"><i class="fa fa-plus"></i></a>
		</header>

		<!-- Widget contents -->
        <? foreach($motorspor as $i=>$haber) :?>

            <?php if($i === 0): ?>
                <div class="article-medium">
                    <!--image-->
                    <div class="frame">
                        <a class="image" href="<?=$haber->link?>-<?=$haber->id?>">
                            <figure class="image-holder">
                                <img src="/user/files/wrap_<?=$haber->foto?>" alt="<?=lifos::convert_case_title($haber->baslik);?>">
                            </figure>
                            <div class="image-light"></div>
                            <span class="dashicons dashicons-format-gallery"></span>
                        </a>
                    </div>
                    <img src="<?php echo get_asset('shadow.png'); ?>" class="shadow" alt="shadow">

                    <h4><a href="<?=$haber->link?>-<?=$haber->id?>"><?=lifos::substr($haber->baslik,65,'..')?></a></h4>
                    <p class="post-meta">
                        <a href="#"><span class="fa fa-clock-o"></span> <?php echo lifos::to_web_date($haber->tarih_yayin); ?></a> &nbsp;
                        <a href="#"><span class="fa fa-eye"></span> <?php echo $haber->hit; ?></a>
                    </p>

                    <!--content-->
                    <p>
                        <?=lifos::substr($haber->ozet,200,'..')?>
                    </p>
                    <hr>
                </div>
                <?php else: ?>
                <div class="article-tiny">
                    <!--image-->
                    <a href="<?=$haber->link?>-<?=$haber->id?>" class="image">
                        <figure class="image-holder">
                            <img src="/user/files/wrap_<?=$haber->foto?>" alt="<?=lifos::convert_case_title($haber->baslik);?>">
                        </figure>
                        <div class="image-light"></div>
                        <span class="dashicons dashicons-format-image"></span>
                    </a>

                    <!--content-->
                    <h5><a href="<?=$haber->link?>-<?=$haber->id?>"><?=lifos::substr($haber->baslik,65,'..')?></a></h5>
                    <p class="post-meta">
                        <a href="#"><span class="fa fa-clock-o"></span> <?php echo lifos::to_web_date($haber->tarih_yayin); ?></a> &nbsp;
                        <a href="#"><span class="fa fa-eye"></span> <?php echo $haber->hit; ?></a>
                    </p>
                    <hr>
                </div>
            <?php endif; ?>
        <? endforeach; ?>

	</section><!--.widget-->

	<!-- ARTICLES V3 WIDGET -->
	<section class="widget articles-v3 col-sm-6">
		<!-- Widget header -->
		<header class="clearfix">
			<h4>Yenilikler</h4>
			<a href="/index.php?b=blog/yenilikler" class="control"><i class="fa fa-plus"></i></a>
		</header>

        <!-- Widget contents -->
        <? foreach($yenilikler as $i=>$haber) :?>

            <?php if($i === 0): ?>
                <div class="article-medium">
                    <!--image-->
                    <div class="frame">
                        <a class="image" href="<?=$haber->link?>-<?=$haber->id?>">
                            <figure class="image-holder">
                                <img src="/user/files/wrap_<?=$haber->foto?>" alt="<?=lifos::convert_case_title($haber->baslik);?>">
                            </figure>
                            <div class="image-light"></div>
                            <span class="dashicons dashicons-format-gallery"></span>
                        </a>
                    </div>
                    <img src="<?php echo get_asset('shadow.png'); ?>" class="shadow" alt="shadow">

                    <h4><a href="<?=$haber->link?>-<?=$haber->id?>"><?=lifos::substr($haber->baslik,65,'..')?></a></h4>
                    <p class="post-meta">
                        <a href="#"><span class="fa fa-clock-o"></span> <?php echo lifos::to_web_date($haber->tarih_yayin); ?></a> &nbsp;
                        <a href="#"><span class="fa fa-eye"></span> <?php echo $haber->hit; ?></a>
                    </p>

                    <!--content-->
                    <p>
                        <?=lifos::substr($haber->ozet,200,'..')?>
                    </p>
                    <hr>
                </div>
            <?php else: ?>
                <div class="article-tiny">
                    <!--image-->
                    <a href="<?=$haber->link?>-<?=$haber->id?>" class="image">
                        <figure class="image-holder">
                            <img src="/user/files/wrap_<?=$haber->foto?>" alt="<?=lifos::convert_case_title($haber->baslik);?>">
                        </figure>
                        <div class="image-light"></div>
                        <span class="dashicons dashicons-format-image"></span>
                    </a>

                    <!--content-->
                    <h5><a href="<?=$haber->link?>-<?=$haber->id?>"><?=lifos::substr($haber->baslik,65,'..')?></a></h5>
                    <p class="post-meta">
                        <a href="#"><span class="fa fa-clock-o"></span> <?php echo lifos::to_web_date($haber->tarih_yayin); ?></a> &nbsp;
                        <a href="#"><span class="fa fa-eye"></span> <?php echo $haber->hit; ?></a>
                    </p>
                    <hr>
                </div>
            <?php endif; ?>
        <? endforeach; ?>
	</section><!--.widget-->
</div>

<!-- ADS -->
<section class="widget">
	<!-- Widget Content -->
	<div class="frame thick">
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- Ana Sayfa Üst Yatay - 2 -->
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-client="ca-pub-1034370367466687"
             data-ad-slot="5883771108"
             data-ad-format="auto"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>
	<img src="<?php echo get_asset('shadow.png'); ?>" alt="shadow" class="shadow">
</section>

    <!-- ARTICLES V2 WIDGET -->
    <section class="widget articles-v2">
        <!-- Widget Header -->
        <header class="clearfix">
            <h4>Çevreci Otomobiller</h4>
            <a href="/index.php?b=blog/cevreciotomobiller" class="control"><i class="fa fa-plus"></i></a>
        </header>

        <!-- Widget Contents -->
        <div class="content row">

            <? foreach($cevreciler as $i=>$haber) :?>
                <?php if($i === 0): ?>
                    <div class="col-sm-6 article-medium">
                        <!--frame-->
                        <div class="frame">
                            <!--image-->
                            <a class="image" href="<?=$haber->link?>-<?=$haber->id?>">
                                <figure class="image-holder">
                                    <img src="/user/files/wrap_<?=$haber->foto?>" alt="<?=lifos::convert_case_title($haber->baslik);?>">
                                </figure>
                                <div class="image-light"></div>
                                <span class="dashicons dashicons-format-quote"></span>
                            </a>
                        </div>
                        <img src="<?php echo get_asset('shadow.png'); ?>" class="shadow" alt="shadow">

                        <h4><a href="<?=$haber->link?>-<?=$haber->id?>"><?=lifos::substr($haber->baslik,65,'..')?></a></h4>
                        <p class="post-meta">
                            <a href="#"><span class="fa fa-clock-o"></span> <?php echo lifos::to_web_date($haber->tarih_yayin); ?></a> &nbsp;
                            <a href="#"><span class="fa fa-eye"></span> <?php echo $haber->hit; ?></a>
                        </p>

                        <!--content-->
                        <p>
                            <?=lifos::substr($haber->ozet,200,'..')?>
                        </p>
                        <hr>
                    </div>
                <?php else: ?>

                    <div class="col-sm-6 article-tiny">
                        <!-- image -->
                        <a href="<?=$haber->link?>-<?=$haber->id?>" class="image">
                            <figure class="image-holder">
                                <img src="/user/files/wrap_<?=$haber->foto?>" alt="<?=lifos::convert_case_title($haber->baslik);?>">
                            </figure>
                            <div class="image-light"></div>
                            <span class="dashicons dashicons-format-link"></span>
                        </a>

                        <!--content-->
                        <h5><a href="<?=$haber->link?>-<?=$haber->id?>"><?=lifos::substr($haber->baslik,65,'..')?></a></h5>
                        <p class="post-meta">
                            <a href="#"><span class="fa fa-clock-o"></span> <?php echo lifos::to_web_date($haber->tarih_yayin); ?></a> &nbsp;
                            <a href="#"><span class="fa fa-eye"></span> <?php echo $haber->hit; ?></a>
                        </p>
                        <hr>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>

        </div><!--.content-->
    </section><!--.widget-->

<div class="row">
	<!-- ARTICLES V4 WIDGET -->
	<section class="widget articles-v4 col-sm-3 col-xs-6">
		<!-- Widget Header -->
		<header class="clearfix">
			<h4>Kampanyalar</h4>
			<a href="/index.php?b=blog/kampanyalar" class="control"><i class="fa fa-plus"></i></a>
		</header>

        <? foreach($kampanyalar as $i=>$haber) :?>
		<!-- Widget contents -->
            <?php if($i === 0): ?>
            <div class="article-small">
                <!--image-->
                <a href="<?=$haber->link?>-<?=$haber->id?>" class="image">
                    <figure class="image-holder">
                        <img src="/user/files/wrap_<?=$haber->foto?>" alt="<?=lifos::convert_case_title($haber->baslik);?>">
                    </figure>
                    <div class="image-light"></div>
                    <span class="dashicons dashicons-format-standard"></span>
                </a>

                <!--content-->
                <h5><a href="<?=$haber->link?>-<?=$haber->id?>"><?=lifos::substr($haber->baslik,45,'..')?></a></h5>
                <p class="post-meta">
                    <a href="#"><span class="fa fa-clock-o"></span> <?php echo lifos::to_web_date($haber->tarih_yayin); ?></a> &nbsp;
                    <a href="#"><span class="fa fa-eye"></span> <?php echo $haber->hit; ?></a>
                </p>
                <hr>
            </div>
            <?php else: ?>
            <div>
                <h5><a href="<?=$haber->link?>-<?=$haber->id?>"><?=lifos::substr($haber->baslik,45,'..')?></a></h5>
                <p class="post-meta">
                    <a href="#"><span class="fa fa-clock-o"></span> <?php echo lifos::to_web_date($haber->tarih_yayin); ?></a> &nbsp;
                    <a href="#"><span class="fa fa-eye"></span> <?php echo $haber->hit; ?></a>
                </p>
                <hr>
            </div>
            <?php endif; ?>
        <?php endforeach; ?>

	</section><!--.widget-->

	<!-- ARTICLES V4 WIDGET -->
	<section class="widget articles-v4 col-sm-3 col-xs-6">
		<!-- Widget header -->
        <header class="clearfix">
            <h4>Modifiye</h4>
            <a href="/index.php?b=blog/motorspor" class="control"><i class="fa fa-plus"></i></a>
        </header>

        <? foreach($modifiye as $i=>$haber) :?>
            <!-- Widget contents -->
            <?php if($i === 0): ?>
                <div class="article-small">
                    <!--image-->
                    <a href="<?=$haber->link?>-<?=$haber->id?>" class="image">
                        <figure class="image-holder">
                            <img src="/user/files/wrap_<?=$haber->foto?>" alt="<?=lifos::convert_case_title($haber->baslik);?>">
                        </figure>
                        <div class="image-light"></div>
                        <span class="dashicons dashicons-format-standard"></span>
                    </a>

                    <!--content-->
                    <h5><a href="<?=$haber->link?>-<?=$haber->id?>"><?=lifos::substr($haber->baslik,45,'..')?></a></h5>
                    <p class="post-meta">
                        <a href="#"><span class="fa fa-clock-o"></span> <?php echo lifos::to_web_date($haber->tarih_yayin); ?></a> &nbsp;
                        <a href="#"><span class="fa fa-eye"></span> <?php echo $haber->hit; ?></a>
                    </p>
                    <hr>
                </div>
            <?php else: ?>
                <div>
                    <h5><a href="<?=$haber->link?>-<?=$haber->id?>"><?=lifos::substr($haber->baslik,45,'..')?></a></h5>
                    <p class="post-meta">
                        <a href="#"><span class="fa fa-clock-o"></span> <?php echo lifos::to_web_date($haber->tarih_yayin); ?></a> &nbsp;
                        <a href="#"><span class="fa fa-eye"></span> <?php echo $haber->hit; ?></a>
                    </p>
                    <hr>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
	</section><!--.widget-->

	<div class="clearfix visible-xs"></div>

	<!-- ARTICLES V4 WIDGET -->
	<section class="widget articles-v4 col-sm-3 col-xs-6">
		<!-- Widget header -->
        <header class="clearfix">
            <h4>Life Style</h4>
            <a href="/index.php?b=blog/lifestyle" class="control"><i class="fa fa-plus"></i></a>
        </header>

        <? foreach($lifestyle as $i=>$haber) :?>
            <!-- Widget contents -->
            <?php if($i === 0): ?>
                <div class="article-small">
                    <!--image-->
                    <a href="<?=$haber->link?>-<?=$haber->id?>" class="image">
                        <figure class="image-holder">
                            <img src="/user/files/wrap_<?=$haber->foto?>" alt="<?=lifos::convert_case_title($haber->baslik);?>">
                        </figure>
                        <div class="image-light"></div>
                        <span class="dashicons dashicons-format-standard"></span>
                    </a>

                    <!--content-->
                    <h5><a href="<?=$haber->link?>-<?=$haber->id?>"><?=lifos::substr($haber->baslik,45,'..')?></a></h5>
                    <p class="post-meta">
                        <a href="#"><span class="fa fa-clock-o"></span> <?php echo lifos::to_web_date($haber->tarih_yayin); ?></a> &nbsp;
                        <a href="#"><span class="fa fa-eye"></span> <?php echo $haber->hit; ?></a>
                    </p>
                    <hr>
                </div>
            <?php else: ?>
                <div>
                    <h5><a href="<?=$haber->link?>-<?=$haber->id?>"><?=lifos::substr($haber->baslik,45,'..')?></a></h5>
                    <p class="post-meta">
                        <a href="#"><span class="fa fa-clock-o"></span> <?php echo lifos::to_web_date($haber->tarih_yayin); ?></a> &nbsp;
                        <a href="#"><span class="fa fa-eye"></span> <?php echo $haber->hit; ?></a>
                    </p>
                    <hr>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
	</section><!--.widget-->

	<!-- ARTICLES V4 WIDGET -->
	<section class="widget articles-v4 col-sm-3 col-xs-6">
		<!-- Widget header -->
        <header class="clearfix">
            <h4>Test</h4>
            <a href="/index.php?b=blog/test" class="control"><i class="fa fa-plus"></i></a>
        </header>

        <? foreach($testler as $i=>$haber) :?>
            <!-- Widget contents -->
            <?php if($i === 0): ?>
                <div class="article-small">
                    <!--image-->
                    <a href="<?=$haber->link?>-<?=$haber->id?>" class="image">
                        <figure class="image-holder">
                            <img src="/user/files/wrap_<?=$haber->foto?>" alt="<?=lifos::convert_case_title($haber->baslik);?>">
                        </figure>
                        <div class="image-light"></div>
                        <span class="dashicons dashicons-format-standard"></span>
                    </a>

                    <!--content-->
                    <h5><a href="<?=$haber->link?>-<?=$haber->id?>"><?=lifos::substr($haber->baslik,45,'..')?></a></h5>
                    <p class="post-meta">
                        <a href="#"><span class="fa fa-clock-o"></span> <?php echo lifos::to_web_date($haber->tarih_yayin); ?></a> &nbsp;
                        <a href="#"><span class="fa fa-eye"></span> <?php echo $haber->hit; ?></a>
                    </p>
                    <hr>
                </div>
            <?php else: ?>
                <div>
                    <h5><a href="<?=$haber->link?>-<?=$haber->id?>"><?=lifos::substr($haber->baslik,45,'..')?></a></h5>
                    <p class="post-meta">
                        <a href="#"><span class="fa fa-clock-o"></span> <?php echo lifos::to_web_date($haber->tarih_yayin); ?></a> &nbsp;
                        <a href="#"><span class="fa fa-eye"></span> <?php echo $haber->hit; ?></a>
                    </p>
                    <hr>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
	</section><!--.widget-->
</div>

</main>

<?=$sag_menu_2?>

<!-- SLIDER TABS WIDGET: GALLERY -->
<section id="slider-tabs" class="widget no-mobile">
	<!-- Widget header -->
	<ul class="nav nav-tabs">
		<!--Title-->
		<li class="active"><a href="/index.php?b=blog/videolar" style="cursor: pointer;">Videolar</a></li>

		<!--Slider Controls-->

		<li class="pull-right control current"><a href="#gallery" data-slide="next"><span class="fa fa-chevron-right"></span></a></li>
		<li class="pull-right control current"><a href="#gallery" data-slide="prev"><span class="fa fa-chevron-left"></span></a></li>
	</ul>

	<!-- Tab Contents -->
	<div class="tab-content">
		<!-- Gallery Tab Content -->
		<div class="tab-pane active" id="gallery">
			<div class="slider-container">
				<ul class="da-thumbs">
                    <? foreach($videolar as $i=>$video) :?>
					<li>
						<a href="<?=$video->link.'-'.$video->id?>" title="<?=lifos::convert_case_title($video->baslik);?>" data-lightbox-gallery="silder-tabs-gallery">
							<div data-src="//img.youtube.com/vi/<?=strpos($video->ozet,',') ? substr($video->ozet,0,strpos($video->ozet,',')) : $video->ozet ?>/hqdefault.jpg" data-alt="<?=lifos::convert_case_title($video->baslik);?>"></div>
							<div class="image-caption">
								<h5><?=lifos::substr($video->baslik,45,'..')?></h5>
							</div>
							<span class="image-light"></span>
						</a>
					</li>
                    <? endforeach; ?>

				</ul>
			</div>
		</div>
	</div>
</section>


	
