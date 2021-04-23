<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%book3}}`.
 */
class m210423_113121_add_position_column_memo_column_to_book3_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%book3}}', 'position', $this->integer());
        $this->addColumn('{{%book3}}', 'memo', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%book3}}', 'position');
        $this->dropColumn('{{%book3}}', 'memo');
    }
}
