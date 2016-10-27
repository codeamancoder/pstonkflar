<div class="span8 etiketler-liste">
<?=$navi?>
<?=$message?>
<br>
<div class="row">
<ul>
<? foreach($etiketler as $blog):?>
	<li>
		<a href="/<?=$blog->link.'-'.$blog->id?>" title="<?=$blog->baslik?>">
	  		<?=$blog->baslik?>
	  	</a>
	</li>
<? endforeach;?>
</ul>
</div>
<br>
<?=$pager?>
</div>
<div class="span4"><?=$sag_menu?></div>