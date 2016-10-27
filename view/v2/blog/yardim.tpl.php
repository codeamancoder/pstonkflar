<?=$message ? '<br>'.$message:''?>
<!-- MAIN CONTENT

                                      ================= -->

<style>
	table td { border: none !important;}
</style>
<main id="main-content" class="col-md-8">

	<?php echo $duyuru; ?>

	<!-- POST CONTENT -->
	<article class="article-large hentry">

		<header class="show">
			<h1 class="entry-title">Yardım</h1>
		</header>

		<div class="entry-content">
		Aşağıdaki form aracılığı ile bize istek dilek ve şikayetlerinizi hızlıca iletebilirsiniz. <br><br>
		<form method="post">
			<div class="table-responsive">
			<table class="table">
				<tr><td><b>Adınız ve Soyadınız</b> </td><td><input type="text" name="ad" value="<?=$_POST['ad']?>"></td></tr>
				<tr><td><b>Konu</b> </td><td><select name="konu"><option value="Şikayet">Şikayet</option><option value="Önderi">Öneri</option><option value="İstek">İstek</option></select></td></tr>
				<tr><td><b>Eposta Adresiniz</b> </td><td><input type="text" name="eposta" value="<?=$_POST['eposta']?>"></td></tr>
				<tr><td><b>Telefon Numaranız</b> </td><td><input type="text" name="tel" value="<?=$_POST['tel']?>"></td></tr>
				<tr><td><b>Mesajınız</b></td><td><textarea name="mesaj" style="width:450px;height:200px;"><?=$_POST['mesaj']?></textarea></td></tr>
				<tr><td><b>Doğrulama Kodu</b></td><td><?=lifos::captcha()?><br><input type="text" name="code" placeholder="Kodu giriniz."></td></tr>
				<tr><td></td><td><input type="submit" name="btnGonder" value="Gönder" class="btn btn-success"></td></tr>
			</table>
			</div>
		</form>
	</div>
	</article><!-- .hentry -->


</main><!--#main-content-->

<?=$sag_menu_2?>
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
