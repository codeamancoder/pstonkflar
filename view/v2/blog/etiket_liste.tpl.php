<main id="main-content" class="col-md-8">
    <?php echo $duyuru; ?>
    <?= $message ?>

    <article class="article-medium">
        <div class="row">
            <ul class="list-group">
            <? foreach ($etiketler as $blog): ?>
                <li class="list-group-item">
                    <a href="/<?= $blog->link . '-' . $blog->id ?>" title="<?= $blog->baslik ?>">
                        <?= $blog->baslik ?>
                    </a>
                </li>
            <? endforeach; ?>
            </ul>
            <?= $pager ?>
        </div>
    </article>

</main><!--#main-content-->

<?= $sag_menu_2 ?>