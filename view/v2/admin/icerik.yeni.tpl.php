<?=$message?>
<form name="frmAdayKayit" method="POST" action="?b=admin/icerik" class="yeni-uye" enctype="multipart/form-data">
<div class="stdbg">
    <h1 class="baslik">Yeni İçerik</h1>
    <table class="standart">
        <tr><td width="160px">Tip</td><td><?=html::selecta(site::$secenek_icerik_tip, 'tip',1,'','insel')?></td></tr>
        <tr><td width="160px">Başlık</td><td><input type="text" name="baslik" value="" valid="text" class="intext"></td></tr>
        <tr><td>Link</td><td><input type="text" name="link" value="" valid="text" class="intext"></td></tr>
        <tr id="foto" class="gizli"><td>Haber Fotoğrafı</td><td><input type="file" name="foto"> 350x185px boyutlarında</td></tr>
        <tr><td>Özet</td><td><textarea class="intext" name="ozet" style="height: 182px; width: 800px;"></textarea></td></tr>
        <tr><td>İçerik</td><td><?=get_editor('','haber')?></td></tr>
        <tr><td></td><td><input type="submit" name="btnYeniIcerik" class="btn" value="Kaydet"></td></tr>
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
