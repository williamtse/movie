<section class="container">
<?php
use yii\widgets\Breadcrumbs;
?>

<div class="content-wrap">
<div class="content">
  <div class="title">
	<h3 style="line-height: 1.3"><?= Breadcrumbs::widget([
            'links' => $breadcrumbs,
        ]) ?></h3>
  </div>
    <?=$this->render('_list',['movies'=>$movies])?>
  <nav class="pagination" style="display: none;">
	<ul>
	  <li class="prev-page"></li>
	  <li class="active"><span>1</span></li>
	  <li><a href="?page=2">2</a></li>
	  <li class="next-page"><a href="?page=2">下一页</a></li>
	  <li><span>共 2 页</span></li>
	</ul>
  </nav>
</div>
</div>
<aside class="sidebar">
<div class="fixed">
  <div class="widget widget_search">
	<form class="navbar-form" action="/Search" method="post">
	  <div class="input-group">
		<input type="text" name="keyword" class="form-control" size="35" placeholder="请输入关键字" maxlength="15" autocomplete="off">
		<span class="input-group-btn">
		<button class="btn btn-default btn-search" name="search" type="submit">搜索</button>
		</span> </div>
	</form>
  </div>
  <div class="widget widget_sentence">
	<h3>标签云</h3>
	<div class="widget-sentence-content">
		<ul class="plinks ptags">
            <?php if($tags){
                foreach($tags as $tag){
                    ?>
                    <li>
                        <a href="/movie/category/<?=$tag['id']?>" title="移动统计" draggable="false"><?=$tag['name']?>
                            <span class="badge"><?=$tag['total']?></span>
                        </a>
                    </li>
                    <?php
                }
            }?>
		</ul>
	</div>
  </div>
</div>

  <div class="widget widget_sentence">

<a href="#" target="_blank" rel="nofollow" title="MZ-NetBlog主题" draggable="false">
	<img style="width: 100%" src="images/ad.jpg" alt="MZ-NetBlog主题" draggable="false"></a>

</div>
  <div class="widget widget_sentence">

<a href="#" target="_blank" rel="nofollow" title="专业网站建设" draggable="false">
	<img style="width: 100%" src="images/201610241224221511.jpg" alt="专业网站建设" draggable="false"></a>

</div>
</aside>
</section>
