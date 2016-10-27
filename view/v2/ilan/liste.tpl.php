<div id="ilan-liste">
	<div class="ilan-menu">
		<form name="frmYan" method="get" action="index.php?b=ilan">
			<div class="well kategori-menu" style="padding:5px 0;">
				<ul class="nav nav-list">
					<li class="nav-header">Kategoriler</li>
					<?=$menu?>
				</ul>
			</div>
		
			<div class="well adres-menu" style="padding:5px 0;">
				Kategori İçi Arama
				<div class="input-append">
				  <input class="span2" id="anahtar" name="anahtar" type="text" value="<?=$_GET['anahtar']?>">
				  <button class="btn" type="submit">Ara</button>
				</div>
			</div>
	
			<div class="well arama-menu" style="padding:5px 0;">
				<div class="acilir">
					<a href="#"><i class="icon-chevron-up icon-chevron-up"></i> Adres</a>
					<div>
						<div><?=$sehir?></div>
						<div><?=$ilce?></div>
					</div>
				</div>
				
				<div class="acilir">
					<a href="#"><i class="icon-chevron-up icon-chevron-up"></i> Fiyat</a>
					<div>
						<input type="text" name="fiyat_alt" class="input-mini" value="<?=$_GET['fiyat_alt']?>"> - 
						<input type="text" name="fiyat_ust" class="input-mini" value="<?=$_GET['fiyat_ust']?>">
					</div>
				</div>

				<div class="acilir">
					<a href="#"><i class="icon-chevron-up icon-chevron-up"></i> Yıl</a>
					<div>
						<input type="text" name="yil1" class="input-mini" value="<?=$_GET['yil1']?>"> - 
						<input type="text" name="yil2" class="input-mini" value="<?=$_GET['yil2']?>">
					</div>
				</div>

				<div class="acilir">
					<a href="#"><i class="icon-chevron-up icon-chevron-up"></i> Yakıt</a>
					<div>
						<?=$site->get_param_select(site::P_YAKIT,$_GET['p_'.site::P_YAKIT],'','- Hepsi -')?>
					</div>
				</div>

				<div class="acilir">
					<a href="#"><i class="icon-chevron-up icon-chevron-up"></i> Vites</a>
					<div>
						<?=$site->get_param_select(site::P_VITES,$_GET['p_'.site::P_VITES],'','- Hepsi -')?>
					</div>
				</div>
				
				<div class="acilir">
					<a href="#"><i class="icon-chevron-up icon-chevron-up"></i> KM</a>
					<div>
						<input type="text" name="km1" class="input-mini" value="<?=$_GET['km1']?>"> - 
						<input type="text" name="km2" class="input-mini" value="<?=$_GET['km2']?>">
					</div>
				</div>
				
				<div class="acilir">
					<a href="#"><i class="icon-chevron-up icon-chevron-up"></i> Renk</a>
					<div>
						<?=$site->get_param_select(site::P_RENK,$_GET['p_'.site::P_RENK],'','- Hepsi -')?>
					</div>
				</div>
				
				<div class="acilir">
					<a href="#"><i class="icon-chevron-up icon-chevron-down"></i> Kasa Tipi</a>
					<div<?=$_GET['p_'.site::P_KASA] ? '':' style="display:none";'?>>
						<?=$site->get_param_select(site::P_KASA,$_GET['p_'.site::P_KASA],'','- Hepsi -')?>
					</div>
				</div>
				
				<div class="acilir">
					<a href="#"><i class="icon-chevron-up icon-chevron-down"></i> Motor Hacmi</a>
					<div<?=$_GET['p_'.site::P_MOTOR_HACMI] ? '':' style="display:none";'?>>
						<?=$site->get_param_select(site::P_MOTOR_HACMI,$_GET['p_'.site::P_MOTOR_HACMI],'','- Hepsi -')?>
					</div>
				</div>
				
				<div class="acilir">
					<a href="#"><i class="icon-chevron-up icon-chevron-down"></i> Motor Gücü</a>
					<div<?=$_GET['p_'.site::P_MOTOR_GUCU] ? '':' style="display:none";'?>>
						<?=$site->get_param_select(site::P_MOTOR_GUCU,$_GET['p_'.site::P_MOTOR_GUCU],'','- Hepsi -')?>
					</div>
				</div>
				
				<div class="acilir">
					<a href="#"><i class="icon-chevron-up icon-chevron-down"></i> Çekiş</a>
					<div<?=$_GET['p_'.site::P_CEKIS] ? '':' style="display:none";'?>>
						<?=$site->get_param_select(site::P_CEKIS,$_GET['p_'.site::P_CEKIS],'','- Hepsi -')?>
					</div>
				</div>
				
				<div class="acilir">
					<a href="#"><i class="icon-chevron-up icon-chevron-down"></i> Garanti</a>
					<div<?=$_GET['garanti']? '':' style="display:none";'?>>
						<?=html::selecta(array('- Hepsi -','Evet','Hayır'),'garanti',$_GET['garanti'])?>
					</div>
				</div>
				
				<div class="acilir">
					<a href="#"><i class="icon-chevron-up icon-chevron-down"></i> Plaka</a>
					<div<?=$_GET['p_'.site::P_PLAKA] ? '':' style="display:none";'?>>
						<?=$site->get_param_select(site::P_PLAKA,$_GET['p_'.site::P_PLAKA],'','- Hepsi -')?>
					</div>
				</div>
				
				<div class="acilir">
					<a href="#"><i class="icon-chevron-up icon-chevron-down"></i> Durumu</a>
					<div<?=$_GET['durumu'] ? '':' style="display:none";'?>>
						<?=html::selecta(array('- Hepsi -','Sıfır','2. El'),'durumu',$_GET['durumu'])?>
					</div>
				</div>
				<br>
				<input type="submit" class="btn btn-success" value="Ara">
			</div>
			<input type="hidden" name="b" value="ilan">
		</form>
	</div>
	<div class="span9 menu8 ilan-ana">
		<? if($magaza):?>
			<div class="magaza kisa">
	        	<div class="logo2"><img src="/user/magaza/<?=$magaza->id?>.jpg"></div>
	        	<div class="info2"><strong><?=$magaza->magaza_adi?></strong><p><?=$magaza->aciklama?></p></div>
	        </div>
		<? endif;?>
		<div class="kayit">Aramanızda toplam <strong><?=$sayi?></strong> kayıt bulundu.</div>
		<div class="tabs">
			<a href="<?=$link?>&kimden=0" <?=$_GET['kimden']?'':'class="sel"'?>>Tüm İlanlar</a>
			<a href="<?=$link?>&kimden=1" <?=$_GET['kimden']==1?'class="sel"':''?>>Sahibinden</a>
			<a href="<?=$link?>&kimden=2" <?=$_GET['kimden']==2?'class="sel"':''?>>Galeriden</a>
		</div>
        <div class="sonuclar">
        	<div class="head">
				Görünüm :  
				<div class="btn-group btn-group-horizontal">
		            <a href="<?=$link?>&list=0" class="btn btn-mini"><i class="icon-th-list icon-small"></i></a>
		            <a href="<?=$link?>&list=liste" class="btn btn-mini" type="button"><i class="icon-align-justify"></i></a>
		            <a href="<?=$link?>&list=blok" class="btn btn-mini" type="button"><i class="icon-th"></i></a>
		        </div>
		        
		        <div class="sayfala">
		        	<select name="order" onchange="location.href='<?=$link?>&order='+this.value;">
		        		<option value="0">Gelişmiş Sıralama</option>
		        		<option value="1" <?=$order==1?'selected':''?>>Fiyata Göre (Önce en yüksek)</option>
		        		<option value="2" <?=$order==2?'selected':''?>>Fiyata Göre (Önce en düşük)</option>
		        		<option value="3" <?=$order==3?'selected':''?>>Tarihe Göre (Önce en yeni)</option>
		        		<option value="4" <?=$order==4?'selected':''?>>Tarihe Göre (Önce en eski)</option>
		        	</select>
		        	<select name="lpp" onchange="location.href='<?=$link?>&lpp='+this.value;"><option value="20" <?=$lpp==20?'selected':''?>>20</option><option value="50" <?=$lpp==50?'selected':''?>>50</option></select> Kayıt Göster
		        </div>
        	</div>
        	
        	<? if(!$_GET['list']) : ?>
        	<table>
    			<tr>
	    			<th width="88px"></th>
	    			<th>İlan Başlığı</th>
	    			<th><a href="<?=$link?>&order=<?=$order==4?3:4?>">Yıl</a></th>
	    			<th><a href="<?=$link?>&order=<?=$order==6?5:6?>">Km</a></th>
	    			<th>Renk</th>
	    			<th><a href="<?=$link?>&order=<?=$order==2?1:2?>">Fiyat</a></th>
	    			<th><a href="<?=$link?>&order=<?=$order==4?3:4?>">İlan Tarihi</a></th>
	    			<th>İl / İlçe</th>
	    		</tr>
	    		<? foreach($liste as $i=>$e): ?>
    			<tr>
                    <td><a href="/ilan/<?=$e->link.'-'.$e->ilan_id?>" title="<?=$e->baslik?>"><img src="/static/img/mf.png" alt="<?=$e->baslik?>"></a></td>
                    <td style="text-align:left;width:300px;"><a href="/ilan/<?=$e->link.'-'.$e->ilan_id?>" title="<?=$e->baslik?>"><?=$e->baslik?></a><br><i><?=$e->guzel_kategori?></i></td>
                    <td><?=$e->yil?></td>
                    <td><?=$e->km?></td>
                    <td><?=ilan::$dparams[$e->renk]?></td>
                    <td style="text-align:right;color:#870000;width:80px;"><?=number_format($e->fiyat,2)?> <?=$e->para_birimi?></td>
                    <td><?=lifos::to_web_date($e->tarih)?></td><td><?=$e->il?><br><?=$e->ilce?> </td>
                </tr>
                <? endforeach; ?>
	    	</table>
        	<? elseif($_GET['list']=='liste') : ?>
        	<table>
    			<tr>
	    			<th width="88px"></th>
	    			<th>İlan Başlığı</th>
	    			<th>Fiyat</th>
	    			<th>İlan Tarihi</th><th>İl / İlçe</th>
	    		</tr>
	    		<? foreach($liste as $i=>$e): ?>
    			<tr>
                    <td><a href="/ilan/<?=$e->link.'-'.$e->ilan_id?>" title="<?=$e->baslik?>"><img src="/user/files/thumb_<?=$e->foto?>" alt="<?=$e->baslik?>"></a></td>
                    <td style="text-align:left;width:300px;"><a href="/ilan/<?=$e->link.'-'.$e->ilan_id?>" title="<?=$e->baslik?>">#<?=$e->ilan_id?><br><?=$e->baslik?></a></td>
                    <td style="text-align:right;color:#870000;width:80px;"><?=number_format($e->fiyat,2)?> <?=$e->para_birimi?></td>
                    <td><?=lifos::to_web_date($e->tarih)?></td><td><?=$e->il?><br><?=$e->ilce?> </td>
                </tr>
                <? endforeach; ?>
	    	</table>
        	<? else : ?>
        	<div class="ilan-blok">
	    		<? foreach($liste as $i=>$e): ?>
    			<div>
                    <div class="foto"><a href="/ilan/<?=$e->link.'-'.$e->ilan_id?>" title="<?=$e->baslik?>"><img src="/user/files/thumb_<?=$e->foto?>" alt="<?=$e->baslik?>"></a></div>
                    <div class="bilgi">
                    	<a href="/ilan/<?=$e->link.'-'.$e->ilan_id?>" title="<?=$e->baslik?>">#<?=$e->ilan_id?></a><br>
                    	<a href="/ilan/<?=$e->link.'-'.$e->ilan_id?>" title="<?=$e->baslik?>"><?=$e->baslik?></a><br>
                    	<span class="fiyat"><?=number_format($e->fiyat)?></span><br>	
                    	<strong>Yıl : </strong> <?=$e->yil?><br>	
                    	<strong>Km : </strong> <?=$e->km?><br>	
                    	<strong>Renk : </strong> <?=ilan::$dparams[$e->renk]?><br>
                    	<strong>İlan Tarihi: </strong> <?=lifos::to_web_date($e->tarih)?><br>	
                    	<strong>İl / İlçe : </strong> <?=$e->ilce?> / <?=$e->il?>	
                    </div>
                </div>
                <? endforeach; ?>
        	</div>
        	<? endif;?>
        </div>
		
		<?=$pager?>
	</div>
</div>

<script>
$(document).ready(function(){
	$('select[name=il]').live('change',function(){
		var a = $(this); 
		$.post('/index.php?a=ilan/ilce_select',{il:$(this).val()},function(b){
			if(b) $('select[name=ilce]').parent().html(b);
		});
	});

	$('.acilir a').click(function(){
		$(this).next().toggle();
		$('i',$(this)).toggleClass('icon-chevron-down');
		return false;
	});
});
</script>


