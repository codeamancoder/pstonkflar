<?=$navi?>
<?=$message?>
<div class="galeriler-liste">
<h3>Galeriler</h3>
<? foreach($galeriler as $blog):?>
    <div class="galeri-ana">
  		<a href="<?=$blog->link.'-'.$blog->id?>" title="<?=$blog->baslik?>">
    		<img src="/user/files/wrap_<?=$blog->kapak?>" alt="<?=$blog->baslik?>">
  		</a>
  		<div>
    		<h6 class="media-heading"><?=$blog->baslik?></h6>
    	</div>
    </div>
<? endforeach;?>
<?=$pager?>
</div>
<div class="sag_menu_1"><?=$sag_menu?></div>