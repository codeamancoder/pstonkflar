<?=$navi?>
<?=$message?'<br>'.$message:''?>

<div class="span9">
	<h3>Hemen Ücretsiz Üye Olun!</h3>
	<p>Türkiye'nin en dinamik otomobil portalına hemen ücretsiz üye olun! Binlerce eşsiz içeriği okuyun, yorum yazın, ilan yayınlayın.</p>
	<ul>
		<li>Ücretsiz Üyelik</li>
		<li>7 Gün 24 Saat Kesintisiz Yayın</li>
		<li>İlan Başına 10 Fotoğraf Ekleyebilme</li>
		<li>Düşük Maliyet İle Gerçek Değerinde 2.El Otomobil Pazarı İmkânı</li>
		<li>Satışa / Kiraya Çıkartılan Otomobiller Hakkında Detaylı Bilgiler Sunma / Bulma</li> 
		<li>Onay Beklemeden Anında Yayın İmkânı</li>
		<li>Anlık Tıklanma Verisi</li>
		<li>İlan Verdiğiniz Otomobil / Ürün Hakkında Güncel Bilgilere Ulaşabilme Olanağı (Haber Sayfamız En Güncel Konuları, Dinamik Yazarları ve Zengin İçeriği İle Hemen Yanı Başınızda)
ve Daha Birçok Fırsat Sizleri Bekliyor.</li>
	</ul>
	<a href="?b=uye/yeni" class="btn btn-warning">Hemen Kayıt Ol</a>
</div>

<div class="span3 well">
     <form name="frmAdayLogin" method="POST" action="?b=uye/login">
         <h3>Üye Girişi</h3>
        
         <input type="text" name="eposta" class="intext" placeholder="Eposta Adresi"><br>
         <input type="password" name="sifre" class="intext" placeholder="Şifre"><br>
         <input type="submit" name="btnUyeLogin" value="Oturum Aç" class="btn">
         <a href="?b=uye/unuttum" style="float:right;display:inline-block;padding:5px;color:#888;">Şifremi Unuttum</a>
    </form>
 </div>
 
<script type="text/javascript">
$(document).ready(function(){
    $('input[name=btnAdayLogin]').click(function(){
    	if(!fk()) return false;
    });	
});
   
</script>