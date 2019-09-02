<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%settings}}`.
 */
class m190902_164152_add_pass_column_to_settings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%settings}}', 'password', $this->string()->notNull());
        $this->addColumn('{{%settings}}', 'username', $this->string()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%settings}}', 'password');
        $this->dropColumn('{{%settings}}', 'username');
    }
}
