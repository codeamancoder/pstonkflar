<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Yorum Gönder</h3>
</div>
<div class="modal-body">
	<form name="jxfrm">
		<?=lifos::star_rating(60,true)?><br>
		<textarea name="mesaj" placeholder="Yorumunuzu bu alana yazıp gönderebilirsiniz." class="input-xxlarge" style="height:100px;"></textarea><br>
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
        $.post('index.php?a=main/yorum',$('form[name=jxfrm]').serialize(),function(a){
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