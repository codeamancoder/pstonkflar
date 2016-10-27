<? 
	if(!function_exists('__menu'))
	{	
		
		function __menu($gruplar)
		{
			$o = '<ul>';
			foreach ($gruplar as $sayfa)
			{
				if(!$sayfa['silindi']) $o .= '<li'.($sayfa['sec']?' class="'.$sayfa['sec'].'"':'').'><a href="/kategori/'.$sayfa['link'].'" title="'.$sayfa['title'].'">'.$sayfa['dal_adi'].'</a>'.($sayfa['alt'] ? __menu($sayfa['alt']) : '').'</li>';		
			}
			$o .= '</ul>';
			return $o;
		}
	}


	if($blok=='menu-1'): ?>
	<h1><a href="/" title="Tüm Ürün Grupları">Ürün Grupları</a></h1>
	<ul>
	<? if(!empty($gruplar['dal_id'])) :?>
		<li class="ug"><a href="/kategori/<?=$gruplar['link']?>" title="<?=$gruplar['dal_adi']?>"><?=$gruplar['dal_adi']?></a></li>
		<? foreach($gruplar['alt'] as $grup) :?>
			<li  class="ag <?=$grup['sec']?>"><a href="/kategori/<?=$grup['link']?>" title="<?=$grup['dal_adi']?>"><?=$grup['dal_adi']?></a></li>
		<? endforeach;?>
	    <li class="tg"><a href="/kategori/<?=$gruplar['ata']['link']?>" title="<?=$gruplar['ata']['dal_adi']?>"><?=$gruplar['ata']['dal_adi']?></a></li>
	<? else :?>
		<? foreach($gruplar['alt'] as $grup) :?>
		<li<?=$grup['sec']?' class="'.$grup['sec'].'"':''?>><a href="/kategori/<?=$grup['link']?>" title="<?=$grup['dal_adi']?>"><?=$grup['dal_adi']?></a></li>
		<? endforeach;?>
	<? endif;?>
	</ul>
	
	
<? elseif($blok=='menu-2'): ?>	 
	<h1><a href="/" title="Tüm Ürün Grupları">Ürün Grupları</a></h1>
	<?=__menu($gruplar);?>
	
<? elseif($blok=='menu-2'): ?>

	{if not $baslik}
		<h1>Ürün Grupları</h1>
	{/if}
	<ul class="{$class} {if $seviye}m2{/if}">
	{foreach from=$GRUPLAR.alt item=GRUP}
	   <li  class="{$GRUP.sel} {$GRUP.alt_grup_resim}"><a href="{$GRUP.link}" title="{$GRUP.dal_adi}">{$GRUP.dal_adi}</a>
	   {if $GRUP.alt} {include file="urunler.html" GRUPLAR=$GRUP BLOK="menu-2" baslik="1" class="alt-grup"} {/if}
	   </li>
	{/foreach}
	</ul> 

<? elseif($blok=='urun-gruplari'): ?>

	{$SAYFA_UST}
	{if !$ANASAYFA}<h1>{$GRUPLAR.dal_adi}</h1>{/if}
	<div class="urun-gruplari k{$KOLON}">
	{foreach from=$GRUPLAR.alt item=G}
		<div class="grup">
			<div>
	   			<div class="foto"><a href="{$G.link}"><img src="{$G.foto}"></a></div>
	   			<div class="baslik"><a href="{$G.link}">{$G.dal_adi}</a></div>
	   		</div>
	   	</div>
	{/foreach}
	</div>

<? elseif($blok=='markalar-liste-yan'): ?>
	<h1>Markalar</h1>
	<ul>
		<li class="ug"><a href="/marka/<?=$marka->link?>" title="<?=$marka->marka_adi?> Ürünleri"><?=$marka->marka_adi?> Ürünleri</a></li>
	<? foreach($urungruplari as $grup) :?>
		<li class="ag"><a href="/marka/<?=$marka->link.'/'.$grup['link']?>" title="<?=$grup['dal_adi']?>"><?=$grup['dal_adi']?> (<?=$grup['sayi']?>)</a></li>
	<? endforeach;?>
		<li class="tg"><a href="/" title="Tüm Kategoriler">Tüm Kategoriler</a></li>
		<li class="tg"><a href="/marka" title="Tüm Markalar">Tüm Markalar</a></li>
	</ul>
	
<? elseif($blok=='markalar-secim-yan'): ?>
	<?=$navi?>
	<ul>
	<? foreach($markalar as $marka) :?>
		<li><a href="/marka/<?=$marka['marka_id']?>" title="<?=$marka['marka_adi']?>"><?=$marka['marka_adi']?></a></li>
	<? endforeach;?>
	</ul>
	
	
<? elseif($blok=='markalar-liste-icerik'): ?>
	<?=$navi?>
	<ul>
	<? foreach($markalar as $marka) :?>
		<li><a href="/marka/<?=$marka['link']?>" title="<?=$marka['marka_adi']?>"><?=$marka['marka_adi']?></a></li>
	<? endforeach;?>
	</ul>

<? elseif($blok=='lastikara') :?>
    <div class="kutu1">
		<label>
			<select id="taban">
				<option selected="true" value="0">Seçiniz</option> <option value="130">130</option> <option value="135">135</option> <option value="145">145</option> <option value="155">155</option> <option value="165">165</option> <option value="175">175</option> <option value="185">185</option> <option value="195">195</option> <option value="205">205</option> <option value="215">215</option> <option value="225">225</option> <option value="235">235</option> <option value="245">245</option> <option value="250">250</option> <option value="255">255</option> <option value="265">265</option> <option value="275">275</option> <option value="285">285</option> <option value="295">295</option> <option value="305">305</option> <option value="315">315</option> <option value="325">325</option> 
			</select>
		</label>​
	</div>
    <div class="kutu2">
		<label>
			<select id="yanak">
				<option selected="true" value="0">Seçiniz</option> <option value="30">30</option> <option value="35">35</option> <option value="40">40</option> <option value="45">45</option> <option value="50">50</option> <option value="55">55</option> <option value="60">60</option> <option value="65">65</option> <option value="70">70</option> <option value="75">75</option> <option value="80">80</option> <option value="85">85</option> <option value="90">90</option> 
			</select>
		</label>
    </div>

    <div class="kutu3">
		<label>
			<select id="jant"> 
				<option value="0">Seçiniz</option> <option value="12">12</option> <option value="13">13</option> <option value="14">14</option> <option value="15">15</option> <option value="16">16</option> <option value="17">17</option> <option value="18">18</option> <option value="19">19</option> <option value="20">20</option> <option value="21">21</option> 
			</select>
		</label>
    </div>

    <div class="kutu4">
		<label>
			<?=html::select($markalar,'marka',0,'marka_id','marka_adi','Seçiniz',null);?>
		</label>
    </div>

    <div  class="kutu5">
        <input type="button"  name="btnLastikAra" value="">
    </div>

    <script>
        $(document).ready(function(){
            $('input[name=btnLastikAra]').click(function(){
                if( $('#taban').val()==0 || $('#yanak').val()==0 || $('#jant').val()==0) { alert('Lütfen tüm alanları seçiniz.'); return false; }
                location.href = '/ara/'+$('#taban').val() + '/' + $('#yanak').val() + ' R' + $('#jant').val() + ($('select[name=marka]').val()!='Seçiniz' ? '&marka_id='+$('select[name=marka]').val():'');
            });
        });
    </script>	
<? elseif($blok=='indirimli'): ?>
	<h1>İndirimli Ürünler</h1>
	<div class="anim-yukari">
		<div class="items">
		<? foreach($urunler as $urun) :?>
			<? $fiyat = fiyatHesapla($urun); ?>
			<div>
				<a href="/urun/<?=$urun['link']?>" title="<?=$urun['urun_adi']?>">
					<img src="<?=$urun['thumb'] ? ''.$urun['thumb']: CDN.'/img/nopic.png' ?>" title="<?=$urun['urun_adi']?>" alt="<?=$urun['urun_adi']?> Fotoğrafı">
					<br><?=$urun['urun_adi']?>
				</a>
				<br><span class="normalfiyat yerine"><?=$urun['piyasa_fiyati'] ? para($urun['piyasa_fiyati']) : para($fiyat['kdv_dahil'])?> <?=$urun['para_sembol']?></span>
				<br><span class="indirimlifiyat"><?=para($fiyat['havaleile'])?> <?=$urun['para_sembol']?></span>
			</div>
		<? endforeach;?>
		</div>
	</div>
	<script type="text/javascript">
	$(document).ready(function(){
		if($(".anim-yukari .items div").size()) $(".anim-yukari").scrollable({ circular: true,vertical:true,speed:1000}).autoscroll({ autoplay: true,interval:4000 });
	});
	</script>

<? elseif($blok=='urunler-carsaf'): ?>

	<?=$sayfa_ust?>
	<?=$navi?>
	<?=$markalar?>
	<?=$filtreler ?>
	<table class="urunler-carsaf">
	<? foreach($urunler as $i=>$u): ?>
		<tr id="urun_<?=$u['urun_id']?>">
			   <td class="foto">
			      <a href="/urun/<?=$u['link']?>" title="<?=$u['urun_adi']?>"><img src="<?=$u['thumb'] ? $u['thumb'] : CDN.'/img/nopic.png' ?>" title="<?=$u['urun_adi']?>" alt="<?=$u['urun_adi']?> Fotoğrafı"></a>
			   </td>
			   <td class="baslik">
			   	   <a href="/urun/<?=$u['link']?>" title="<?=$u['urun_adi']?>"><?=$u['urun_adi']?></a>
			   	   <?= $u['kisa_aciklama']?'<br/><a href="/urun/'.$u['link'].'"><span class="aciklama">'.$u['kisa_aciklama'].'</span></a>':''?>
			   </td>
			   <td class="fiyat">			   
			   	   <? if($lib->FiyatGoster())
			   	      {
		   	      	  	  $fiyat = fiyatHesapla($u);
				   	  	  if($u['piyasa_fiyati']) echo '<br/><span class="piyasa">'.para($u['piyasa_fiyati']*$u['capraz_kur']).' '.$ayar['ana_para_sembol'].'</span>';
				   	  	  if($ayar['kdv_goster'])
			   	      	  {
					   	  	  echo '<span class="fiyat">'.para($fiyat['havaleile']*$u['capraz_kur']).' '.$ayar['ana_para_sembol'].'<span class="kdv"> KDV DAHİL</span></span>';
			   	      	  }
			   	      	  else 
			   	      	  {
					   	  	  echo '<span class="fiyat">'.para($fiyat['kdvharic']*$u['capraz_kur']).' '.$ayar['ana_para_sembol'].'</span>';
			   	      	  }
			   	       }
			   	   ?>
   	      	   </td>
   	      	   <td class="linkler">
   	      	   	   <?=$lib->StokGoster($u['stok_miktari']) ? '<a class="btnIncele"></a>' : ''?>
   	      	   </td>
			</tr>
		
		
	<? endforeach;?>
	</table>
	<?=$sayfalar ?>
	
	
<? elseif($blok=='urunler-blok'): ?>
	<?=$sayfa_ust?>
	<?=$navi?>
	<?=$markalar?>
	<?=$aramasonucu?>
	<?=$filtreler ?>
	<div class="urunler-blok k<?=$kolon?>">
	<? foreach($urunler as $i=>$u): ?>
		<div class="urun <?='c'.($i%$kolon)?>">
			<div id="urun_<?=$u['urun_id']?>"> 
			   <?=$u['indirim'] ? '<span class="indirim"></span>' : ''?>
			   <div class="baslik">
			   	   <a href="/urun/<?=$u['link']?>" title="<?=$u['urun_adi']?>"><?=$u['urun_adi']?></a>
			   </div>			   
			   <div class="foto">
			   		<a href="/urun/<?=$u['link']?>" title="<?=$u['urun_adi']?>"><img src="<?=$u['thumb'] ? $u['thumb'] : CDN.'/img/nopic.png' ?>" title="<?=$u['urun_adi']?>" alt="<?=$u['urun_adi']?> Fotoğrafı"></a>
			   </div>
				<?= $u['kisa_aciklama']?'<br/><a href="/urun/'.$u['link'].'"><span class="aciklama">'.ec_substr($u['kisa_aciklama'],25).'</span></a>':''?>
		   	   <? if($lib->FiyatGoster())
	   	      	  {
				   	  echo '<div class="fiyat">';
	   	      	  	  $fiyat = fiyatHesapla($u);
			   	  	  if($u['piyasa_fiyati']) echo '<span class="piyasa">'.number_format($u['piyasa_fiyati'],2).' '.$u['para_sembol'].'</span>';
		   	      	  if($ayar['kdv_goster'])
		   	      	  {
				   	  	  echo '<span class="fiyat">'.para($fiyat['havaleile']*$u['capraz_kur']).' '.$ayar['ana_para_sembol'].' <span class="kdv"> KDV DAHİL</span></span>';
		   	      	  }
		   	      	  else 
		   	      	  {
				   	  	  echo '<span class="fiyat">'.para($fiyat['kdvharic']*$u['capraz_kur']).' '.$ayar['ana_para_sembol'].'</span>';
		   	      	  }
		   	      	  echo '</div>';		   	  
					  echo '<a href="/urun/'.$u['link'].'" title="'.$u['urun_adi'].'" class="btnSebeteEkle"></a>';
	   	      	  }
			   	?>
			</div>
		</div>
		
	<? endforeach;?>
	</div>
	<?=$sayfalar ?>

<? elseif($blok=='urun'): ?>
	<?=$navi?>
	<div class="urun" id="urun_<?=$urun['urun_id']?>">
		<div class="foto">
			<div class="kapak">
				<? if($buyut == 'box'): ?>
					<a href="<?=$urun['fotoana']['big']?>" class="<?=$buyut?> fancy"><img src="<?=$urun['fotoana']['normal']?>"></a>
				<? elseif($buyut == 'mercek'): ?>
					<div href="<?=$urun['fotoana']['big']?>" class="cloud-zoom" rel="zoomWidth: '450',zoomHeight: '400',position: 'right',smoothMove: 3,lensOpacity: 0.5,tintOpacity: 0.5,softFocus: false"><img src="<?=$urun['fotoana']['normal']?>"></div>
                    <a href="<?=$urun['fotoana']['big']?>" class="box zoomlink fancy"></a>
				<? else: ?>
					<img src="<?=$urun['fotoana']['normal']?>">
				<? endif; ?>
			</div>
			<div class="diger-fotolar <?=$altfoto<2 ? 'gizli':''?>">
				<div class="items">
					<? foreach($urun['foto'] as $foto):?>
						<a href="<?=$foto['big']?>" rel="gal1">  
							<img src="<?=$foto['thumb']?>">
						</a>
					<? endforeach;?>
				</div>
			</div>
		</div>
		<div class="info">
			<table>
				<tr class="urun_adi"><td colspan="3"><h2><?=$urun['urun_adi']?></h2><?=$urun['kisa_aciklama']?></td></tr>
				<? if($urun['marka_adi']): ?><tr class="kucuk"><td><b>Marka</b></td><td>:</td><td><a href="/marka/<?=$urun['marka_link']?>"><?=$urun['marka_adi']?></a></td></tr> <? endif;?>
				<? if($urun['stok_kodu']): ?><tr class="kucuk"><td><b>Stok Kodu</b></td><td>:</td><td><?=$urun['stok_kodu']?></td></tr> <? endif; ?>
				<? 
		   	   		if($lib->FiyatGoster() && ($urun['stok_miktari'] || $ayar['stoksuz_satis']))
		   	   		{
			   	   		if($urun['piyasa_fiyati']) echo '<tr><td class="b"><b>Piyasa Fiyatı</b></td><td>:</td><td><span class="fiyat piyasa yerine">'.para($urun['piyasa_fiyati']*$urun['capraz_kur']).' '.$ayar['ana_para_sembol'].'</span></td></tr>';
		   	   			if($urun['kdv'])
		   	   			{
				   	   		echo '<tr><td class="b"><b>Fiyat</b></td><td>:</td><td><span class="fiyat kdvharic">'.para($urun['tutar']['kdvharic']).' '.$urun['para_sembol'].' + KDV</span></td></tr>
				   	   			  <tr><td class="b"><b> KDV Dahil</b></td><td>:</td><td><span class="fiyat kdvdahil '.($urun['indirim']?'':'buyuk').'">'.para($urun['tutar']['kdvdahil']*$urun['capraz_kur']).' '.$ayar['ana_para_sembol'].'</span></td></tr>';
		   	   			}
		   	   			else
		   	   			{
				   	   		echo '<tr><td class="b"><b>Fiyat</b></td><td>:</td><td><span class="fiyat kdvdahil buyuk'.($urun['indirim']?'':'buyuk').'">'.para($urun['tutar']['kdvdahil']*$urun['capraz_kur']).' '.$ayar['ana_para_sembol'].'</span></td></tr>';
		   	   			}
		   	   			echo $urun['indirim'] ? '<tr><td class="b"><b>İndirimli Toplam</b></td><td>:</td><td><span class="fiyat indirimli buyuk">'.para($urun['tutar']['indirimli']*$urun['capraz_kur']).' '.$ayar['ana_para_sembol'].'</span> ( %'.$urun['indirim'].' indirimli )</td></tr>':'';				   	   	
		   	   			echo $urun['havale_indirimi'] ? '<tr><td class="b"><b>Havale İle</b></td><td>:</td><td><span class="fiyat havaleile buyuk">'.para($urun['tutar']['havaleile']*$urun['capraz_kur']).' '.$ayar['ana_para_sembol'].'</span> ( %'.$urun['havale_indirimi'].' indirimli )</td></tr>':'';
		   	   			echo !$urun['stok_miktari'] && $urun['stok_yok_notu'] ? '<tr><td class="b"><b>Not</b></td><td>:</td><td>'.$urun['stok_yok_notu'].'</td></tr>':'';
			   	   	    echo $stok_tip_tercihi ? '<tr><td><b>Miktar</b></td><td>:</td><td class="dxFiyat"><input type="text" name="adet" class="adet" value="1" >'.$stok_tip_tercihi.'<span>'.para($urun['tutar']['kdvdahil']*$urun['capraz_kur']).' '.$ayar['ana_para_sembol'].'</span></td></tr>' : '<tr><td><b>'.$urun['stok_tip_adi'].'</b></td><td>:</td><td><input type="text" name="adet" class="adet" value="1"></td></tr>';
		   	   			echo $urun['stok_miktari'] || $ayar['stoksuz_satis'] ? '<tr><td colspan="3" class="sepet"><div class="btnSebeteEkleBuyuk"></div></td></tr>' : '<tr><td colspan="3" class="sepet"><span class="stokdayok">Ürün şu an stoklarımızda bulunmamaktadır.</span></td></tr>';
		   	   			
		   	   	   }
		   	   	   else echo '<tr><td colspan=2>Ürün stoklarımızda bulunamamaktadır.</td></tr>';
    	   	   	   echo $varyant;
				   echo '<tr><td><b>Sosyal Ag</b></td> <td>:</td><td colspan="2"><div class="addthis_toolbox addthis_default_style "> <a class="addthis_button_preferred_1"></a> <a class="addthis_button_preferred_2"></a> <a class="addthis_button_preferred_3"></a> <a class="addthis_button_preferred_4"></a> <a class="addthis_button_compact"></a> <a class="addthis_counter addthis_bubble_style"></a> </div> <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-50f0187a2a0a4975"></script></div></td></tr>';
			   	?>
				
			</table>
		</div>
		<div class="diger-detaylar">
			<div class="linkler">
				<ul>
					<li id="tabUrunBilgisi" <?=$onsecilidetay=='urunbilgisi'?'class="sec"':''?>>Ürün Bilgileri</li>
					<? if($urun['bagliurunler']):?><li id="tabBagliUrunler" class="sec">Bağlı Ürünler</li><? endif;?>
					<li id="tabBenzerUrunler">Benzer Ürünler</li>
					<li id="tabYorumlar" onclick="return getComments(<?=$urun['urun_id']?>);">Yorumlar</li>
					<?=$lib->FiyatGoster() ? '<li id="tabTaksitSecenekleri" onclick="return getInstallment('.para($urun['tutar']['indirimli']*$urun['capraz_kur']).');">Taksit Seçenekleri</li>':'' ?>
				</ul>
			</div>
			<div class="detay">
				<div id="tabUrunBilgisiDetay" <?=$onsecilidetay=='urunbilgisi'?'class="sec"':''?>>			
					<? if($urun['ekozellikler']):?>
						<b>Özellikler :</b>
						<table>
						<? foreach($urun['ekozellikler'] as $ozellik):?>
							<tr><td><?=$ozellik['deger'] ?></td><td>:</td><td><?=$ozellik['val'] ?></td></tr>
						<? endforeach;?>
						</table>
						<br/>
					<? endif;?>
					<?=$urun['urun_bilgileri'] ?>
				</div>
				<? if($urun['bagliurunler']):?><div id="tabBagliUrunlerDetay" class="sec"><?=$urun['bagliurunler']?></div><? endif;?>
				<div id="tabBenzerUrunlerDetay"><?=$urun['benzerurunler']?></div>
				<div id="tabYorumlarDetay"></div>
				<div id="tabTaksitSecenekleriDetay"></div>
			</div>
		</div>
	</div>

<? endif; ?>