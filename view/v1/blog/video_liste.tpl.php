<div class="videolar-liste">
<?=$navi?>
<h3><?=$baslik?></h3>
<?=$message?>

<div class="videolistesi">
<? foreach($videolar as $blog):?>
	<div class="videosira">
		<div class="vfoto">
		<a href="/<?=$blog->link.'-'.$blog->id?>" class="playbutton"></a>
	  		<a class="pull-left" href="/<?=$blog->link.'-'.$blog->id?>" title="<?=$blog->baslik?>">
	    		<img src="https://img.youtube.com/vi/<?=strpos($blog->ozet,',') ? substr($blog->ozet,0,strpos($blog->ozet,',')) : $blog->ozet?>/hqdefault.jpg" alt="<?=$blog->baslik?>">
	  		</a>
	  	</div>
	  	<div class="info">
    		<p><small><?=$blog->baslik?></small></p>
		</div>
    </div>
<? endforeach;?>
</div>

<?=$pager?>
</div>
<div class="sag_menu_1"><?=$sag_menu?></div>