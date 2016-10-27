<?=$message?>
<form name="frmIsverenKayit" method="POST" action="?b=aday/hesap">
<div class="uyekayitbilgi stdbg">
    <h1 class="baslik">Hesap Bilgileriniz</h1>
    <p>Sağdaki formda yer alan tüm bilgileri doldurun ve hesabınızı güncelleyin.<br><br> Bu bölümde yapacağınız değişiklikler özgeçimişinizi de etkiler.Şifrenizi değiştirmek istemiyorsanız eski şifre ve yeni şifre alanlarını boş bırakınız.</p>
</div>
<div class="uyekayit stdbg">
    <h1 class="baslik2">Aday Hesap Bilgileri</h1>
    <table class="standart">
        <tr><td width="160px">Adınız*</td><td><input type="text" name="ad" value="<?=$aday->ad?>" class="intext" valid="text"></td></tr>
        <tr><td>Soyadı*</td><td><input type="text" name="soyad" value="<?=$aday->soyad?>" class="intext" valid="text"></td></tr>
        <tr><td>TC Kimlik No</td><td><input type="text" name="tc" value="<?=$aday->tc?>" class="intext" valid="text"> <a href="https://tckimlik.nvi.gov.tr/" target="_blank"  >Öğrenmek için tıklayınız</a></td></tr>
        <tr><td>E-Posta Adresi*</td><td><input type="text" name="eposta" value="<?=$aday->eposta?>" disabled class="intext" valid="eposta"><div id="jxPosta"></td></tr>
        <tr><td>Cinsiyet</td><td><?=html::radiogroup('cinsiyet',site::$secenek_cinsiyet,$aday->cinsiyet)?></td></tr>
        <tr><td>Doğum Tarihi</td><td><input type="text" name="dogum_tarihi" valid="text" class="date intext" value="<?=towebdate($aday->tarih_dogum)?>" valid="sayi"></td></tr>
        <tr><td>Eski Şifre</td><td><input type="password" name="sifre_eski"  class="intext"> Şifre değiştirmek istiyorsanız giriniz.</td></tr>
        <tr><td>Yeni Şifre</td><td><input type="password" name="sifre1"  class="intext"></td></tr>
        <tr><td>Yeni Şifre Tekrar</td><td><input type="password" name="sifre2" class="intext"></td></tr>
        <tr><td></td><td><br><input type="submit" name="btnKaydet" value="Kaydet" class="btn2"><br><br></td></tr>
    </table>
</div>
</form>
<script type="text/javascript">
$(document).ready(function(){
    $('input[name=btnKaydet]').click(function(){
    	if(!fk()) return false;
    });	
});
   
</script>