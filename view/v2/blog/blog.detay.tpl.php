<div class="blog-detay">
<h1><?=$icerik->baslik?></h1>
<?=$icerik->ozet ? '<span class="ozet">'.$icerik->ozet.'</span>':''?>
<img src="/user/blog/<?=$icerik->img1?>" align="left" style="padding:0 15px 10px 0;">
<span class="detay"><?=$icerik->icerik?></span>
<div class="tarih"><?=towebdate($icerik->tarih_yayin)?></div>
</div>


