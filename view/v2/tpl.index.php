<!DOCTYPE html>
<?php
$html_id = 'home-version-2';
if(isset($_SESSION['html_id'])) {
		$html_id = $_SESSION['html_id'];

}
?>
<html id="<?php echo $html_id; ?>">
<head>
    <title><?php echo !empty($site->title) ? $site->title.' -' : '';?> Piston Kafalar</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="piston, otomobil, araba, kafa, otomobil testleri, kampanyalar, haberler, galeri, otomobil fuarı, motorsporları, sıfır km otomobil, çevreci otomobil">
    <meta name="description" content="Otomotiv sektörü ile alakalı güncel haber, alım satım, 2.el ilan, yenilik, motorsporları, kampanya ve makalelerin olduğu web sitesi">


	<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700' rel='stylesheet' type='text/css'>

    <link href="<?php echo get_asset('style.min.css', 'css'); ?>" rel="stylesheet" media="screen">
    <link href="<?php echo get_asset('style.css', 'css'); ?>" rel="stylesheet" media="screen">

	<!-- jQuery  -->
	<?php if(isset($_GET['b']) && strpos($_GET['b'], 'uye/') !== FALSE && $_GET['b'] !== 'uye/login' && $_GET['b'] !== 'uye/yeni' && $_GET['b'] !== 'uye/unuttum'): ?>
		<script src="<?php echo get_asset('jquery-1.7.2.min.js', 'js'); ?>"></script>
	<?php else: ?>
	<script src="<?php echo get_asset('jquery.min.js', 'js'); ?>"></script>
	<?php endif;?>

	<?php if($_GET['b'] !== 'uye/galeri/duzenle' && $_GET['b'] !== 'uye/galeri/yeni'): ?>
		<script src="<?php echo get_asset('jquery-ui.min.js', 'js'); ?>"></script>
	<?php endif; ?>

	<?php if(isset($_GET['b']) && strpos($_GET['b'], 'uye/') !== FALSE && $_GET['b'] !== 'uye/login' && $_GET['b'] !== 'uye/yeni' && $_GET['b'] !== 'uye/unuttum'): ?>
		<link href="<?php echo get_asset('bootstrap.css', 'css'); ?>" rel="stylesheet" media="screen">
		<script src="<?php echo get_asset('bootstrap.min.js', 'js'); ?>"></script>
	<?php endif; ?>




	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries
               ie8.css and ie8.js custom style  and script that needed for IE8. -->
	<!--[if lt IE 9]>
	<link href="css/ie8.css" rel="stylesheet">
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<script src="js/ie8.js"></script>
	<![endif]-->


    <?=$site->relimg?>
    <link rel="alternate" href="/index.php?b=main/feed" title="RSS FEED" type="application/rss+xml" />

</head>

<body>
<!--HEADER
==========-->
<header>
	<!-- TOP NAVBAR
    =============== -->
	<nav class="navbar navbar-inverse" id="top-nav" role="navigation">
		<div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#top-nav-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="top-nav-collapse">
				<ul class="nav navbar-nav">
					<li><a href="/">Anasayfa</a></li>
					<li><a href="/kunye-64">Künye</a></li>
					<li><a href="/iletisim-102">İletişim</a></li>
				</ul>

				<form class="navbar-form navbar-right" role="search" method="get">
					<label class="sr-only" for="top_search_form">Arama</label>
					<input id="top_search_form" type="search" name="q" placeholder="Ara">
					<input type="hidden" name="b" value="blog/arama">
					<button type="submit" >
						<span class="fa fa-search"></span>
						<span class="sr-only">Arama</span>
					</button>
				</form>

				<ul class="nav navbar-nav navbar-right">
					<li><a href="https://tr-tr.facebook.com/pages/PistonKafalarcom/248533941841376?ref=stream" target="_blank" title="Facebook"><span class="sc-sm sc-dark sc-facebook"></span></a></li>
					<li><a href="https://twitter.com/PistonKafalar" target="_blank" title="Twitter"><span class="sc-sm sc-dark sc-twitter"></span></a></li>
					<li><a href="http://tr.linkedin.com/pub/piston-kafalar/71/76b/a79" target="_blank" title="Linkedin"><span class="sc-sm sc-dark sc-linkedin"></span></a></li>
					<li><a href="http://www.youtube.com/channel/UCTGsBdlza14EZc-49y9cw7w/videos" target="_blank" title="Linkedin"><span class="sc-sm sc-dark sc-youtube"></span></a></li>
					<li><a href="/?b=main/feed" title="RSS"><span class="sc-sm sc-dark sc-rss"></span></a></li>
				</ul>
			</div>
		</div>
	</nav><!-- #top-nav -->

	<!-- MAIN NAVBAR
    ================ -->
	<nav class="navbar navbar-default" id="main-nav" role="navigation">
		<div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-nav-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/"><img src="/static/v2/img/logox.png" alt="logo"></a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="main-nav-collapse">
				<ul class="nav navbar-nav navbar-right" style="border-bottom: 1px solid #f4f4fc;">
					<li class="<?php echo $_GET['b'] == '' ? 'active' : ''; ?>"><a href="/"><i class="fa fa-home"></i></a></li>
					<li class="dropdown <?php echo $_GET['b'] == 'blog/haberler' ? 'active' : ''; ?>">
						<a href="/blog/haberler" class="dropdown-toggle">Haberler</a>
					</li>

					<li class="dropdown <?php echo $_GET['b'] == 'blog/sektorel' ? 'active' : ''; ?>">
						<a href="/blog/sektorel" class="dropdown-toggle">Sektörel</a>
					</li>

					<li class="dropdown <?php echo $_GET['b'] == 'blog/yenilikler' ? 'active' : ''; ?>">
						<a href="/blog/yenilikler" class="dropdown-toggle">Yenilikler</a>
					</li>

					<li class="dropdown <?php echo $_GET['b'] == 'blog/test' ? 'active' : ''; ?>">
						<a href="/blog/test" class="dropdown-toggle">Test</a>
					</li>

					<li class="dropdown <?php echo $_GET['b'] == 'blog/motorspor' ? 'active' : ''; ?>">
						<a href="/blog/motorspor" class="dropdown-toggle">Motor Sporları</a>
					</li>

					<li class="dropdown <?php echo $_GET['b'] == 'blog/modifiye' ? 'active' : ''; ?>">
						<a href="/blog/modifiye" class="dropdown-toggle">Modifiye</a>
					</li>

					<?php $other_menu = array('blog/lifestyle','blog/diecast','blog/galeriler','blog/videolar'); ?>
					<li class="dropdown <?php echo in_array($_GET['b'], $other_menu) ? 'active' : ''; ?>">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Diğer <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="/blog/lifestyle">Life Style</a></li>
							<li><a href="/blog/diecast">Model Otomobiller</a></li>
							<li class="divider"></li>
							<li><a href="/blog/galeriler">Galeri</a></li>
							<li><a href="/blog/videolar">Video</a></li>
						</ul>
					</li>

					<?php $other_menu2 = array('uye/login','uye/yeni','uye'); ?>
					<li class="dropdown <?php echo in_array($_GET['b'], $other_menu2) ? 'active' : ''; ?>">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Üyelik <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<?php if(isset($_SESSION['uye'])) { ?>
								<li><a href="/index.php?b=uye">Hesabım</a></li>
								<li><a href="/index.php?b=uye/logout">Çıkış</a></li>
							<?php } else { ?>
							<li><a href="/index.php?b=uye/login">Giriş Yap</a></li>
							<li class="divider"></li>
							<li><a href="/index.php?b=uye/yeni">Üye Ol</a></li>
							<?php } ?>
						</ul>
					</li>

				</ul>
			</div>
		</div>
	</nav><!--#main-nav-->

	<!-- PAGE TITLE -->
	<div id="title">
		<div class="image-light"></div>
<!--		<div class="container">-->
<!--			<div class="title-container">-->
<!--				<h3 class="primary">Piston Kafalar</h3>-->
<!--				<p class="secondary">Türkiye'nin en dinamik otomobil portalı</p>-->
<!--			</div>-->
<!--		</div>-->
	</div>
</header>

<!-- CONTENT
           ============ -->
<div id="content">
	<div class="container">
		<div class="row">
			<!-- Admatic interstitial 800x600 Ad Code START -->
			<ins data-publisher="adm-pub-187309742212" data-ad-type="interstitial" class="adm-ads-area" data-ad-network="165133470768" data-ad-sid="209" data-ad-width="800" data-ad-height="600"></ins>
			<script src="//cdn2.admatic.com.tr/showad/showad.js" async></script>
			<!-- Admatic interstitial 800x600 Ad Code END -->
	    	<?=$site->html?>

    </div><!--.container-->
</div><!--#content-->


	<footer>
		<!-- MAIN FOOTER
        ================ -->
		<div id="footer-main">
			<div class="container">
				<div class="row">
					<section class="col-md-3 col-sm-6">
						<div class="title"><a href="#"><h4>Hakkımızda</h4></a></div>
						<ul class="categories">
							<li><a href="/kunye-64"><i class="fa fa-angle-right"></i> Künye</a></li>
							<li><a href="/iletisim-102"><i class="fa fa-angle-right"></i> İletişim</a></li>
							<li><a href="/markamiz-136"><i class="fa fa-angle-right"></i> Markamız</a></li>
						</ul>
					</section>
					<section class="col-md-3 col-sm-6">
						<div class="title"><a href="#"><h4>Hizmetlerimiz</h4></a></div>
						<ul class="categories">
							<li><a href="/doping-181"><i class="fa fa-angle-right"></i> Doping</a></li>
							<li><a href="/blog/reklam"><i class="fa fa-angle-right"></i> Reklam</a></li>
						</ul>
					</section>
					<section class="col-md-3 col-sm-6">
						<div class="title"><a href="#"><h4>Gizlilik ve Kullanım</h4></a></div>
						<ul class="categories">
							<li><a href="/kullanim-kosullari-66"><i class="fa fa-angle-right"></i> Kullanım Koşulları</a></li>
							<li><a href="/uyelik-sozlesmesi-63"><i class="fa fa-angle-right"></i> Üyelik Sözleşmesi</a></li>
							<li><a href="/gizlilik-politikasi-62"><i class="fa fa-angle-right"></i> Gizlilik Politikası</a></li>
							<li><a href="/satis-sozlesmesi-183"><i class="fa fa-angle-right"></i> Satış Sözleşmesi</a></li>
							<li><a href="/blog/yardim"><i class="fa fa-angle-right"></i> Yardım</a></li>
						</ul>
					</section>
					<section class="col-md-3 col-sm-6">
						<div class="title"><a href="#"><h4>Mobil Uygulamalar</h4></a></div>
						<img src="<?php echo get_asset('mobil.png'); ?>">
					</section>


				</div><!--.row-->
			</div><!--.container-->
		</div><!--#footer-main-->

		<!-- FOOTER BOTTOM
        ================== -->
		<div id="footer-bottom">
			<div class="container">
				<p>Copyright &copy; 2011 - <?php echo date('Y'); ?>  <strong>Pistonkafalar.com</strong></p>
			</div>
		</div><!--#footer-bottom-->
	</footer><!--footer-->

	<!-- Theme scripts -->
	<script src="<?php echo get_asset('script.min.js"', 'js'); ?>"></script>
	<script src="<?php echo get_asset('initialize.js', 'js'); ?>"></script>
	<?php if(isset($_GET['b']) && strpos($_GET['b'], 'uye/') === FALSE && $_GET['b'] !== 'uye/login' && $_GET['b'] !== 'uye/yeni' && $_GET['b'] !== 'uye/unuttum'): ?>
		<script src="<?php echo get_asset('bootstrap.3.3.5.min.js', 'js'); ?>"></script>
	<?php endif; ?>
	<script src="<?php echo get_asset('j.js', 'js'); ?>"></script>

	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
				(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-10375901-22', 'pistonkafalar.com');
		ga('send', 'pageview');

	</script>
	<?php
	if(isset($_POST['postala']))
	{
		$email      = $_POST["email"];
		$adres      = "info@pistonkafalar.com";
		$konu       = "Haber Bulteni";
		$tarih      = date('Y-m-d');
		$ip_adresi  = $_SERVER['REMOTE_ADDR'];
		if(($email==""))
		{
			echo '<script type="text/javascript">alert("Lütfen E-Posta Adresi Giriniz.");</script>';
		}
		else
		{
			$mesajveri.="Haber Bulteni\n\n";
			$mesajveri.="E-Posta Adresi :  ".$email."\n";
			$mesajveri.="IP Adresi   :".$ip_adresi."\n";
			$mesajyolla = mail($adres, $konu, $mesajveri);
			if($mesajyolla)
			{
				echo '<script type="text/javascript">alert("İletiniz Bize Ulaşmıştır.");</script>';
			}
			else
			{
				echo '<script type="text/javascript">alert("E-Mail gönderilirken hata oluştu! Lütfen daha sonra tekrar deneyiniz.");</script>';
			}
		}
	}
	?>
	<div id="dialog" class="modal fade" tabindex="-1" role="dialog""></div>
</body>
</html>








