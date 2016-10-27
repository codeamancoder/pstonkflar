<? if($uye['tip'] == site::U_ADMIN):?>
<div class="yonetici-baslik">
	<?=$message?>
	<h4>Yönetici Ekranı</h4>
</div>
<div class="yonet">
	<h2>İçerik Yönetimi</h2>
	<ul>
		<li><a href="?b=uye/blog">Haber Yönetimi</a></li>
		<li><a href="?b=uye/video">Video Yönetimi</a></li>
		<li><a href="?b=uye/sayfa">Sayfa Yönetimi</a></li>
		<li><a href="?b=uye/anket">Anket Yönetimi</a></li>
		<li><a href="?b=uye/reklam">Reklam Yönetimi</a></li>
		<li><a href="?b=uye/galeri">Galeri Yönetimi</a></li>
		<li><a href="?b=uye/yorum">Yorumlar</a></li>
		<li><a href="?b=uye/parametre">Parametre Yönetimi</a></li>
		<li><a href="?b=uye/ayar">Ayarlar</a></li>
	</ul>
</div>••••••
<div class="yonet">
	<h2>İlan Yönetimi</h2>
	<ul>
		<li><a href="?b=uye/ilan">İlanlar</a></li>
		<li><a href="?b=uye/ilan/yayindisi">Yayında Olmayan İlanlar</a></li>
		<li><a href="?b=uye/favori">Favori İlanlarım</a></li>
		<li><a href="?b=uye/favori/uye">Favori Üyelerim</a></li>
		<li><a href="?b=uye/sikayet">Şikayetler</a></li>
		<li><a href="?b=uye/odemeler">Ödemeler</a></li>
	</ul>
</div>
<div class="yonet">
	<h2>Üyeler</h2>
	<ul>
		<li><a href="?b=uye/uyeadmin">Üye Yönetimi</a></li>
		<li><a href="?b=uye/yazar">Yazar Listesi</a></li>
		<li><a href="?b=uye/magazalar">Mağaza Listesi</a></li>
	</ul>
</div>
<div class="yonet">
	<h2>Mesajlar</h2>
	<ul>
		<li><a href="?b=uye/mesaj/gelen">Gelen Kutusu</a></li>
		<li><a href="?b=uye/mesaj/giden">Giden Kutusu</a></li>
	</ul>
</div>
<div class="yonet">
	<h2>Kullanıcı</h2>
	<ul>
		<li><a href="?b=uye/hesabim">Kullanıcı Bilgilerim</a></li>
	</ul>
</div>

<? elseif($uye['tip'] == site::U_YAZAR):?>
<div class="yonetici-baslik">
	<?=$message?>
	<h4>Hesabım</h4>
</div>
<div class="yonet">
	<h2>İçerik Yönetimi</h2>
	<ul>
		<li><a href="?b=uye/blog">Haber Yönetimi</a></li>
		<li><a href="?b=uye/galeri">Galeri Yönetimi</a></li>
		<li><a href="?b=uye/bilgi">Ayarlar</a></li>
	</ul>
</div>
<div class="yonet">
	<h2>İlan Yönetimi</h2>
	<ul>
		<li><a href="?b=uye/ilan">İlanlarım</a></li>
		<li><a href="?b=uye/ilan/bekleyen">Yeni İlan</a></li>
		<li><a href="?b=uye/ilan/yayindisi">Yayında Olmayan İlanlar</a></li>
		<li><a href="?b=uye/favori">Favori İlanlarım</a></li>
		<li><a href="?b=uye/favori/uye">Favori Üyelerim</a></li>
		<li><a href="?b=uye/odemeler">Ödemelerim</a></li>
	</ul>
</div>
<div class="yonet">
	<h2>Mesajlar</h2>
	<ul>
		<li><a href="?b=uye/mesaj/gelen">Gelen Kutusu</a></li>
		<li><a href="?b=uye/mesaj/giden">Giden Kutusu</a></li>
	</ul>
</div>
<div class="yonet">
	<h2>Kullanıcı</h2>
	<ul>
		<li><a href="?b=uye/hesabim">Kullanıcı Bilgilerim</a></li>
	</ul>
</div>
<? elseif($uye['tip'] == site::U_UYE):?>
<div class="yonetici-baslik">
	<?=$message?>
	<h4>Hesabım</h4>
</div>
<div class="yonet">
	<h2>Galeri Yönetimi</h2>
	<ul>
		<li><a href="?b=uye/galeri">Galerilerim</a></li>
		<li><a href="?b=uye/galeri/yeni">Yeni galeri</a></li>
	</ul>
</div>
<div class="yonet">
	<h2>İlan Yönetimi</h2>
	<ul>
		<li><a href="?b=uye/ilan">İlanlarım</a></li>
		<li><a href="?b=uye/ilan/yeni">Yeni İlan Oluştur</a></li>
		<li><a href="?b=uye/ilan/yayindisi">Yayında Olmayan İlanlar</a></li>
		<li><a href="?b=uye/favori">Favori İlanlarım</a></li>
		<li><a href="?b=uye/favori/uye">Favori Üyelerim</a></li>
		<!-- <li><a href="?b=uye/odemeler">Ödemeler</a></li> -->
	</ul>
</div>
<div class="yonet">
	<h2>Mesajlar</h2>
	<ul>
		<li><a href="?b=uye/mesaj/gelen">Gelen Kutusu</a></li>
		<li><a href="?b=uye/mesaj/giden">Giden Kutusu</a></li>
	</ul>
</div>
<div class="yonet">
	<h2>Kullanıcı</h2>
	<ul>
		<li><a href="?b=uye/hesabim">Kullanıcı Bilgilerim</a></li>
	</ul>
</div>
<?/*<div class="yonet">
	<h2>Mağaza</h2>
	<ul>
		<?=!$_SESSION['uye']['magaza_id']? '<li><a href="?b=uye/magaza/yeni">Mağaza Oluştur</a></li>':''?>
		<?=$_SESSION['uye']['magaza_id']? '<li><a href="?b=uye/magaza/ayar">Mağaza Ayarları</a></li>':''?>
	</ul>
</div>
*/?>
<? endif; ?>

