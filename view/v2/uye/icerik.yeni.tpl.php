<?=$message?>
<form name="frmAdayKayit" method="POST" action="?b=admin/icerik" class="yeni-uye" enctype="multipart/form-data">
<div class="stdbg">
    <h3>Yeni Yazı</h3>
    <table class="standart">
        <tr><td width="160px">Başlık</td><td><input type="text" name="baslik" value="" valid="text" class="intext"></td></tr>
        <tr><td>Özet</td><td><textarea class="intext" name="ozet" style="height: 182px; width: 800px;"></textarea></td></tr>
        <tr><td>İçerik</td><td><textarea class="ckeditor" name="editor" style="height: 182px; width: 800px;"></textarea></td></tr>
        <tr><td></td><td><br><input type="submit" name="btnYeniIcerik" class="btn btn-success" value="Kaydet"></td></tr>
    </table>
</div>
</form>
<script type="text/javascript" src="/static/lib/ck41/ckeditor.js"></script>