<form name="frmAdayKayit" method="POST" action="?b=uye/yeni" class="yeni-uye">

	
	<div class="uyekayit span8">
	    <h3>Yeni Hesap Bilgileri</h3>
	    <?=$message?>
	    <div class="form2 connect">
	        <div>
	            <label for="tadi">Adınız ve Soyadınız*</label>
	            <input type="text" name="ad" value="<?=$_POST['ad']?>" valid="text" class="intext">
	        </div>

	        <div>
	            <label for="teposta">E-Posta Adresiniz*</label>
	            <input id="teposta" type="text" name="eposta" value="<?=$_POST['eposta']?>" valid="email" class="intext"><div id="jxPosta"></div>
	        </div>
	        <div>
	            <label for="tsifre1">Şifreniz*</label>
	            <input id="tsifre1" type="password" name="sifre1"  valid="text" class="intext">
	        </div>
	        <div>
	            <label for="tsifre2">Şifreniz Tekrar*</label>
	            <input id="tsifre2" type="password" name="sifre2" value="" valid="text" class="intext">
	        </div>
	        <div>
	            <label for="tulke">Ülke</label>
	            <?=html::select($ulkeler,'ulke','Türkiye','ad','ad',0)?>
	        </div>
	        <div>
	            <label for="tsehir">Şehir</label>
	            <?=html::select($sehirler,'sehir',$_POST['sehir'],'il','il',0,'- Seçiniz -')?>
	        </div>
	        <div>
	            <label for="ttel">Telefon</label>
	            <input id="ttel" type="text" name="tel" value="<?=$_POST['tel']?>" class="intext tel">
	        </div>
	        
	        <div class="dogum">
	            <label for="tdogum">Doğum Tarihi</label>
	            <?=html::select_range(1,31,'gun',false,false,false,1,'%02d')?>
	            <?=html::select_ay('ay')?>
	            <?=html::select_range(2000,1900,'yil')?>
	        </div>
	        
	        <div>
	            <label for="tcinsiyet">Cinsiyet</label>
	            <input type="radio" name="cinsiyet" value="1"> Bay <input type="radio" name="cinsiyet" value="0"> Bayan
	        </div>
	        
	        <div style="height:47px;"></div>
	        <div>
	        	<?=lifos::captcha('Değiştir');?>
	        </div>
	        
	        <div>
	            <label for="tsehir">Doğrulama Kodu</label>
	            <input id="tsehir" type="text" name="code" value="" class="intext">
	        </div>

	        <div style="clear:both;">
	            <input type="checkbox" name="sozlesme" value="1"><a href="#" onclick="window.open('/index.php?b=blog/hizmetsozlesmesi2','Hizmet Sözleşmesi','width=800,height=600'); return false;">Hizmet sözleşmesini</a> onaylıyorum.<br><br>
	            <input type="submit" name="btnYeniUye" value="Kaydet" class="btn btn-success"> 
	        </div>
	    </div>
	</div>
	
	<div class="uyekayitbilgi span4 well">
	    <h3>Üyelik Avantajları</h3>
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
	</div>
</form>


<script type="text/javascript" src="/static/v1/js/jquery.mask.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){

	$('.tel').mask('0 (999) 999 99 99');
	
	$('input[name=eposta]').change(function(){ 
		if( (/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/.test($(this).val())) )	{
			$.get('index.php?a=uye/eposta&d='+$(this).val(),function(r){ $('#jxPosta').html(r>=1 ? '<span style=\"color:red;\">Bu eposta zaten kayıtlı!</span>' : '' );}); 
		}
		else $('#jxPosta').html('<span style="color:red">Lütfen doğru bir eposta giriniz.</span>');
	});
    $('input[name=sifre2]').change(function(){ if( $(this).val() != $('input[name=sifre1]').val()) alert('Girilen Şifreler Uyuşmuyor'); });

    $('select[name=ulke]').change(function(){
		if( $(this).val()=='Türkiye' ) $('select[name=sehir]').removeAttr('disabled'); 
		else $('select[name=sehir]').attr('disabled','disabled'); 
    });
    
    $('form').submit(function(){ 
        var e='';
        if(!$('input[name=ad]').val()) e+='• Adınızı ve Soyadınızı girmediniz.\n';
        if(!$('input[name=eposta]').val()) e+='• Eposta adresinizi girmediniz.\n';
        else if( !(/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/.test($('input[name=eposta]').val())) )	 e+='• Eposta adresiniz yanlış.\n';
        if(!$('input[name=sifre1]').val()) e+='• Şifrenizi girmediniz.\n';
        else if($('input[name=sifre1]').val() != $('input[name=sifre2]').val()) e+='• Şifreleriniz uyuşmuyor.\n';
        else if($('input[name=sifre1]').val().length<5) e+='• Şifreniz en az 6 karakterden oluşmalı.\n';
        if(!$('[name=sozlesme]:checked').val()) e+='• Hizmet sözleşmesini onaylamadınız.\n';
        if(e) { alert(e); return false;}
    });
});
</script>