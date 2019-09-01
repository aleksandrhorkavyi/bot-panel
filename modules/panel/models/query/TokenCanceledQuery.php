<?php

namespace app\modules\panel\models\query;

/**
 * This is the ActiveQuery class for [[\app\modules\panel\models\TokenCanceled]].
 *
 * @see \app\modules\panel\models\TokenCanceled
 */
class TokenCanceledQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\modules\panel\models\TokenCanceled[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\modules\panel\models\TokenCanceled|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
