<?=$message?>
<form name="frmAdayKayit" method="POST" action="?b=admin/icerik" class="yeni-uye" enctype="multipart/form-data">
<div class="stdbg">
    <h1 class="baslik">İçerik Düzenle</h1>
    <table class="standart">
        <tr><td width="160px">Tip</td><td><input type="text" disabled value="<?=site::$secenek_icerik_tip[$icerik->tip]?>" class="intext"></td></tr>
        <tr><td width="160px">Başlık</td><td><input type="text" name="baslik" value="<?=$icerik->baslik?>" valid="text" class="intext"></td></tr>
        <tr><td>Link</td><td><input type="text" name="link" value="<?=$icerik->link?>" valid="text" class="intext"></td></tr>
        <tr id="foto" class="<?=$icerik->tip==2?'':'gizli'?>"><td>Haber Fotoğrafı</td><td><?=$icerik->img1 ? '<img src="/user/icerik/'.$icerik->img1.'"><br>':''?><input type="file" name="foto"> 350x185px boyutlarında</td></tr>
        <tr><td>Özet</td><td><textarea class="intext" name="ozet" style="height: 182px; width: 800px;"><?=$icerik->ozet?></textarea></td></tr>
        <tr><td>İçerik</td><td><?=get_editor($icerik->icerik,'haber')?></td></tr>
        <tr><td></td><td><input type="submit" name="btnIcerikDuzenle" class="btn" value="Kaydet"><input type="hidden" name="id" value="<?=$_REQUEST['id']?>"></td></tr>
    </table>
</div>
</form>
<script type="text/javascript">
$(document).ready(function(){
	$('select[name=tip]').change(function(){
	    if($(this).val() == 2) $('tr#foto').removeClass('gizli');
	    else $('tr#foto').addClass('gizli');
	});
});
</script>
