<!-- BREAKING NEWS -->
<? if($site->duyuru): ?>
    <section class="breaking-news">
        <header>
            <h4>Duyurular</h4>
            <i class="triangle"></i>
        </header>
        <div class="content">
            <ul>
                <? foreach ($site->duyuru as $duyuru):?>
                    <li><a href="/<?=$duyuru->link.'-'.$duyuru->id?>"><i class="fa fa-angle-double-right"></i> <?=lifos::substr($duyuru->baslik,45,'...')?></a></li>
                <? endforeach;?>
            </ul>
        </div>
    </section>
<?php endif; ?>