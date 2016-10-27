<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-language" content="TR" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="keywords" content="<?=$meta_key?>">
<meta name="description" content="<?=$meta_desc?>">
<meta name="abstract" content="<?=$meta_desc?>">
<meta name="classification" content="<?=$meta_key?>">
<meta name="rating" content="All" />
<meta name="googlebot" content="index, follow" />
<meta name="robots" content="all" />
<meta name="robots" content="index, follow" />
<meta name="author" content="<?=$_SERVER['SERVER_NAME']?>" />
<link rel="canonical" href="<?=$meta_canon?>"/>	
<meta name="Revisit-After" content="7" />
<title><?=$title?></title>
<?=$files?>
<script src="/static/js/lec-1.0.0.js" language="javascript"></script>
<? if($anasayfa){?>
<link rel="stylesheet" href="<?=$dir?>/css/default.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?=$dir?>/css/nivo-slider.css" type="text/css" media="screen" />

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
<? }?>
</head>
<body>
<a href="#" class="scrollup">Scroll</a>
<div class="ust-renk"></div>
<div class="ust">
	<div class="logo"><?=$logo?></div>
	<div class="sepetarama">
		<div class="sepet-sayi"><p>Sepetinizde ( <a href="/sepet"><span class="jx-sepeturunsayisi"><?=get_sepet_urun_sayisi()?></span>  </a>) ürün vardır.</p></a></div>
	</div>

	<div class="resimliustmenu">
		<ul>
			<li class="gorsel"><a href="/index.php">Ana Sayfa</a></li>
			<li class="gorsel1"><a href="/sepet">Sepet</a></li>
			<? if(!isset($_SESSION['uye'])): ?>
			<li class="gorsel2"><a href="/uye">Üye Giriş</a></li>
			<li class="gorsel3"><a href="/uye/yeni">Yeni Üye</a></li>
			<? else:?>
			<li class="gorsel5"><a href="/uye">Hesabım</a></li>
		<? endif; ?>
			<li class="gorsel4"><a href="/iletisim">İletişim</a></li>
		</ul>  
	</div>		
	<div class="blok-ust"><?=$ust?></div>
	<div class="arama"><?=mod("urunler","arama")?></div>
	<div class="linkbar">
		<ul>
			<li><a href="https://pistonkafalar.com/">Haber Sayfası</a></li>
			<li><a href="https://www.pistonkafalar.com/index.php?b=ilan">İlan Sayfası</a></li>
		</ul>
	</div>
</div>

<div class="ana">
<div class="yenilastikara">
	<?=mod('urunler','lastikara')?>
</div>
<? if($anasayfa){?>
	<div class="sayfa">
		<div class="orta">
			<div id="sol" class="blok-yan"><?=$sol?></div>
				<div class="banneralan">
					<div class="banner">
						<div class="slider-wrapper theme-default">
							<div id="slider" class="nivoSlider">
								<img src="<?=$dir?>/img/banner.jpg" alt="Piston E-Ticaret"/>
								<img src="<?=$dir?>/img/banner1.jpg" alt="Piston E-Ticaret"/>
							</div>
						</div>
					</div>	
					<div class="banneryan">
						<div class="yan1">
							<h5>Aynı Gün Kargo</h5>
							<p>Saat 15:00’a kadar olan siparişleriniz aynı gün kargo</p>
						</div>
						<div class="yan2">
							<h5>Ücretsiz Kargo</h5>
							<p>Sipariş verdiğiniz her üründe kargo ücretsiz</p>
						</div>
						<div class="yan3">
							<h5>Ücretsiz Üye Olun</h5>
							<p>Üye girişi için <a href="/uye">tıklayınız</a></p>
							<p>Kayıt olmak için <a href="/uye/yeni">tıklayınız</a></p>
						</div>
						<div class="yan4">
							<h5>24/7 Kesintisiz Destek</h5>
							<p>info@pistonkafalar.com</p>
						</div>						
					</div>
				</div>				
			<div id="ic"  class="blok-icerik anasayfa">
				<? if($anasayfa) {?>
					<h1>Vitrin Ürünleri</h1>
					<?=$ic?>
				<?}?>
			</div>
		</div>
	</div>
<? }else{?>
	<div class="sayfa">
		<div class="orta">
			<div id="sol" class="blok-yan"><?=$sol?></div>
			<div id="ic"  class="blok-icerik"><?=$ic?></div>
		</div>
	</div>
<?}?>
</div> 
<div class="footer">
		<div class="menu1">
			<h1>Müşteri Hizmetleri</h1>
			<ul>
				<li><a href="/sozlesme/2/mesafeli-satis-sozlesmesi.html">Mesafeli Satış Sözleşmesi</a></li>
				<li><a href="/sozlesme/1/uyelik-sozlesmesi.html">Üyelik Sözleşmesi</a></li>
				<li><a href="/sozlesme/3/gizlilik-ve-guvenlik.html">Gizlilik ve Güvenlik</a></li>
				<li><a href="/sozlesme/4/odeme-ve-teslimat-sartlari.html">Ödeme ve Teslimat Şartları</a></li>
				<li><a href="/sayfa/5/kurumsal.html">Kurumsal</a></li>
			</ul>
		</div>
		<div class="menu2">
			<h1>Üyelik İşlemleri</h1>
			<ul>
				<li><a href="/uye/yeni">Yeni Üye</a></li>
				<li><a href="/uye">Üye Girşi</a></li>
				<li><a href="/uye/unuttum">Şifremi Unuttum</a></li>
				<li><a href="/sayfa/2/sss.htmll">Sık Sorulan Sorular</a></li>
				<li><a href="/iletisim">İletişim</a></li>
			</ul>
		</div>
		<div class="menu3">
			<h1>İletişim Bilgileri</h1>
			<p><span>Adres :</span> Gülük Mah. Karakuş Sokak Eras İş Merkezi Kat:6 No:607 Melikgazi / KAYSERİ</p>
			<p><span>Telefon :</span> +90 (352) 320 10 38</p>
			<p><span>Faks :</span> +90 (352) 320 10 48</p>
			<p><span>Mail :</span> info@pistonkafalar.com</p>	
		</div>		
		<div class="menu4">
			<h1>Güvenlik</h1>
				<img src="<?=$dir?>/img/guvenlik.png"><br><br>
			<h1>Bizi Takip Edin</h1>
			<div class="sosyalag">
				<a href="https://tr-tr.facebook.com/pages/PistonKafalarcom/248533941841376?ref=stream" target="_blank"><img src="<?=$dir?>/ikon/facebook.png" alt="Facebook"></a>
				<a href="https://twitter.com/PistonKafalar" target="_blank"><img src="<?=$dir?>/ikon/twitter.png" alt="Twitter"></a>
				<a href="http://tr.linkedin.com/pub/piston-kafalar/71/76b/a79" target="_blank"><img src="<?=$dir?>/ikon/indes.png" alt="İndesing"></a>
				<a href="http://www.youtube.com/channel/UCTGsBdlza14EZc-49y9cw7w/videos" target="_blank"><img src="<?=$dir?>/ikon/youtube.png" alt="Youtube"></a>
				<a href="/feed" target="_blank"><img src="<?=$dir?>/ikon/rss.png" alt="Rss"></a>
			</div>			
		</div>	
	<div class="telifalan">
		<p>Copyright © 2011-<?=date("Y")?> Her hakkı saklıdır.</p>
	</div>
</div>
<script type="text/javascript" src="<?=$dir?>/js/jquery.nivo.slider.js"></script>
<script type="text/javascript">
    $(window).load(function() {
        $('#slider').nivoSlider();
    });
</script>
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
</body>
</html>
