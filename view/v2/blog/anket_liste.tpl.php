<div class="haberler-liste">
<?=$navi?>
<h3><?=$baslik?></h3>
<?=$message?>
<ul>
<? foreach($anketler as $blog):?>
    <li>
    	<a href="<?=$blog->link.'-'.$blog->id?>"><?=$blog->baslik?></a>
    </li>
<? endforeach;?>
</ul>
<?=$pager?>
</div>
<div class="sag_menu_1"><?=$sag_menu?></div>