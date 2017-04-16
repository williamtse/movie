<?php
/**
 * Created by PhpStorm.
 * User: Xie
 * Date: 2017/4/13
 * Time: 23:27
 */
$this->title=$movie->title.'|'.$movie->keywords;
?>

<section class="container">
    <div class="content-wrap">
        <div class="content">
            <header class="article-header">
                <h1 class="article-title">
                    <a href="#" title="<?=$movie->title?>" ><?=$movie->title?></a></h1>
                <div class="article-meta"> <span class="item article-meta-time">
	  <time class="time" data-toggle="tooltip" data-placement="bottom" title=""
            data-original-title="发表时间：<?=date('Y-m-d',$movie['created_at'])?>">
          <i class="glyphicon glyphicon-time"></i> <?=date('Y-m-d',$movie['created_at'])?></time>
	  </span>
                    <span class="item article-meta-source"
                          data-toggle="tooltip" data-placement="bottom"
                          title="" data-original-title="">
                        <i class="glyphicon glyphicon-globe"></i> 木庄网络博客</span>
                    <span class="item article-meta-category" data-toggle="tooltip"
                          data-placement="bottom" title=""
                          data-original-title="MZ-NetBlog主题">
                        <i class="glyphicon glyphicon-list"></i>
                        <a href="#" title="MZ-NetBlog主题" >MZ-NetBlog主题</a>
                    </span> <span class="item article-meta-views" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="浏览量：219"><i class="glyphicon glyphicon-eye-open"></i> 219</span> <span class="item article-meta-comment" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="评论量"><i class="glyphicon glyphicon-comment"></i> 4</span> </div>
            </header>
            <article class="article-content">
		<?php if(isset($directors)){ ?>
                <p>@导演：
                <?php 
                    foreach($directors as $d){
                        ?>
                        <a href="/movie/director/<?=$d['did']?>"><?=$d['name']?></a>
                        <?php
                    }
                ?>
                    <p>
		<?php } ?>
		<?php if(isset($actors)){ ?>
                <p>@演员：<?php 
                    foreach($actors as $a){
                        ?>
                        <a href="/movie/actor/<?=$a['aid']?>"><?=$a['name']?></a>
                        <?php
                    }
                ?><p>
		<?php } ?>
                <p><img src="<?=Douban_GetPoster($movie['poster'],'l')?>"></p>
                <?=$movie['content']?>
            </article>
            <div class="article-tags">标签：
                <?php
		    if(isset($categories)){
                    foreach($categories as $c){
                        ?>
                        <a href="/movie/category/<?=$c['cid']?>" rel="tag" ><?=$c['name']?></a>
                        <?php
                    }
			}
                ?>
            </div>
            <style>
                .Button:hover {
                    background-color: rgba(207,216,230,.1);
                }
                button {
                    padding: 0;
                    font: inherit;
                    color: inherit;
                    cursor: pointer;
                    background: none;
                    border: none;
                    outline: none;
                    -webkit-appearance: none;
                    -moz-appearance: none;
                    appearance: none;
                }
                input, textarea, select, button {
                    text-rendering: auto;
                    color: initial;
                    letter-spacing: normal;
                    word-spacing: normal;
                    text-transform: none;
                    text-indent: 0px;
                    text-shadow: none;
                    display: inline-block;
                    text-align: start;
                    margin: 0em 0em 0em 0em;
                    font: 13.3333px Arial;
                }
                input, textarea, select, button, meter, progress {
                    -webkit-writing-mode: horizontal-tb;
                }
                button {
                    -webkit-appearance: button;
                }
                .VoteButton{
                    background-color: #e4ebf3;
                    border-color: #e4ebf3;
                }
                li.bt-item{
                    background: white;
                    padding: 10px;
                    list-style: none;
                    position: relative;
                    border: 1px dotted #9ccff4;
                    margin: 5px 0;
                }
                .vote-btns{
                    position: absolute;
                    top: 20px;
                    right: 10px;
                }
                .VoteButton:not(:disabled):hover {
                     background-color: #e4ebf3;
                     border-color: #e4ebf3;
                 }
                .VoteButton {
                    padding: 0 10px;
                    color: #2d84cc;
                    background: #ebf3fb;
                    border-color: #ebf3fb;
                }
                .VoteButton--down {
                }
                .VoteButton-downIcon, .VoteButton-upIcon {
                    fill: currentColor;
                }
                .VoteButton-downIcon {
                    -webkit-transform: rotate(180deg);
                    /* transform: rotate(180deg); */
                }
            </style>
            <div class="relates" style="margin-bottom: 20px">
                <div class="title"><h3>分享下载</h3></div>
                <?php
                if($urls){
                    echo '<ul>';
                    foreach($urls as $url){
                        ?>
                        <li class="bt-item" style="">
                            <span style="color:brown">
                                <img class="img-circle" style="height: 1.5em;"
                                     src="https://www.gravatar.com/avatar/<?=md5($url['email'])?>">
                                <a href="/user/<?=$url['uid']?>"><?=$url['username']?></a>
                            </span>
                            <span class="post-time"><?=date('Y-m-d',$url['created_at'])?> 发布</span>
                            <br>
                            <a href="thunder://<?=base64_encode('AA'.$url['bt'].'ZZ')?>">
                                <?=$url['title']?></a>
                            <span class="badge"><?=$url['fmt']?></span>
                            <span class="vote-btns">
                            <button data-typef="1" data-dtid="<?=$url['id']?>" class="Button VoteButton VoteButton--up" aria-label="好"
                                    type="button"><svg viewBox="0 0 20 18"
                                                       class="Icon VoteButton-upIcon Icon--triangle"
                                                       width="9" height="16" aria-hidden="true"
                                                       style="height: 16px; width: 9px;">
                                    <g><path
                                                d="M0 15.243c0-.326.088-.533.236-.896l7.98-13.204C8.57.57 9.086 0 10 0s1.43.57 1.784 1.143l7.98 13.204c.15.363.236.57.236.896 0 1.386-.875 1.9-1.955 1.9H1.955c-1.08 0-1.955-.517-1.955-1.9z"></path>
                                    </g></svg>
                                <!-- react-text: 162 -->
                                    <i id="votes-<?=$url['id']?>-up" class="votes"></i>
                                <!-- /react-text -->
                            </button>
                            <button data-typef="-1" data-dtid="<?=$url['id']?>" class="Button VoteButton VoteButton--down" aria-label="反对"
                                    type="button"><svg viewBox="0 0 20 18"
                                                       class="Icon VoteButton-downIcon Icon--triangle"
                                                       width="9" height="16" aria-hidden="true"
                                                       style="height: 16px; width: 9px;">
                                    <g><path d="M0 15.243c0-.326.088-.533.236-.896l7.98-13.204C8.57.57 9.086 0 10 0s1.43.57 1.784 1.143l7.98 13.204c.15.363.236.57.236.896 0 1.386-.875 1.9-1.955 1.9H1.955c-1.08 0-1.955-.517-1.955-1.9z"></path></g>
                                </svg>
                                <!-- react-text: 162 -->
                                    <i id="votes-<?=$url['id']?>-down" class="votes"></i>
                                <!-- /react-text -->
                            </button>
                            </span>
                        </li>
                        <?php
                    }
                    echo '</ul>';
                }else{
                    ?>
                    <p style="padding:10px;text-align:center" class="bg-info">暂无下载资源，
                        <a href="/bt/create?id=<?=$movie->id?>">提供下载链接</a></p>
                <?php
                }
                ?>
            </div>
            <div class="relates">
                <div class="title">
                    <h3>相关推荐</h3>
                </div>
                <ul>
                    <li><a href="#" title="" >用DTcms做一个独立博客网站（响应式模板）-MZ-NetBlog主题</a></li>
                    <li><a href="#" title="" >用DTcms做一个独立博客网站（响应式模板）-MZ-NetBlog主题</a></li>
                    <li><a href="#" title="" >用DTcms做一个独立博客网站（响应式模板）-MZ-NetBlog主题</a></li>
                    <li><a href="#" title="" >用DTcms做一个独立博客网站（响应式模板）-MZ-NetBlog主题</a></li>
                    <li><a href="#" title="" >用DTcms做一个独立博客网站（响应式模板）-MZ-NetBlog主题</a></li>
                    <li><a href="#" title="" >用DTcms做一个独立博客网站（响应式模板）-MZ-NetBlog主题</a></li>
                    <li><a href="#" title="" >用DTcms做一个独立博客网站（响应式模板）-MZ-NetBlog主题</a></li>
                    <li><a href="#" title="" >用DTcms做一个独立博客网站（响应式模板）-MZ-NetBlog主题</a></li>
                </ul>
            </div>
            <div class="title" id="comment">
                <h3>评论</h3>
            </div>
            <div id="respond">
                <form id="comment-form" name="comment-form" action="" method="POST">
                    <div class="comment">
                        <input name="" id="" class="form-control" size="22" placeholder="您的昵称（必填）" maxlength="15" autocomplete="off" tabindex="1" type="text">
                        <input name="" id="" class="form-control" size="22" placeholder="您的网址或邮箱（非必填）" maxlength="58" autocomplete="off" tabindex="2" type="text">
                        <div class="comment-box">
                            <textarea placeholder="您的评论或留言（必填）" name="comment-textarea" id="comment-textarea" cols="100%" rows="3" tabindex="3"></textarea>
                            <div class="comment-ctrl">
                                <div class="comment-prompt" style="display: none;"> <i class="fa fa-spin fa-circle-o-notch"></i> <span class="comment-prompt-text">评论正在提交中...请稍后</span> </div>
                                <div class="comment-success" style="display: none;"> <i class="fa fa-check"></i> <span class="comment-prompt-text">评论提交成功...</span> </div>
                                <button type="submit" name="comment-submit" id="comment-submit" tabindex="4">评论</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
            <div id="postcomments">
                <ol id="comment_list" class="commentlist">
                    <li class="comment-content"><span class="comment-f">#2</span><div class="comment-main"><p><a class="address" href="#" rel="nofollow" target="_blank">木庄网络博客</a><span class="time">(2016/10/28 11:41:03)</span><br>不错的网站主题，看着相当舒服</p></div></li>
                    <li class="comment-content"><span class="comment-f">#1</span><div class="comment-main"><p><a class="address" href="#" rel="nofollow" target="_blank">木庄网络博客</a><span class="time">(2016/10/14 21:02:39)</span><br>博客做得好漂亮哦！</p></div></li></ol>
            </div>
        </div>
    </div>
    <aside class="sidebar">
        <div class="fixed">
            <div class="widget widget-tabs">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#notice" aria-controls="notice" role="tab" data-toggle="tab" draggable="false">统计信息</a></li>
                    <li role="presentation"><a href="#contact" aria-controls="contact" role="tab" data-toggle="tab" draggable="false">联系站长</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane contact active" id="notice">
                        <h2>日志总数:
                            888篇
                        </h2>
                        <h2>网站运行:
                            <span id="sitetime">88天 </span></h2>
                    </div>
                    <div role="tabpanel" class="tab-pane contact" id="contact">
                        <h2>QQ:
                            <a href="" target="_blank" rel="nofollow" data-toggle="tooltip" data-placement="bottom" title="" draggable="false" data-original-title="QQ:577211782">577211782</a>
                        </h2>
                        <h2>Email:
                            <a href="mailto:577211782@qq.com" target="_blank" data-toggle="tooltip" rel="nofollow" data-placement="bottom" title="" draggable="false" data-original-title="Email:577211782@qq.com">577211782@qq.com</a></h2>
                    </div>
                </div>
            </div>
            <div class="widget widget_search">
                <form class="navbar-form" action="/Search" method="post">
                    <div class="input-group">
                        <input type="text" name="keyword" class="form-control" size="35" placeholder="请输入关键字" maxlength="15" autocomplete="off">
                        <span class="input-group-btn">
		<button class="btn btn-default btn-search" name="search" type="submit">搜索</button>
		</span> </div>
                </form>
            </div>
        </div>
        <?=$this->render('../inc/_comment')?>
        <div class="widget widget_sentence">

            <a href="#" target="_blank" rel="nofollow" title="MZ-NetBlog主题" >
                <img style="width: 100%" src="images/ad.jpg" alt="MZ-NetBlog主题" ></a>

        </div>
        <div class="widget widget_sentence">

            <a href="#" target="_blank" rel="nofollow" title="专业网站建设" >
                <img style="width: 100%" src="images/201610241224221511.jpg" alt="专业网站建设" ></a>

        </div>
    </aside>
</section>
<script>
    $(function(){
        $(".VoteButton").click(function(){
            var tdid = $(this).attr('data-dtid');
            var type = $(this).data('typef');
            $.ajax({
                url:"/bt/vote",
                data:{
                    tdid:tdid,
                    type:type,
                    '<?=Yii::$app->request->csrfParam?>':'<?=Yii::$app->request->csrfToken?>'
                },
                type:'post',
                dataType:'json',
                success:function(re){
                    if(re.status==1){
                        $("#votes-"+tdid+"-"+(type>0?'up':'down')).html(re.votes);
                    }else if(re.status==2){
                        location.href='/site/login';
                    }
                }
            });
        })
    })
</script>
