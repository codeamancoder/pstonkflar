<!-- MAIN CONTENT
                                       ================= -->
<main id="main-content" class="col-md-8">
	<?=$duyuru;?>
	<?=$message?>
	<!-- POST CONTENT -->
	<article class="article-large hentry">

		<header class="show">
			<h1 class="entry-title">Videolar</h1>
		</header>

		<div class="entry-content">
			<!-- IMAGES -->
			<div class="images">
				<ul class="da-thumbs clearfix">
					<? foreach($videolar as $blog):?>
						<li>
							<a href="/<?=$blog->link.'-'.$blog->id?>" title="<?=$blog->baslik?>">
								<img src="https://img.youtube.com/vi/<?=strpos($blog->ozet,',') ? substr($blog->ozet,0,strpos($blog->ozet,',')) : $blog->ozet?>/hqdefault.jpg" height="117" lt="<?=$blog->baslik?>">
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