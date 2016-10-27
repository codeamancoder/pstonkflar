<div class="ilan">
	<div class="detay left">
    	<div class="menu5">
        	<ul>
            	<li class="aktif"><a href="#">İlan Detayları</a></li>
                <? if($e->konum): ?><li><a href="#">Harita</a></li><? endif; ?>
            </ul>
            <b>İlan no #<?=$e->ilan_id?></b>
        </div>
        <div class="ayrim">
        	<div class="tab">
            	<h1 class="baslik">'.$e->baslik.'</h1>
                <div class="foto left">
                	<div class="big"><img src="/user/files/'.($imgs[0]->id ? $imgs[0]->id.'.'.$imgs[0]->uzanti : 'noimage.jpg').'"></div>
                    	'.$diger.'
					</div>
                	<div class="metin right">
                    	<table>
                        	<tr><td colspan=2><span class="fiyat">'.money_format($e->fiyat,2).' '.ilan::$dparams[$e->para_birimi].'</span><br><br>'.$e->sehir.' / '.$e->ilce.' '.($e->semt ? ' / '.$e->semt:'').'</td></tr>
                            <tr><th>İlan Tarihi</th><td>'.towebdate($e->tarih).'</td></tr>
                            <tr><th>Kategori</th><td>'.ilan::$dparams[$e->kategori].'</td></tr>
                            <tr><th>Durum</th><td>'.ilan::$dparams[$e->durum].'</td></tr>
                            <tr><th>Kimden</th><td>'.ilan::$dparams[$e->kimden].'</td></tr>
                            '.($e->tip ? '<tr><th>Emlak Tipi</th><td>'.ilan::$dparams[$e->tip].'</td></tr>':'').'
                            '.($e->oda ? '<tr><th>Oda Sayısı</th><td>'.ilan::$dparams[$e->oda].'</td></tr>':'').'
                            '.($e->m2 ? '<tr><th>M²</th><td>'.$e->m2.'</td></tr>' : '').'
                            '.($e->bina_yasi ? '<tr><th>Bina Yaşı</th><td>'.$e->bina_yasi.'</td></tr>':'').'
                            '.($e->bina_kat ? '<tr><th>Kat Sayısı</th><td>'.$e->bina_kat.'</td></tr>':'').'
                            '.($e->kat ? '<tr><th>Bulunduğu Kat</th><td>'.$e->kat.'</td></tr>':'').'
                            '.($e->cephe ? '<tr><th>Cephe</th><td>'.$e->cephe.'</td></tr>':'').'
                            '.($e->isitma ? '<tr><th>Isıtma</th><td>'.ilan::$dparams[$e->isitma].'</td></tr>':'').'
                            '.($e->depozito ? '<tr><th>Depozito</th><td>'.$e->depozito.'</td></tr>' :'').'
                        </table>
                    </div>
                </div>
            <div class="tab" style="position:relative;height:500px;visibility: hidden;">'.$harita.'</div>
        </div>
    </div>
    <div class="iletisim right">
		<div class="menu6">
    		<h1>İletişim Bilgileri</h1>
            <div>
            	<b>'.$uye->ad.'</b><br><br>
                Kayıt Tarihi : '.lifos::to_web_date($uye->kayit_tarihi).'
            </div>
            <h2>Tel : '.$uye->cep.'</h2>
            <div style="text-align:center">
            	<a href="?b=uye/mesaj/gonder&to='.$e->uye_id.'&id='.$e->id.'">Mesaj Gönder</a><br><br>
                <a href="?b=uye/mesaj/gonder&to=8&id='.$e->id.'">Hatalı İlan Bildir</a>
            </div>
            '.$diger_ilanlar_out.'
        </div>
    </div>
	
		<div class="yeni_ikinci_el_reklam">
			<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 2.El Detay -->
<ins class="adsbygoogle"
     style="display:inline-block;width:200px;height:200px"
     data-ad-client="ca-pub-1034370367466687"
     data-ad-slot="3149573504"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
		</div>
		
		
</div>
'.($e->aciklama ? '<div class="menu6"> <h1>Açıklama</h1> <div>'.$e->aciklama.'</div> </div>': '').'
        <div class="menu6"> <h1>Özellikler</h1> <div>
            <table class="ozellikler-diger">
					<tr>
						<td>'.($e->guvenlik?'<b>Güvenlik</b><br>'.$e->guvenlik:'').'</td>
					</tr>
			</table>
        </div> 
        </div>
        <div class="sayac">'.$e->ziyaret.' kez ziyaret edildi</div>
        ';
		
