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
			<?=$blog->icerik?>
		</div><!-- .entry-content -->

	</article><!-- .hentry -->


</main><!--#main-content-->

<?=$sag_menu_2?>