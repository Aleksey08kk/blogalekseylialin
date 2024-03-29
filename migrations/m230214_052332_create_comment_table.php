<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comment}}`.
 */
class m230214_052332_create_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%comment}}', [
            'id' => $this->primaryKey(),
            'text'=>$this->string(),
            'user_id'=>$this->integer(),
            'article_id'=>$this->integer(),
            'status'=>$this->integer()
        ]);

//далее код для удаления комментариев и всего того что описано ниже при удалении пользователя или тега.
        // creates index for column `user_id`
        $this->createIndex(
            'idx-post-user_id',
            'comment',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-post-user_id',
            'comment',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // creates index for column `article_id`
        $this->createIndex(
            'idx-article_id',
            'comment',
            'article_id'
        );

        // add foreign key for table `article`
        $this->addForeignKey(
            'fk-article_id',
            'comment',
            'article_id',
            'article',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-article_id', 'comment');
        $this->dropForeignKey('fk-post-user_id', 'comment');

        $this->dropTable('{{%comment}}');
        $this->dropColumn('comment','date');
    }
}
