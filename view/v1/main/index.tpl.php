<a href="https://www.pistonkafalar.com/index.php?b=ilan"><img src="../../static/v1/img/ustbanner1.png" width="990" height="95" style="margin-bottom:5px;"></a>
<? if($manset_ustu):?>
<div class="manset_ustu">
	<?=$manset_ustu->icerik?>
</div>
<? endif;?>
<div class="manset_haber">
	<section id="manset">
		<div class="foto">
			<a href="/<?=$haber_manset[0]->link.'-'.$haber_manset[0]->id?>">
				<img src="/user/files/<?=$haber_manset[0]->foto?>">
				<i><?=$haber_manset[0]->tip=='video' ? 'Video : ' : ($haber_manset[0]->tip=='galeri' ? 'Galeri : ':'')?><?=$haber_manset[0]->baslik?></i>
			</a>
		</div>
		<div class="others">
			<div class="items">
		    <? foreach($haber_manset as $i=>$manset) :?>
		    	<a href="<?=$manset->link.'-'.$manset->id?>">
		        	<img src="/user/files/<?=$manset->foto?>" id="manset_<?=$manset->id?>" alt="<?=$manset->tip=='video' ? 'Video : ' : ($manset->tip=='galeri' ? 'Galeri : ':'')?><?=$manset->baslik?>">
		        </a>
			<? endforeach; ?>
		    </div>
		</div>
	</section>

	
	
	<section id="haberler">
		<h4>HABERLER<a href="/index.php?b=blog/haberler">Diğer Haberler →</a></h4>
		<div class="row haberler">			
		    <? foreach($haberler as $i=>$haber) :?>
		    	<div class="haber span4">
		    		<div class="foto"><a class="pull-left" href="<?=$haber->link?>-<?=$haber->id?>"> <img src="/user/files/wrap_<?=$haber->foto?>" id="manset_<?=$manset->id?>" title="<?=lifos::convert_case_title($haber->baslik);?>"> </a></div>
			    	<div class="baslik">
				    	<a class="pull-left" href="<?=$haber->link?>-<?=$haber->id?>"><strong><?=lifos::substr($haber->baslik,45,'..')?></strong></a>
				    	<p class="muted"><small><?=lifos::substr($haber->ozet,58,'..')?></small></p>
		    		</div>
	    		</div>
			<? endforeach; ?>
		</div>
		
	</section>
</div>
<div class="sag_menu_1">
	<?=$sag_menu_1?>
</div>


<div class="testler">
	<section id="haberler">
		<h4>TESTLER<a href="/index.php?b=blog/test">Diğer Testler →</a></h4>
		<a class="icon-chevron-left prev"></a>
		<div class="test-slider">
			<div class="row testler items2">			
			    <? foreach($testler as $i=>$haber) :?>
			    	<?=$i%6==0 ? '<div>':''?>
			    	<div class="haber span2">
			    		<div class="foto"><a href="<?=$haber->link?>-<?=$haber->id?>"> <img src="/user/files/wrap_<?=$haber->foto?>" id="manset_<?=$manset->id?>" title="<?=lifos::convert_case_title($haber->baslik);?>"> </a></div>
				    	<div class="baslik">
					    	<p><small><?=lifos::substr($haber->baslik,45,'..')?></small></p>
			    		</div>
		    		</div>
			    	<?=$i%6==5 ? '</div>':''?>
				<? endforeach; ?>
		    	<?=$i%6==5 ? '':'</div>'?>
			</div>
		</div>
		
		<a class="icon-chevron-right next"></a>
	</section>

    <section id="orta_reklam">
        <?=$reklam_ana_orta->icerik?>
    </section>
</div>



<div class="orta2">
	<section id="yenilik_modifiye">
		<div class="row">			
			<div class="yenilikler">
				<h4>YENİLİKLER<a href="/index.php?b=blog/yenilikler">Diğer Yenilikler →</a></h4>
				<div class="row haberler">
					<? foreach($yenilikler as $i=>$haber) :?>
			    	<div class="haber span4">
			    		<div class="foto"><a class="pull-left" href="<?=$haber->link?>-<?=$haber->id?>"> <img src="/user/files/wrap_<?=$haber->foto?>" id="manset_<?=$manset->id?>" title="<?=lifos::convert_case_title($haber->baslik);?>"> </a></div>
				    	<div class="baslik">
					    	<a class="pull-left" href="<?=$haber->link?>-<?=$haber->id?>"><strong><?=lifos::substr($haber->baslik,45,'..')?></strong></a>
					    	<p class="muted"><small><?=lifos::substr($haber->ozet,58,'..')?></small></p>
			    		</div>
		    		</div>
					<? endforeach; ?>
				</div>
			</div>
			
			<div class="modifiye">
				<h4>MODİFİYE<a href="/index.php?b=blog/modifiye">Diğer Modifiye →</a></h4>
				<div class="row haberler">
					<? foreach($modifiye as $i=>$haber) :?>
			    	<div class="haber span4">
			    		<div class="foto"><a class="pull-left" href="<?=$haber->link?>-<?=$haber->id?>"> <img src="/user/files/wrap_<?=$haber->foto?>" id="manset_<?=$manset->id?>" title="<?=lifos::convert_case_title($haber->baslik);?>"> </a></div>
				    	<div class="baslik">
					    	<a class="pull-left" href="<?=$haber->link?>-<?=$haber->id?>"><strong><?=lifos::substr($haber->baslik,45,'..')?></strong></a>
					    	<p class="muted"><small><?=lifos::substr($haber->ozet,58,'..')?></small></p>
			    		</div>
		    		</div>
					<? endforeach; ?>
				</div>
			</div>
		</div>
	</section>

	<section id="videolar">
		<h4>VİDEOLAR<a href="/index.php?b=blog/videolar">Diğer Videolar →</a></h4>
		<div class="videolar">			
		    <? foreach($videolar as $i=>$video) :?>
		    	<div class="video-list">
		    		<div class="foto"><a href="<?=$video->link.'-'.$video->id?>"><img src="//img.youtube.com/vi/<?=strpos($video->ozet,',') ? substr($video->ozet,0,strpos($video->ozet,',')) : $video->ozet ?>/hqdefault.jpg" title="<?=lifos::convert_case_title($video->baslik);?>"> </a>
			    		 <a href="<?=$video->link.'-'.$video->id?>" class="playbutton"></a>
			    		<div class="baslik">
					    	<p><small><?=lifos::substr($video->baslik,45,'..')?></small></p>
			    		</div>
		    		</div>
	    		</div>
			<? endforeach; ?>
		</div>
	</section>

    <section id="sektorel">
        <div class="row">
            <div class="sektorel">
                <h4>Sektörel<a href="/index.php?b=blog/sektorel">Diğer Haberler →</a></h4>
                <div class="row haberler">
                    <? foreach($sektorel as $i=>$haber) :?>
                        <div class="haber span4">
                            <div class="foto"><a class="pull-left" href="<?=$haber->link?>-<?=$haber->id?>"> <img src="/user/files/<?=$haber->foto?>" id="manset_<?=$manset->id?>" title="<?=lifos::convert_case_title($haber->baslik);?>"> </a></div>
                            <div class="baslik">
                                <a class="pull-left" href="<?=$haber->link?>-<?=$haber->id?>"><strong><?=lifos::substr($haber->baslik,45,'..')?></strong></a>
                                <p class="muted"><small><?=lifos::substr($haber->ozet,$i==0?130:58,'..')?></small></p>
                            </div>
                        </div>
                    <? endforeach; ?>
                </div>
            </div>
        </div>
    </section>
	
	<section id="kampanya_motorspor">
		<div class="row">			
			<div class="kampanyalar">
				<h4>KAMPANYALAR<a href="/index.php?b=blog/kampanyalar">Diğer Kampanyalar →</a></h4>
				<div class="row haberler">
					<? foreach($kampanyalar as $i=>$haber) :?>
			    	<div class="haber span4">
			    		<div class="foto"><a class="pull-left" href="<?=$haber->link?>-<?=$haber->id?>"> <img src="/user/files/wrap_<?=$haber->foto?>" id="manset_<?=$manset->id?>" title="<?=lifos::convert_case_title($haber->baslik);?>"> </a></div>
				    	<div class="baslik">
					    	<a class="pull-left" href="<?=$haber->link?>-<?=$haber->id?>"><strong><?=lifos::substr($haber->baslik,45,'..')?></strong></a>
					    	<p class="muted"><small><?=lifos::substr($haber->ozet,58,'..')?></small></p>
			    		</div>
		    		</div>
					<? endforeach; ?>
				</div>
			</div>
			
			<div class="motor_spor">
				<h4>Motor Sporları<a href="/index.php?b=blog/motorspor">Diğer →</a></h4>
				<div class="row haberler">
					<? foreach($motorspor as $i=>$haber) :?>
			    	<div class="haber span4">
			    		<div class="foto"><a class="pull-left" href="<?=$haber->link?>-<?=$haber->id?>"> <img src="/user/files/wrap_<?=$haber->foto?>" id="manset_<?=$manset->id?>" title="<?=lifos::convert_case_title($haber->baslik);?>"> </a></div>
				    	<div class="baslik">
					    	<a class="pull-left" href="<?=$haber->link?>-<?=$haber->id?>"> <strong><?=lifos::substr($haber->baslik,45,'..')?></strong></a>
					    	<p class="muted"><small><?=lifos::substr($haber->ozet,58,'..')?></small></p>
			    		</div>
		    		</div>
					<? endforeach; ?>
				</div>
			</div>
		</div>
	</section>
	
	<section id="cevreciler">
		<h4 class="yesil">ÇEVRECİ OTOMOBİLLER<a href="/index.php?b=blog/cevreciotomobiller">Diğer Çevreci Otomobiller→</a></h4>
		<div class="row haberler">			
		    <? foreach($cevreciler as $i=>$haber) :?>
		    	<div class="haber span4">
		    		<div class="foto"><a class="pull-left" href="<?=$haber->link?>-<?=$haber->id?>"> <img src="/user/files/wrap_<?=$haber->foto?>" id="manset_<?=$manset->id?>" title="<?=lifos::convert_case_title($haber->baslik);?>"> </a></div>
			    	<div class="baslik">
				    	<a class="pull-left" href="<?=$haber->link?>-<?=$haber->id?>"><strong><?=lifos::substr($haber->baslik,45,'..')?></strong></a>
				    	<p class="muted"><small><?=lifos::substr($haber->ozet,58,'..')?></small></p>
		    		</div>
	    		</div>
			<? endforeach; ?>
		</div>
	</section>


</div>
<div class="sag_menu_2">
	<?=$sag_menu_2?>
</div>
<script>
	var timer;
	
	function degis(y){
		if(!y) return;
		$('#manset .foto img').attr('src',$('img',y).attr('src'));
		$('#manset .foto a').attr('href',y.attr('href'));
		$('#manset .foto a i').html($('img',y).attr('alt'));
		clearTimeout(timer);
		timer = setTimeout(degis,5000,$('#manset .items a:eq('+(y.index()+1)%6+')'));
	}

	timer = setTimeout(degis,5000,$('#manset .items a:eq(1)'));
	
	$(window).load(function(){
		$('#manset .items a').hover(function(){
			degis($(this));
		});
	});
</script>

	
