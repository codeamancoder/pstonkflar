<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Doping Düzenle</h3>
</div>
<div class="modal-body">
	<form name="jxfrm">
		<input type="checkbox" name="doping_manset" value="1" <?=$ilan->doping_manset ? 'checked':''?> > Ana sayfa vitrini<br>
    	<input type="checkbox" name="doping_manset2" value="1" <?=$ilan->doping_manset2 ? 'checked':''?>> Kategori vitrini<br>
    	<input type="checkbox" name="doping_ara" value="1" <?=$ilan->doping_ara ? 'checked':''?>> Detaylı arama vitrini<br>
    	<input type="checkbox" name="doping_acil" value="1" <?=$ilan->doping_acil ? 'checked':''?>> Acil İlan<br>
    	<input type="checkbox" name="doping_fiyat" value="1" <?=$ilan->doping_fiyat ? 'checked':''?>> Fiyatı düşenler<br>
    	<input type="hidden" name="id" value="<?=$_REQUEST['id']?>">
	</form>
</div>
<div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Kapat</button>
    <button class="btn btn-primary" name="btnSubmit">Kaydet</button>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $('button[name=btnSubmit]').click(function(){
        $.post('index.php?a=uye/doping_duzenle',$('form[name=jxfrm]').serialize(),function(a){
        	
             $('#dialog').modal('hide');
          
        });
        return false;
    });	
});
</script>