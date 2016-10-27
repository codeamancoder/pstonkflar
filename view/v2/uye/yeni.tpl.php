
<script type="text/javascript" src="/static/v2/js/jquery.mask.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){

	$('.tel').mask('0 (999) 999 99 99');
	
	$('input[name=eposta]').change(function(){ 
		if( (/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/.test($(this).val())) )	{
			$.get('index.php?a=uye/eposta&d='+$(this).val(),function(r){ $('#jxPosta').html(r>=1 ? '<span style=\"color:red;\">Bu eposta zaten kayıtlı!</span>' : '' );}); 
		}
		else $('#jxPosta').html('<span style="color:red">Lütfen doğru bir eposta giriniz.</span>');
	});
    $('input[name=sifre2]').change(function(){ if( $(this).val() != $('input[name=sifre1]').val()) alert('Girilen Şifreler Uyuşmuyor'); });

    $('select[name=ulke]').change(function(){
		if( $(this).val()=='Türkiye' ) $('select[name=sehir]').removeAttr('disabled'); 
		else $('select[name=sehir]').attr('disabled','disabled'); 
    });
});
</script>

<main id="main-content" class="col-md-8">
	<section class="widget">
		<h4><?php echo $message; ?></h4>
		<!--Header-->
		<header class="clearfix"><h4>Üye Ol</h4></header>

		<!--Content: sign up form-->
		<form class="form-horizontal" class="register_form" role="form" action="?b=uye/yeni" method="POST">
			<input type="hidden" name="btnYeniUye" value="1">
			<div class="form-group">
				<label for="new-first-name" class="col-sm-2">Adınız Soyadınız*</label>
				<div class="col-sm-5">
					<input type="text" name="ad" value="<?=$_POST['ad']?>" id="new-first-name" placeholder="Ad Soyad" required>
				</div>
			</div><!--name-->

			<div class="form-group">
				<label for="new-email" class="col-sm-2 ">Email Adresiniz*</label>
				<div class="col-sm-10">
					<input type="email" name="eposta" value="<?=$_POST['eposta']?>" id="new-email" placeholder="Email" required>
					<div id="jxPosta"></div>
				</div>

			</div><!--email-->

			<div class="form-group">
				<label for="new-password" class="col-sm-2">Şifreniz*</label>
				<div class="col-sm-5">
					<input type="password" name="sifre1" id="new-password" placeholder="Şifre" required>
				</div>
				<div class="col-sm-5">
					<input type="password" name="sifre2" id="new-password-2" placeholder="Şifre Tekrar" required>
				</div>
			</div><!--password-->

			<div class="form-group">
				<label for="new-phone" class="col-sm-2">Telefon</label>
				<div class="col-sm-10">
					<input type="tel" name="tel" value="<?=$_POST['tel']?>" id="new-phone" class="tel" placeholder="Telefon" required>
				</div>
			</div><!--phone-->

			<div class="form-group">
				<label class="col-sm-2">Cinsiyet</label>
				<div class="col-sm-10">
					<div class="radio">
						<label><input type="radio" name="cinsiyet" value="1"> Bay </label>
					</div>
					<div class="radio">
						<label><input type="radio" name="cinsiyet" value="0"> Bayan </label>
					</div>
				</div>
			</div><!--gender-->

			<div class="form-group">
				<label class="col-sm-2" for="new-month">Doğum Tarihi</label>
				<div class="col-sm-4">
					<?=html::select_ay('ay')?>
				</div>
				<div class="col-sm-3">
					<?=html::select_range(1,31,'gun',false,false,false,1,'%02d')?>
				</div>
				<div class="col-sm-3">
					<?=html::select_range(2000,1900,'yil')?>
				</div>
			</div><!--birthday-->

			<div class="form-group">
				<label class="col-sm-2" for="new-month">Ülke / Şehir</label>
				<div class="col-sm-4">
					<?=html::select($ulkeler,'ulke','Türkiye','ad','ad',0)?>
				</div>

				<div class="col-sm-4">
					<?=html::select($sehirler,'sehir',$_POST['sehir'],'il','il',0,'- Seçiniz -')?>
				</div>
			</div>


			<div class="form-group">
				<label for="new-textarea" class="col-sm-2">Doğrulama Kodu</label>
				<div class="col-sm-5">
					<?=lifos::captcha('Değiştir');?>
				</div>
				<div class="col-sm-3">
					<input type="text" name="code" value="" id="code" placeholder="Doğrulama Kodu" required>
				</div>
			</div><!--textarea-->

			<div class="form-group">
				<div class="col-sm-push-2 col-sm-10">
					<div class="checkbox">
						<label>
							<input type="checkbox" name="sozlesme" value="1"><a href="#" onclick="window.open('/index.php?b=blog/hizmetsozlesmesi2','Hizmet Sözleşmesi','width=800,height=600'); return false;">Hizmet sözleşmesini</a> onaylıyorum.
						</label>
					</div>
				</div>
			</div><!--term-->

			<div class="form-group">
				<div class="col-sm-push-2 col-sm-10">
					<button type="submit" class="btn btn-primary">Kaydet</button>
				</div>
			</div><!--submit-->
		</form>
	</section>
</main><!--#main-content-->

<?php echo $sag_menu_2; ?>