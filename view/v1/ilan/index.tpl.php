<div id="ilan-liste">
	<div class="ilan-menu">
		<form name="frmYan" method="get" action="index.php?b=ilan">
			<div class="well kategori-menu" style="padding:5px 0;">
				<ul class="nav nav-list">
					<li class="nav-header">Kategoriler</li>
					<?=$menu?>
				</ul>
			</div>
		</form>
	</div>
	<div class="ilan-ana">
		<? if($reklam) :?>
			<?=$reklam->icerik?>
		<? endif;?>
		
		
		<h4><?=$baslik?></h4>
		<a href="?b=ilan&vitrin=1<?=$_GET['cat']?'&cat='.$_GET['cat']:''?>">Tüm Vitrin İlanları</a>
		<div class="row-fluid vitrin-ilanlar">
			<? foreach ($ilanlar as $ilan):?>
			<div class="span2">
				<div class="foto"><a href="/ilan/<?=$ilan->link.'-'.$ilan->ilan_id?>"><img src="/user/files/thumb_<?=$ilan->foto?>"></a></div>
				<div class="info"><small><a href="/ilan/<?=$ilan->link.'-'.$ilan->ilan_id?>"><?=lifos::substr($ilan->baslik,13,'...')?></a></small></div>
			</div>
			<? endforeach;?>
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


