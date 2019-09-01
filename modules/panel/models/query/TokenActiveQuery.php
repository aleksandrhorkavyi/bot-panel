<?php

namespace app\modules\panel\models\query;

/**
 * This is the ActiveQuery class for [[\app\modules\panel\models\TokenActive]].
 *
 * @see \app\modules\panel\models\TokenActive
 */
class TokenActiveQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\modules\panel\models\TokenActive[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\modules\panel\models\TokenActive|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
