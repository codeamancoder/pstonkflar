<?=$navi?>
<?=$message ? '<br>'.$message:''?>
<div class="haberler-detay">
<h3>Yardım</h3><br>Aşağıdaki form aracılığı ile bize istek dilek ve şikayetlerinizi hızlıca iletebilirsiniz. <br><br>
<form method="post">
	<table>
		<tr><td width="150px"><b>Adınız ve Soyadınız</b> </td><td><input type="text" name="ad" value="<?=$_POST['ad']?>"></td></tr>
		<tr><td><b>Konu</b> </td><td><select name="konu"><option value="Şikayet">Şikayet</option><option value="Önderi">Öneri</option><option value="İstek">İstek</option></select></td></tr>
		<tr><td width="150px"><b>Eposta Adresiniz</b> </td><td><input type="text" name="eposta" value="<?=$_POST['eposta']?>"></td></tr>
		<tr><td width="150px"><b>Telefon Numaranız</b> </td><td><input type="text" name="tel" value="<?=$_POST['tel']?>"></td></tr>
		<tr><td><b>Mesajınız</b></td><td><textarea name="mesaj" style="width:450px;height:200px;"><?=$_POST['mesaj']?></textarea></td></tr>
		<tr><td><b>Doğrulama Kodu</b></td><td><?=lifos::captcha()?><br><input type="text" name="code" placeholder="Kodu giriniz."></td></tr>
		<tr><td></td><td><input type="submit" name="btnGonder" value="Gönder" class="btn btn-success"></td></tr>
	</table>
</form>
</div>
<script>
	$(document).ready(function(){ 
		$('input[name=btnGonder]').click(function(){
			var e='';

			if(!$('input[name=ad]').val()) e+='* Adınızı giriniz\n';
			if(!$('input[name=eposta]').val()) e+='* Eposta adresinizi giriniz\n';
			if(!$('input[name=tel]').val()) e+='* Telefon numaranızı giriniz\n';
			if(!$('textarea[name=mesaj]').val()) e+='* Mesajınızı giriniz\n';
			if(!$('input[name=code]').val()) e+='* Doğrulama kodunu giriniz\n';

			if(e) {
				alert(e);
				return false;
			}
		});
	});
</script>
<div class="sag_menu_1">
	<?=$sag_menu?>
</div>