<? if($blok=='yan-login'):?>
	<h1>Üye Girişi</h1>
	<form method="post" action="https://www.pistonkafalar.com/?b=uye/login&ref=eticaret">
	<table>
		<tr><td>E-Posta:</td><td><input type="text" name="eposta" autocomplete="off"/></td></tr>
		<tr><td>Şifre:</td><td><input type="password" name="sifre" autocomplete="off"/></td></tr>
		<tr><td></td><td><input type="submit" name="btnUyeLogin" value="Giriş"/></td></tr>
		<tr><td colspan=2><a href="https://www.pistonkafalar.com/?b=uye/yeni">Üye Olun</a> | <a href="https://www.pistonkafalar.com/?b=uye/unuttum&ref=eticaret">Şifre Hatırlat</a></td></tr>
	</table>
	</form>



<? elseif($blok=='yan-login-bilgi'): ?>
	<h1>Oturum Bilgisi</h1>
	<ul>
		<li>Hoşgeldiniz <b><?=$uye['isim']?></b></li>
		<li><a href="/uye/siparislerim">Siparişlerim</a></li>
		<li><a href="/uye/adreslerim">Adres Bilgilerim</a></li>
		<li><a href="/uye/bilgilerim">Üyelik Bilgilerim</a></li>
		<li><a href="/uye/destek">Destek Taleplerim</a></li>
		<li><a href="/uye/havale">Havale Bildirimi</a></li>
		<li><a href="/uye/cikis">Oturumu Kapat</a></li>
	</ul>


<? elseif($blok=='siparislerim'): ?>
	<?=$navi?>
	<table class="liste">
		<tr><th>No</th><th>Tarih</th><th>Tutar</th><th>Sipariş Durumu</th><th width="100px"></th></tr>
		<? foreach($siparisler as $siparis):?>
			<tr<?=$siparis->siparis_durumu==4 || $siparis->siparis_durumu==5 ? ' style="color:#666;"':''?>><td><?=$siparis->id?></td><td><?=tarih($siparis->tarih,'gun')?></td><td><?=para($siparis->tutar)?> TL</td><td><?=$durumlar[$siparis->siparis_durumu]?></td><td><a href="/uye/siparislerim?id=<?=$siparis->id?>">Detaylar</a></td></tr>
		<? endforeach;?>
	</table>

		


<? elseif($blok=='siparislerim-detay'): ?>
	<?=$navi?>
	
	<table class="nohover liste">
		<tr><th>Stok Kodu</th><th>Ürün Adı</th><th>Adet</th><th class="sag">Birim Fiyat</th><th class="sag">KDV</th><th class="sag">Fiyat</th></tr>
	<? foreach($urunler as $urun):?>
		<tr><td><?=$urun['stok_kodu']?></td><td><?=$urun['urun_adi']?></td><td><?=$urun['adet']?></td><td class="sag"><?=para($urun['birim_fiyat'],2)?> <?=$urun['para_sembol']?></td><td class="sag"><?=para($urun['kdv'])?> <?=$urun['para_sembol']?></td><td class="sag"><?=para($urun['birim_fiyat']*$urun['adet'],2)?>  <?=$urun['para_sembol']?></td></tr>
	<? endforeach;?>
		<tr class="fiyat"><td colspan="4"></td><td>Ara Toplam </td><td><?=para($siparis->kdvharic,2)?> TL</td></tr>
		<tr class="fiyat"><td colspan="4"></td><td>Kdv</td><td><?=para($siparis->kdv,2)?> TL</td></tr>
		<tr class="fiyat"><td colspan="4"></td><td>Toplam</td><td><?=para($siparis->kdvdahil,2)?> TL</td></tr>
		<tr class="fiyat"><td colspan="4"></td><td>İndirimli</td><td><?=para($siparis->indirimli,2)?> TL</td></tr>
		<?=$odeme->odeme_tipi==siparis::ODEME_TIPI_KK  || $odeme->odeme_tipi==siparis::ODEME_TIPI_KK_3D ? '<tr class="fiyat"><td colspan="4"></td><td><b>Kredi Kartı İle Toplam</b></td></th><td><b>'.para($siparis->tutar,2).' TL</b></td></tr>':'<tr class="fiyat"><td colspan="4"></td><td><b>Havale </b></td></th><td><b>'.para($siparis->havaleile,2).' TL</b></td></tr>'?>
	</table>
	<br><br>
	<table class="nohover liste">
		<tr><th colspan=2>Sipariş Bilgileri</th></tr>
		<tr><td width="100px">Siparis No</td><td><?=$siparis->id?></td></tr>
		<tr><td>Sipariş Durumu</td><td><?=$durumlar[$siparis->siparis_durumu]?></td></tr>
		<tr><td>Siparis Tarihi</td><td><?=tarih($siparis->tarih)?></td></tr>
		<tr><td>Düzenleme Tarihi</td><td><?=tarih($siparis->duzenleme_tarihi)?></td></tr>
		<tr><td>Sipariş Sahibi</td><td><?=$siparis->isim?></td></tr>
		<tr><td>E-Posta Adresi</td><td><?=$siparis->eposta?></td></tr>
	 </table>
	<br><br>
	<table class="nohover liste">
		<tr><th colspan=2>Fatura Bilgileri</th></tr>
		<tr><td width="100px">İsim / Ünvan</td><td><?=$fatura->isim?></td></tr>
		<tr><td>Vergi Dairesi</td><td><?=$fatura->vd?></td></tr>
		<tr><td>TC / Vergi No</td><td><?=$fatura->tc?></td></tr>
		<tr><td>Şehir</td><td><?=$fatura->sehir_adi?></td></tr>
		<tr><td>Adres</td><td><?=$fatura->adres?></td></tr>
	 </table>
	<br><br>
	<table class="nohover liste">
	<tr><th colspan=2>Teslimat Adres Bilgileri</th></tr>
		<tr><td width="100px">Ad Soyad</td><td><?=$adres->isim?></td></tr>
		<tr><td>Sabit Tel</td><td><?=$adres->telsabit?></td></tr>
		<tr><td>Mobil Tel</td><td> <?=$adres->telcep?></td></tr>
		<tr><td>Şehir</td><td> <?=$adres->sehir_adi?> </td></tr>
		<tr><td>Adres</td><td> <?=$adres->adres?> </td></tr>
	 </table>
	 <br><a href="/uye/siparislerim">Tüm Siparişlerim</a>
	 
<? elseif($blok=='hesap'): ?>
	<?=$navi?>
	<?=!empty($bilgi)?$bilgi:''?>
	
	<a href="/sepet" class="sepet btn">Sepetim</a>
	<a href="/uye/siparislerim" class="siparis btn">Siparişlerim</a>
    <a href="/uye/adreslerim" class="adres btn">Adres Bilgilerim</a>
    <a href="/uye/bilgilerim" class="uyelik btn">Üyelik Bilgilerim</a>
    <a href="/uye/destek" class="destek btn">Destek Taleplerim</a>
    <a href="/uye/havale" class="bildirim btn">Yeni Havale Bildirimi</a>
	
<? elseif($blok=='destek'): ?>
	<?=$navi?>
	<?=!empty($bilgi)?$bilgi:''?>
	<table class="liste">
		<tr><th>No</th><th>Tarih</th><th>Konu</th><th>Durum</th><th width="100px"></th></tr>
		<? if($talepler) :?>
			<? foreach($talepler as $talep):?>
				<tr><td><?=$talep->id?></td><td><?=tarih($talep->tarih,'gun')?></td><td><?=$talep->konu?></td><td><?=$durumlar[$talep->durum]?></td><td><a href="/uye/destek/detay?id=<?=$talep->id?>">Detaylar</a></td></tr>
			<? endforeach;?>
		<? else:?>
			<tr><td colspan=5>Henüz destek talebiniz bulunmuyor.</td></tr>
		<? endif;?>
	</table>
	<br><input type="submit" name="btnUyeDestek" class="btn" value=" Yeni Destek Talebi " onclick="location.href='/uye/destek/yeni';"/>
	
<? elseif($blok=='destek-yeni'): ?>
	<?=$navi?>
	<?=!empty($bilgi)?$bilgi:''?>
	<form method="post" action="/uye/destek/yeni" class="standart"><br>
	<table>
		<tr><th colspan="2"><h1>Yeni Destek Talebi</h1></th></tr>
		<tr><td width="150px">Konu</td><td><input type="text" name="konu" value="<?=$f['konu']?>"></td></tr>
		<tr><td>Mesajınız</td><td><textarea name="mesaj" class="destek"><?=$f['mesaj']?></textarea></td></tr>
	</table>	
	<br><input type="submit" name="btnYeniDestek" class="btn vurgu" value="Gönder"/>
	</form>

<? elseif($blok=='havale-bildirimi'): ?>
	<?=$navi?>
	<?=!empty($bilgi)?$bilgi:''?>
	<form method="post" action="/uye/havale" class="standart"><br>
	<table>
		<tr><th colspan="2"><h1>Yeni Havale Bildirimi</h1></th></tr>
		<tr><td width="150px">Sipariş Numaranız</td><td><input type="text" name="siparis_no"></td></tr>
		<tr><td>Banka</td><td><?=$cbHesapId?></td></tr>
		<tr><td>Açıklama</td><td><textarea name="mesaj" class="destek" placeholder="Lütfen havale tarihini ve tutarını giriniz"></textarea></td></tr>
	</table>	
	<br><input type="submit" name="btnHavaleBildirimi" class="btn" value="Gönder"/>
	</form>

<? elseif($blok=='destek-detay'): ?>
	<?=$navi?>
	<?=!empty($bilgi)?$bilgi:''?>
	<? foreach($mesajlar as $mesaj):?>
		<div class="mesaj">
			<i><?=$mesaj->isim ?> - <?=tarih($mesaj->tarih,'gun')?></i> 
			<h1<?=$mesaj->ust_id?' class="cevap"':''?>><?=$konu?></h1>
			
			<p><?=$mesaj->talep?></p>
		</div>
	<? endforeach;?>
	
	
	<form method="post" action="/uye/destek/detay?id=<?=$_REQUEST['id']?>" class="standart"><br>
	<table>
		<tr><th colspan="2"><h1>Cevap Gönderin</h1></th></tr>
		<tr><td width="150px">Mesajınız</td><td><textarea name="mesaj" class="destek"><?=$f['mesaj']?></textarea></td></tr>
	</table>	
	<br><input type="submit" name="btnYeniCevap" class="btn vurgu" value="Gönder"/>
	</form>
	
<? elseif($blok=='login'):?>
	<? header('Location:https://www.pistonkafalar.com/?b=uye/login&ref=eticaret'); ?>
	<?=$navi?>
	<?=!empty($bilgi)?$bilgi:''?>
	<?=!empty($hata)?'<br>'.$hata:''?>
	
	<div class="form">
		<form method="post" action="/uye">
		<h1>Kullanıcı Girişi</h1>
		E-Posta Adresiniz : <br/><input type="text" name="email" autocomplete="off"/><br/><br/>
		Şifreniz : <br/><input type="password" name="password" autocomplete="off"/><br/><br/>
		<input type="submit" name="btnUyeGirisi" class="btn vurgu btnUyeGirisi" value=" Oturum Aç "/>
		<br/><br/><a href="/uye/yeni">Üye Olun</a> | <a href="/uye/unuttum">Şifre Hatırlat</a>
		<? if(0 && $lib->FacebookConnect()):?>
		<br><br>
		<img src="/static/img/fb.jpg" onclick="window.open('https://www.facebook.com/dialog/permissions.request?api_key=422298691143284&app_id=422298691143284&display=popup&fbconnect=1&locale=tr_TR&next=http%3A//api.eticaret/facebook/login.php%3Fsid%3D<?=$sid?>%26xid%3D<?=session_id()?>&perms=email,user_birthday,offline_access&return_session=1&sdk=joey&session_version=3','FacebookLogin','width=800,height=600');" style="cursor:pointer;">
		<? endif; ?>
		</form>
	</div>

<? elseif($blok=='unuttum'):?>
	<? header('Location:https://www.pistonkafalar.com/?b=uye/unuttum&ref=eticaret'); ?>
	<?=!empty($bilgi)?$bilgi:''?>
	<?=!empty($hata)?'<br>'.$hata:''?>
	
	<div class="form">
		<form method="post" action="/uye/unuttum">
		<h1>Şifre Sıfırlama Ekranı</h1>
		Kayıt olurken kullandığınız eposta adresinizi girerek şifrenizi tekrar oluşturabilirsiniz. Doğru bir eposta adresi girdiğiniz takdirde şifre oluşturma linkinizi o adrese gönderilecektir. <br><br>E-Posta Adresiniz : <br/><input type="text" name="email" autocomplete="off"/><br/><br/>
		<input type="submit" name="btnSifreSifirla" class="btn vurgu btnUyeGirisi" value=" Şifre Sıfırla "/>
		</form>
	</div>

<? elseif($blok=='reset'):?>
	<?=$navi?>
	<?=!empty($bilgi)?$bilgi:''?>
	<?=!empty($hata)?'<br>'.$hata:''?>
	
	<div class="form">
		<form method="post" action="/uye/reset">
		<h1>Şifre Sıfırlama Ekranı</h1><br>
		Yeni Şifreniz: <br/><input type="password" name="pass1" autocomplete="off"/><br/><br/>
		Yeni Şifreniz (Tekrar): <br/><input type="password" name="pass2" autocomplete="off"/><br/><br/><input type="hidden" name="id" value="<?=$id?>"><input type="hidden" name="x" value="<?=$x?>">
		<input type="submit" name="btnReset" class="btn vurgu btnUyeGirisi" value=" Şifre Değiştir "/>
		</form>
	</div>


<? elseif($blok=='yeni'):?>
	<? header('Location:https://www.pistonkafalar.com/?b=uye/yeni&ref=eticaret'); ?>
	<?=!empty($hata)?$hata:''?>
	<form method="post" action="/uye/yeni" class="standart"><br>
	<table>
		<tr><th colspan="2"><h1>Temel Bilgiler</h1></th></tr>
		<tr><td>Ad Soyad</td><td><input type="text" name="isim" value="<?=$f['isim']?>" title="adiniz soyadiniz">*</td></tr>
		<tr><td>E-Posta Adresi</td><td><input type="text" name="eposta" value="<?=$f['eposta']?>"/>*</td></tr>
		<?=$tc_kimlik_sor?'<tr><td>TC Kimlik Numarası</td><td><input type="text" name="tc" value="'.$f['tc'].'" maxlength="11"/>*</td></tr>':''?>
		<tr><td>Doğum Tarihi</td><td><?=uye::dogumTarihiForm($tarih)?></td></tr>
		<tr><td>Cinsiyet</td><td><input type="radio" name="cinsiyet" value="0" checked id="kadin"/><label for="kadin">Kadın</label> <input type="radio" name="cinsiyet" value="1" id="erkek"/><label for="erkek">Erkek</label></td></tr>
		<tr><td>Şifre</td><td><input type="password" name="sifre1" maxlength="16">*</td></tr>
		<tr><td>Şifreniz (Tekrar)</td><td><input type="password" name="sifre2" maxlength="16"></td></tr>
		<tr><th colspan="2"><br><h1>İletişim Bilgileri</h1></th></tr>
		<tr><td>Şehir</td><td><?=uye::getSehirlerSelect($f['sehir'])?>*</td></tr>
		<tr><td>İlçe</td><td><input type="text" name="ilce" value="<?=$f['ilce']?>"/>*</td></tr>
		<tr><td>Sabit Telefon</td><td><input type="text" name="telefon" value="<?=$f['telefon']?>"/></td></tr>
		<tr><td>Cep Telefonu</td><td><input type="text" name="cep" value="<?=$f['cep']?>"/></td></tr>
		<tr><th colspan="2"><br>
		<input type="checkbox" name="sozlesme"/> <a href="/" onclick="window.open('/sozlesme/?uyelik-sozlesmesi','UyelikSozlesmesi','menubar=0,resizable=0,width=850,height=550,scrollbars=yes');return false;">Üyelik Sözleşmesini</a> okudum, onaylıyorum<br><br>
		<input type="submit" name="btnUyeKaydet" class="btn vurgu btnUyeKaydet" value="Gönder"/><br><br>
		</th></tr>
	</table>	
	</form>

	
<? elseif($blok=='bilgilerim'):?>
	<?=$navi?>
	<?=!empty($bilgi)?$bilgi:''?>
	<form method="post" action="/uye/bilgilerim" class="standart"><br>
		<table>
			<tr><th colspan="2"><h1>Temel Bilgiler</h1></th></tr>
			<tr><td>Ad Soyad</td><td><input type="text" name="isim" value="<?=$f['isim']?>" title="adiniz soyadiniz">*</td></tr>
			<tr><td>E-Posta Adresi</td><td><input type="text" name="eposta" value="<?=$f['eposta']?>"/>*</td></tr>
			<tr><td>TC Kimlik Numarası</td><td><input type="text" name="tc" value="<?=$f['tc']?>" maxlength="11"/>*</td></tr>
			<tr><td>Doğum Tarihi</td><td><?=uye::dogumTarihiForm($f['dogumtarihi'])?></td></tr>
			<tr><td>Cinsiyet</td><td><input type="radio" name="cinsiyet" value="0" <?=$f['cinsiyet']==0 ? 'checked':'' ?> id="kadin"/><label for="kadin">Kadın</label> <input type="radio" name="cinsiyet" value="1" id="erkek"/ <?=$f['cinsiyet']==1 ? 'checked':'' ?>><label for="erkek">Erkek</label></td></tr>
			<tr><th colspan="2"><br><h1>İletişim Bilgileri</h1></th></tr>
			<tr><td>Şehir</td><td><?=uye::getSehirlerSelect($f['sehir'])?>*</td></tr>
			<tr><td>İlçe</td><td><input type="text" name="ilce" value="<?=$f['ilce']?>"/>*</td></tr>
			<tr><td>Sabit Telefon</td><td><input type="text" name="telefon" value="<?=$f['telefon']?>"/></td></tr>
			<tr><td>Cep Telefonu</td><td><input type="text" name="cep" value="<?=$f['cep']?>"/></td></tr>
			<tr><th colspan="2"><br><h1>Giriş Bilgileri</h1></th></tr>
			<tr><td>Eski Şifre</td><td><input type="password" name="eskisifre" maxlength="16">*</td></tr>
			<tr><td>Şifre</td><td><input type="password" name="sifre1" maxlength="16">*</td></tr>
			<tr><td>Şifreniz (Tekrar)</td><td><input type="password" name="sifre2" maxlength="16"></td></tr>
		</table>
		<br>	
		<input type="submit" name="btnUyeKullaniciDuzenle" class="btn vurgu btnUyeKaydet" value="Kaydet"/>
	</form>


<? elseif($blok=='adreslerim'):?>
	<?=$navi?>
	<?=!empty($bilgi)?$bilgi:''?>
	<form method="post" action="/uye/adreslerim" class="standart"><br>
		<?=$adreslerim?>
		<br>	
		<input type="submit" name="btnUyeAdresDuzenle" class="btn vurgu btnUyeKaydet" value="Kaydet"/>
	</form>		
	
	
<? elseif($blok=='fatura-ve-teslimat-bilgileri'):?>
	<h1><?=$baslik?></h1>
	
	<table>
	<? if($fatura_sor) : ?>
		<tr><th colspan="2"><h1>Fatura Bilgileri</h1></th></tr>
		<? if($cbFaturaAdresleri): ?><tr><td>Fatura Bilgisi Tercihi</td><td><?=$cbFaturaAdresleri ?></td></tr><? endif;?> 
		<tr><td>Kişi/Kuruluş Adı</td><td><input type="text" name="fatura_kisi" value="<?=$fatura['isim']?>">*</td></tr>
		<tr><td>Vergi Dairesi</td><td><input type="text" name="vd" value="<?=$fatura['vd']?>"/></td></tr>
		<tr><td>TC Kimlik No/Vergi No</td><td><input type="text" name="tc" value="<?=$fatura['tc']?>"/>*</td></tr>
		<tr><td>Şehir</td><td><?=uye::getSehirlerSelect($fatura['sehir'],'fatura_sehir')?>*</td></tr>
		<tr><td>Fatura Adresi</td><td><textarea name="fatura_adres"><?=$fatura['adres']?></textarea>*</td></tr>
	<? endif;?>
		<tr><th colspan="2"><br><h1>Teslimat Bilgileri</h1></th></tr>
		<? if($cbTeslimatAdresleri): ?><tr></tr><td>Teslimat Bilgisi Tercihi</td><td><?=$cbTeslimatAdresleri ?></td></tr><? endif;?> 
		<tr><td>Kişi/Kuruluş Adı</td><td><input type="text" name="teslimat_kisi" value="<?=$teslimat['isim']?>"/>*</td></tr>
		<tr><td>Sabit Telefon</td><td><input type="text" name="telsabit" value="<?=$teslimat['telsabit']?>"/>*</td></tr>
		<tr><td>Cep Telefonu</td><td><input type="text" name="telcep" value="<?=$teslimat['telcep']?>"/></td></tr>
		<tr><td>Şehir</td><td><?=uye::getSehirlerSelect($teslimat['sehir'],'teslimat_sehir')?>*</td></tr>
		<tr><td>Teslimat Adresi</td><td><textarea name="teslimat_adres"><?=$teslimat['adres']?></textarea>*</td></tr>
	</table>	
	
<? endif; ?>