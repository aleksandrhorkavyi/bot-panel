<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%token_accepted}}`.
 */
class m190901_110935_create_tokenaccepted_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%token_accepted}}', [
            'id' => $this->primaryKey(),
            'value' => $this->string(255)->notNull(),
            'proto_id' => $this->integer(11)->notNull(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%token_accepted}}');
    }
}
