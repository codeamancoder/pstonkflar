<!doctype html>
<html>
<head>
	<title>Piston Kafalar<?=$site->title?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="piston, otomobil, araba, kafa, otomobil testleri, kampanyalar, haberler, galeri, otomobil fuarı, motorsporları, sıfır km otomobil, çevreci otomobil">
	<meta name="description" content="Otomotiv sektörü ile alakalı güncel haber, alım satım, 2.el ilan, yenilik, motorsporları, kampanya ve makalelerin olduğu web sitesi">

	<link href="<?php echo get_asset('style.css', 'css'); ?>" rel="stylesheet" media="screen">
	<link href="<?php echo get_asset('bootstrap.css', 'css'); ?>" rel="stylesheet" media="screen">
	<link href="<?php echo get_asset('fancybox/jquery.fancybox.css', 'lib', TRUE); ?>" rel="stylesheet">
	<?=$site->relimg?>
	<link rel="alternate" href="/index.php?b=main/feed" title="RSS FEED" type="application/rss+xml" />
	<script src="<?php echo get_asset('jquery-1.7.2.min.js', 'js'); ?>"></script>
	<script src="<?php echo get_asset('j.js', 'js'); ?>"></script>
	<script src="<?php echo get_asset('bootstrap.min.js', 'js'); ?>"></script>
</head>
<body>
<a href="#" class="scrollup">Scroll</a>
<div class="ustrenk"></div>
<div class="ana">
	<div class="ust">
		<div class="logo"><a href="/"><img src="/static/v1/img/logo.png"></a></div>
		<div class="reklam">
			<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			<!-- Üst Reklam Alanı -->
			<ins class="adsbygoogle"
				 style="display:inline-block;width:468px;height:60px"
				 data-ad-client="ca-pub-1034370367466687"
				 data-ad-slot="4724464309"></ins>
			<script>
				(adsbygoogle = window.adsbygoogle || []).push({});
			</script>
			<?=$site->reklam_ust?></div>
		<div class="login_menu"><?=$site->menu_login?></div>
		<div class="ustmenu"><?=$site->menu?></div>
		<div class="duyuru-arama">
			<div class="arama">
				<? if( getRequest('b',0) == 'ilan'): ?>
					<a href="/index.php?b=ilan/arama">Detaylı Arama</a>
					<form name="frmArama" method="get">
						<input type="hidden" name="b" value="ilan">
						<input type="text" name="anahtar" placeholder="Ne Aramıştınız ?">
						<input type="submit" name="ara" value="">
					</form>
				<? else :?>
					<a href="/index.php?b=blog/arama">Detaylı Arama</a>
					<form name="frmArama" method="get">
						<input type="hidden" name="b" value="blog/arama">
						<input type="text" name="q" placeholder="Ne Aramıştınız ?">
						<input type="submit" name="ara" value="">
					</form>
				<? endif; ?>
			</div>
			<div class="sonduyuru">
				<? if($site->duyuru): ?>
					<div class="items">
						<? foreach ($site->duyuru as $duyuru):?>
							<div><a href="/<?=$duyuru->link.'-'.$duyuru->id?>"><?=lifos::substr($duyuru->baslik,45,'...')?></a></div>
						<? endforeach;?>
					</div>
					<script type="text/javascript" src="/static/v1/js/jquery.tools.min.js"></script>
				<? endif; ?>
			</div>
		</div>
	</div>
	<div class="orta">
		<?=$site->html?>
	</div>
</div>
<div id="dialog" class="modal hide fade" tabindex="-1" role="dialog"">babab</div>
<div class="footer">
	<div class="blok1">
		<h1>Hakkımızda</h1>
		<ul>
			<li><a href="/kunye-64">Künye</a></li>
			<li><a href="/iletisim-102">İletişim</a></li>
			<li><a href="/markamiz-136">®</a></li>
		</ul>
	</div>
	<div class="blok2">
		<h1>Hizmetlerimiz</h1>
		<ul>
			<li><a href="/doping-181">Doping</a></li>
			<li><a href="/magaza-182">Mağaza</a></li>
			<li><a href="/index.php?b=blog/reklam">Reklam</a></li>
		</ul>
	</div>
	<div class="haberbulten">
		<h1>Haber Bülteni</h1>
		<p>PistonKafalar.com kampanya ve fırsatlarından Haberdar Olun ! </p>
		<form action="index.php" method="post">
			<input type="text" placeholder="e-posta adresi" name="email" class="a" >
			<input class="d" type="submit" name="postala" value="Gönder">
		</form>

	</div>
	<div class="blok3">
		<h1>Gizlilik ve Kullanım</h1>
		<ul>
			<li><a href="/kullanim-kosullari-66">Kullanım Koşulları</a></li>
			<li><a href="/uyelik-sozlesmesi-63">Üyelik Sözleşmesi</a></li>
			<li><a href="/gizlilik-politikasi-62">Gizlilik Politikası</a></li>
			<li><a href="/satis-sozlesmesi-183">Satış Sözleşmesi</a></li>
			<li><a href="/ilan-verme-kurallari-65">İlan Verme Kuralları</a></li>
			<li><a href="/index.php?b=blog/yardim">Yardım</a></li>
		</ul>

		<img src="/static/v2/img/visa.png" style="margin-top:-5px;">
	</div>
	<div class="blok4">
		<h1>Mobil Uygulamalar</h1>
		<img src="/static/v2/img/mobil.png" alt="mobil">
		<div class="sosyalag">
			<p>Bizi Takip Edin</p>
			<a href="https://tr-tr.facebook.com/pages/PistonKafalarcom/248533941841376?ref=stream" target="_blank" title="Facebook"><img src="/static/v1/img/facebook.png" alt="Facebook" width="25"></a>
			<a href="https://twitter.com/PistonKafalar" target="_blank" title="Twiiter"><img src="/static/v1/img/twitter.png" alt="Twiiter" width="25"></a>
			<a href="http://tr.linkedin.com/pub/piston-kafalar/71/76b/a79" target="_blank" title="Linkedin"><img src="/static/v1/img/linkedin.png" alt="LinkedIn" width="25"></a>
			<a href="http://www.youtube.com/channel/UCTGsBdlza14EZc-49y9cw7w/videos" target="_blank" title="Youtube"><img src="/static/v1/img/youtube.png" alt="Youtube"  width="25"></a>
			<a href="/?b=main/feed" target="_blank" title="Rss"><img src="/static/v1/img/rss.png" alt="Rss" width="25"></a>
		</div>
	</div>
	<div class="telif">
		<p>Copyright © 2011-<?=date("Y")?> PistonKafalar.com  <span class="lifos gizli">by <a href="http://www.lifos.net" title="Tasarım ve Programlama Lifos Yazılım" target="_blank">Lifos</a></span></p>
	</div>
</div>

<? if(isset($_SESSION['popup']) && (1==2)):?>
	<a href="popup.html" rel="#popup" class="popac"></a>
	<div id="popup"></div>

	<script type="text/javascript" src="/static/v1/js/jquery.fancybox.pack.js"></script>
	<script type="text/javascript">
		$(window).load(function(){
			$("a[rel]").fancybox({
				'width'				: '100%',
				'height'			: '200',
				'autoScale'     	: false,
				'autoSize'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});

			$('.popac').click();
		});
	</script>
	<? $_SESSION['popup'] = 1; ?>
<? endif;?>

<script type="text/javascript">
	$(document).ready(function(){
		$(window).scroll(function(){
			if ($(this).scrollTop() > 100) {
				$('.scrollup').fadeIn();
			} else {
				$('.scrollup').fadeOut();
			}
		});

		$('.scrollup').click(function(){
			$("html, body").animate({ scrollTop: 0 }, 600);
			return false;
		});

	});

</script>
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
</body>
</html>
