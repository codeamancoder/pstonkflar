
<!-- MAIN CONTENT
                                       ================= -->
<main id="main-content" class="col-md-8">
	<?=$duyuru;?>
	<?=$message?>
	<!-- POST CONTENT -->
	<article class="article-large hentry">

	<header class="show">
		<h1 class="entry-title">Galeriler</h1>
	</header>

	<div class="entry-content">
		<!-- IMAGES -->
		<div class="images">
			<ul class="da-thumbs clearfix">
<? foreach($galeriler as $blog):?>
				<li>
					<a href="/<?=$blog->link.'-'.$blog->id?>" title="<?=$blog->baslik?>">
						<img src="/user/files/wrap_<?=$blog->kapak?>" alt="<?=$blog->baslik?>" style="height: 120px !important;">
						<div class="image-caption">
							<h5><?=$blog->baslik?></h5>
						</div>
						<span class="image-light"></span>
					</a>
				</li>
<? endforeach;?>
			</ul>

		</div>
		</div>
	</article>
	<?=$pager?>

</main><!--#main-content-->

<?=$sag_menu_2?>