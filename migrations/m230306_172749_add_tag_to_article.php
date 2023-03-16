<?php

use yii\db\Migration;

/**
 * Class m230306_172749_add_tag_to_article
 */
class m230306_172749_add_tag_to_article extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
$this->addColumn('article', 'tag', $this->tag());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        //$this->dropColumn('article', 'tag');
        echo "m230306_172749_add_tag_to_article cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230306_172749_add_tag_to_article cannot be reverted.\n";

        return false;
    }
    */
}
