<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%settings}}`.
 */
class m190902_121027_create_settings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%settings}}', [
            'id' => $this->primaryKey(),

            'bot_token' => $this->string(255)->notNull(),
            'commands' => $this->string(255)->notNull(),

            'hello_message' => $this->string(255)->notNull(),
            'empty_message' => $this->string(255)->notNull(),
            'trash_message' => $this->string(255)->notNull(),
            'trash_message_already' => $this->string(255)->notNull(),
        ]);

        $this->insert('{{%settings}}', [
            'bot_token' => '891364201:AAEhZu9km71gRW6q1nrJpUgF_qQ7YiCNROg',
            'commands' => 'мат,не раб',
            'hello_message' => 'Hello!',
            'empty_message' => 'empty',
            'trash_message' => 'trashed',
            'trash_message_already' => 'already trashed',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%settings}}');
    }
}
