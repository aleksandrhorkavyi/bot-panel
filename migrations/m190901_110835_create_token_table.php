<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%token}}`.
 */
class m190901_110835_create_token_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%token_active}}', [
            'id' => $this->primaryKey(),
            'value' => $this->string(255)->notNull()->unique(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime()
        ]);

        $this->createTable('{{%token_canceled}}', [
            'id' => $this->primaryKey(),
            'value' => $this->string(255)->notNull()->unique(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%token_active}}');
        $this->dropTable('{{%token_canceled}}');
    }
}
