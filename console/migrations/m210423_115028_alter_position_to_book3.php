<?php

use yii\db\Migration;

/**
 * Class m210423_115028_alter_position_to_book3
 */
class m210423_115028_alter_position_to_book3 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('book3', 'position', 'string(500)');//坑爹，多次执行成功，工具没展示
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        /*echo "m210423_115028_alter_position_to_book3 cannot be reverted.\n";

        return false;*/
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210423_115028_alter_position_to_book3 cannot be reverted.\n";

        return false;
    }
    */
}
