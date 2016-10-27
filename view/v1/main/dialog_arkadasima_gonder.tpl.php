<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Arkadaşıma Gönder</h3>
</div>
<div class="modal-body">
	<form name="jxfrm">
		<input type="text" name="ad" placeholder="Adınız" class="input-xlarge"><br>
		<input type="text" name="eposta_sizin" placeholder="Eposta Adresiniz" class="input-xlarge"><br>
		<input type="text" name="eposta_arkadas" placeholder="Arkadaşınızın Eposta Adresi" class="input-xlarge"><br>
		<textarea name="mesaj" placeholder="Eklemek İstedikleriniz" class="input-xxlarge"></textarea><br>
		<?=lifos::captcha("Okunmuyor, değiştir.")?><br><br>
		<input type="text" name="captcha" id="captcha-form" autocomplete="off" placeholder="Doğrulama Kodu" /><br/>
		<input type="hidden" name="id" value="<?=$_REQUEST['id']?>">
	</form>
</div>
<div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Kapat</button>
    <button class="btn btn-primary" name="btnSubmit">Gönder</button>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $('button[name=btnSubmit]').click(function(){
        $.post('index.php?a=main/arkadasima_gonder',$('form[name=jxfrm]').serialize(),function(a){
        	var a = jQuery.parseJSON(a);
            if(a.res==1 || a.res=='1'){
                alert(a.msg);
                $('#dialog').modal('hide');
            }
            else{
                alert(a.msg);
            }
        });
        return false;
    });	
});
</script>