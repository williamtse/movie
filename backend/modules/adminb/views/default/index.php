<h1>Profile(个人资料)</h1>
<form action="<?=\yii\helpers\Url::toRoute(['/adminb/default/updateprofile'])?>" method="post">
    <input type="hidden" name="<?=\Yii::$app->request->csrfParam?>"
    value="<?=\Yii::$app->request->csrfToken?>">
    <div class="form-group">
        <label  for="avatar">头像</label><br>
        <img src="https://www.gravatar.com/avatar/<?=md5(\Yii::$app->user->identity->email)?>"
             alt="avatar头像" class="img-round profile_img">
        <br>
        <blockquote>
            <p><a href="http://cn.gravatar.com" target="_blank">Gravatar - 全球公认的头像</a></p>
        </blockquote>
    </div>
    <div class="form-group">
        <label for="email">邮箱</label>
        <input class="form-control" type="text" name="email"
               value="<?=\Yii::$app->user->identity->email?>">
    </div>
    <div class="form-group">
        <label for="nick_name">昵称</label>
        <input class="form-control" type="text" name="nick_name" value="<?=$profile?$profile->nick_name:""?>">
    </div>
    <div class="form-group">
        <button class="btn btn-dark">更新</button>
    </div>
</form>

