<?php

use yii\db\Migration;

/**
 * Class m210423_094725_create_book3
 */
class m210423_094725_create_book3 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('book3', [
            'id' => $this->primaryKey(),
            'title' => $this->string(500)->notNull()->defaultValue(''),
            'content' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210423_094725_create_book3 cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210423_094725_create_book3 cannot be reverted.\n";

        return false;
    }
    */
}
