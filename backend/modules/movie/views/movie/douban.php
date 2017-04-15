<h1>从豆瓣API创建电影</h1>
<form action="fetch-from-douban" method="post">
    <div class="form-group">
        <label>豆瓣电影id</label>
        <input class="form-control" type="text" name="doubanId" value="">
    </div>
    <input type="hidden" name="<?=Yii::$app->request->csrfParam?>"
           value="<?=Yii::$app->request->csrfToken?>">
    <button>获取</button>
</form>