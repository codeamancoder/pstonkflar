<div class="blog-menulu">
<div class="icerikmenu" style="width:220px; float:left;">
    <h1><?=$baslik?></h1>
    <ul>
    <? foreach($liste as $o):?>
        <li<?=$o->link == $link ? ' class="secili"':''?>><a href="?b=blog/<?=$o->link?>"><?=$o->baslik?></a></li>    
    <? endforeach; ?> 
    </ul>
</div>
<div class="icerik right" style="width:760px;">
    <h1 class="baslik2"><?=$icerik->baslik?></h1>
    <?=$icerik->ozet ? '<span class="ozet">'.$icerik->ozet.'</span>':''?>
    <?=$icerik->icerik?>
</div>
</div>