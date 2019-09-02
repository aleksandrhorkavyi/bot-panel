<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%settings}}".
 *
 * @property int $id
 * @property string $bot_token
 * @property string $commands
 * @property string $hello_message
 * @property string $empty_message
 * @property string $trash_message
 * @property string $trash_message_already
 */
class Settings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%settings}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bot_token', 'commands', 'hello_message', 'empty_message', 'trash_message'], 'required'],
            [['bot_token', 'commands', 'hello_message', 'empty_message', 'trash_message', 'trash_message_already'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'bot_token' => Yii::t('app', 'Bot Token'),
            'commands' => Yii::t('app', 'Commands'),
            'hello_message' => Yii::t('app', 'Hello Message'),
            'empty_message' => Yii::t('app', 'Empty Message'),
            'trash_message' => Yii::t('app', 'Trash Message'),
            'trash_message_already' => Yii::t('app', 'Trash Message Already'),
        ];
    }
}
