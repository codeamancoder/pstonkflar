<? foreach($blogs as $blog):?>
    <div class="blog-liste">
        <h1><?=$blog->baslik?></h1>
        <div class="img"><img src="/user/blog/<?=$blog->img1?>" alt="<?=$blog->baslik?>"></div>
        <span class="ozet"><?=$blog->ozet?></span>
        <a href="?b=blog/<?=$blog->link?>">Devamını Oku</a>
    </div>
<? endforeach;?>
<?=$pager?>