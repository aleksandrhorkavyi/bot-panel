<?php

namespace app\modules\panel\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%token_canceled}}".
 *
 * @property int $id
 * @property string $value
 * @property string $created_at
 * @property string $updated_at
 */
class TokenCanceled extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%token_canceled}}';
    }

    /**
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => Yii::$app->formatter->asDatetime(time())],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value'], 'required'],
            [['value'], 'unique'],
            [['created_at', 'updated_at'], 'safe'],
            [['value'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'value' => Yii::t('app', 'Value'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\modules\panel\models\query\TokenCanceledQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\panel\models\query\TokenCanceledQuery(get_called_class());
    }
}
