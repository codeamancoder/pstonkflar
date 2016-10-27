<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Lifos Fotoğraf Kesme Aracı</title>
<style>
	*{margin:0;padding:0;}
	html{overflow: hidden;font-family: sans-serif;font-size: 11px;}
	.img{background-color: #EDF5FF;min-width: 400px;min-height: 300px;padding:10px;max-height: 700px;}

	.btn{padding:10px;}
	.btn input{margin:10px 10px 10px 0;}
</style>
<script type="text/javascript" src="/static/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/include/lib/jquery.Jcrop.min.js"></script>
<link rel="stylesheet" href="/include/lib/jquery.Jcrop.css" type="text/css" />
<script type="text/javascript">
$(document).keypress(function(a){
	if(a.keyCode==27)
	{
		window.close();
	}
	else if(a.keyCode==13)
	{
		$('.kaydet').click();
	}
});
$(window).load(function(){
	//window.resizeTo(400,300);
	window.resizeTo(<?=$windowWidth?>,<?=$windowHeight?>);
	var api = $.Jcrop('.img img',{ 
		bgOpacity: .4,
		minSize:[<?=$minWidth?>],
		allowResize:true,
		allowSelect:false 
		<?=$targetAspectRatio?> 
	});

    // Immediately set selection (can also be set by options)
    api.animateTo([ <?=$ts?> ]);


	$('.kapat').click(function(){
		window.close();
	});

	$('.kaydet').click(function(){
		var a=api.tellSelect();
		$.ajax({
			//type:'post',
			url:'index.php?b=uye/crop',
			data:{'im':'<?=$img?>','tw':<?=$targetWidth?>,'th':<?=$targetHeight?>,'n':a,'r':<?=$displayRatio?>,'kaydet':1},
			success:function(a){
					
				if(a)
				{
					var s = '/user/files/wrap_<?=$file->path?>';
					var b = $('#img_<?=$file->id?>',window.opener.document);
					b.css({'width':<?=($targetWidth/$targetHeight)*120+10?>,'background':'none'});
					$('.foto',b).css({'max-width':<?=$targetWidth/2?>});
					$('.foto',b).html('<img src="'+s+'?r='+Math.random()+'">');
					//$('.foto',b).css('background-image',s+'?r='+Math.random());
					//b.attr('src',b.attr('src')+'?r='+Math.random());
					
					window.close();
				}
			}
		});
	});

	
//	crop.canMove(false);
});
</script>
</head>
<body>
	<?php if($hata) {echo $hata.'</body>'; return;}?>
	<div class="img"><img src="/user/files/<?=$file->path?>" style="max-width:<?=$maxDisplaySize?>px;max-height:<?=$maxDisplaySize?>px;"></div>
	<div class="btn">Fotoğrafın görünmesini istediğiniz kısımı seçerek kaydedebilirisiniz. Fotoğrafları kaydetmeden önce öntanımlı olarak gelen seçili alanı fare vasıtasıyla yukarı, aşağı, sağa ve sola kaydederek kullanacıgınız alanı seçebilirsiniz. Bu aşamadan sonra kaydettiğiniz zaman seçili fotograf eski fotoğrafın yerine kullanılacaktır.<br/><br/><input type="button" class="kaydet" value="Kaydet"><input type="button" class="kapat" value="Kapat"></div>
</body>
</html>