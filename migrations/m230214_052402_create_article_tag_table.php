<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%article_tag}}`.
 */
class m230214_052402_create_article_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%article_tag}}', [
            'id' => $this->primaryKey(),
            'article_id'=>$this->integer(),
            'tag_id'=>$this->integer()
        ]);

//далее код для удаления комментариев и всего того что описано ниже при удалении пользователя или тега.
        // creates index for column `user_id`
        $this->createIndex(
            'tag_article_article_id',
            'article_tag',
            'article_id'
        );


        // add foreign key for table `user`
        $this->addForeignKey(
            'tag_article_article_id',
            'article_tag',
            'article_id',
            'article',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            'idx_tag_id',
            'article_tag',
            'tag_id'
        );


        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-tag_id',
            'article_tag',
            'tag_id',
            'tag',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-tag_id', 'article_tag');
        $this->dropForeignKey('tag_article_article_id', 'article_tag');

        $this->dropTable('{{%article_tag}}');
    }
}
