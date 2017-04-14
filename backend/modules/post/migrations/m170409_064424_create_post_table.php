<?php

use yii\db\Migration;

/**
 * Handles the creation of table `post`.
 */
class m170409_064424_create_post_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('post', [
            'id' => $this->primaryKey(),
            'title'=>$this->string()->notNull()->comment("标题"),
            'content'=>$this->text()->comment("内容"),
            'data'=>$this->text()->comment("附加数据"),
            'cateId'=>$this->integer(11)->notNull()->comment("分类id"),
            'created_at'=>$this->integer(11)->comment("发布时间"),
            'updated_at'=>$this->integer(11)->comment("更新时间")
        ],$tableOptions);
        $this->createTable('post_cate', [
            'id' => $this->primaryKey(),
            'name'=>$this->string()->notNull()->comment("分类名称"),
            'pid'=>$this->text()->comment("父类id"),
            'data'=>$this->text()->comment("附加数据"),
            'created_at'=>$this->integer(11)->comment("发布时间"),
            'updated_at'=>$this->integer(11)->comment("更新时间")
        ],$tableOptions);
        $this->addForeignKey("fk_post_cateid","post","cateId","post_cate","id","CASCADE");
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('post');
    }
}
