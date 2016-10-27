<div class="haberler-liste">
<?=$navi?>
<h3><?=$baslik?></h3>
<?=$message?>
<? foreach($haberler as $blog):?>
    <div class="media">
  		<a class="pull-left" href="<?=$blog->link.'-'.$blog->id?>" title="<?=$blog->baslik?>">
    		<img class="media-object" src="/user/files/wrap_<?=$blog->foto?>" alt="<?=$blog->baslik?>">
  		</a>
  		<div class="media-body">
    		<h4 class="media-heading"><a href="<?=$blog->link.'-'.$blog->id?>"><?=$blog->baslik?></a></h4>
    		<?=$blog->ozet?><br>
        	<a href="<?=$blog->link.'-'.$blog->id?>">Devamını Oku</a>
    	</div>
    </div>
<? endforeach;?>
<?=$pager?>
</div>
<div class="sag_menu_1"><?=$sag_menu?></div>