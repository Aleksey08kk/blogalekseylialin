<?php

use yii\db\Migration;

/**
 * Class m230227_074935_add_date_to_comment
 */
class m230227_074935_add_date_to_comment extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230227_074935_add_date_to_comment cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230227_074935_add_date_to_comment cannot be reverted.\n";

        return false;
    }
    */
}
