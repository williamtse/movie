<?php foreach ($movies as $movie){?>
    <article class="excerpt excerpt-1">
        <a class="focus" href="/movie/<?=$movie['id']?>" title="<?=$movie['title']?>" target="_blank" draggable="false">
            <img class="thumb" data-original="<?=Douban_GetPoster($movie['poster'],'s')?>"
                 src="<?=Douban_GetPoster($movie['poster'],'s')?>"
                 alt="<?=$movie['title']?>" style="display: inline;" draggable="false"></a>
        <header><a class="cat" href="#" title="<?=$movie['name']?>" draggable="false"><?=$movie['name']?><i></i></a>
            <h2><a href="/movie/<?=$movie['id']?>" title="<?=$movie['title']?>"
                   target="_blank" draggable="false"><?=$movie['title']?></a></h2>
        </header>
        <p class="meta">
            <time class="time"><i class="glyphicon glyphicon-time"></i> <?=date('Y-m-d',$movie['created_at'])?></time>
            <span class="views"><i class="glyphicon glyphicon-download"></i> 217</span>
            <a class="comment" href="##comment" title="评论" target="_blank" draggable="false">
                <i class="glyphicon glyphicon-comment"></i> 4</a></p>
        <p class="note">
            <?=$movie['content']?>
        </p>
    </article>
<?php }?>
<style>
    p.note { text-overflow : clip; }
</style>
