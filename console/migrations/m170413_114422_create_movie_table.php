<?php

use yii\db\Migration;

/**
 * Handles the creation of table `movie`.
 */
class m170413_114422_create_movie_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        //电影表
        $this->createTable('movie', [
            'id' => $this->primaryKey(),
            'name'=> $this->string()->notNull()->comment("电影名"),
            'year'=>$this->integer(4)->notNull()->comment("年份"),
            'title'=>$this->string()->notNull()->comment("标题"),
            'content'=>$this->text()->comment("简介"),
            'showTime'=>$this->string()->comment("上映时间"),
            'created_at'=>$this->integer(11),
            'updated_at'=>$this->integer(11),
            'keywords'=>$this->string()->comment("关键词")
        ],$tableOptions);
        //电影下载链接表
        $this->createTable('movie_bt',[
            'id'=>$this->primaryKey(),
            'mid'=>$this->integer(11)->comment('电影id'),
            'bt'=>$this->integer(11)->comment('bt下载链接地址'),
            'created_at'=>$this->integer(11)
        ],$tableOptions);
        //导演表
        $this->createTable('director',[
            'id'=>$this->primaryKey(),
            'name'=>$this->string()->comment('导演名'),
            'created_at'=>$this->integer(11)
        ],$tableOptions);
        //演员表
        $this->createTable('actor',[
            'id'=>$this->primaryKey(),
            'name'=>$this->string()->comment('演员名'),
            'created_at'=>$this->integer(11)
        ],$tableOptions);
        //电影类型表
        $this->createTable('category',[
            'id'=>$this->primaryKey(),
            'name'=>$this->string()->comment('类型名'),
            'created_at'=>$this->integer(11)
        ],$tableOptions);
        //电影和导演关系表
        $this->createTable('movie_director',[
            'id'=>$this->primaryKey(),
            'mid'=>$this->integer(11)->comment('电影id'),
            'did'=>$this->integer(11)->comment("导演id"),
            'created_at'=>$this->integer(11)
        ],$tableOptions);
        //电影和演员关系表
        $this->createTable('movie_actor',[
            'id'=>$this->primaryKey(),
            'mid'=>$this->integer(11)->comment('电影id'),
            'aid'=>$this->integer(11)->comment("演员id"),
            'created_at'=>$this->integer(11)
        ],$tableOptions);
        //电影和类型关系表
        $this->createTable('movie_category',[
            'id'=>$this->primaryKey(),
            'mid'=>$this->integer(11)->comment('电影id'),
            'cid'=>$this->integer(11)->comment("类型id"),
            'created_at'=>$this->integer(11)
        ],$tableOptions);

        $this->addForeignKey("fk_movie_category","movie_category","mid","movie","id","CASCADE");
        $this->addForeignKey("fk_movie_director","movie_director","mid","movie","id","CASCADE");
        $this->addForeignKey("fk_movie_actor","movie_actor","mid","movie","id","CASCADE");
        $this->addForeignKey("fk_movie_bt","movie_bt","mid","movie","id","CASCADE");
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('movie');
    }
}
