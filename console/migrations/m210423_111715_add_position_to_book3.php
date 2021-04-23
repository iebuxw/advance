<?php

use yii\db\Migration;

/**
 * Class m210423_111715_add_position_to_book3
 */
class m210423_111715_add_position_to_book3 extends Migration
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
        echo "m210423_111715_add_position_to_book3 cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210423_111715_add_position_to_book3 cannot be reverted.\n";

        return false;
    }
    */
}
