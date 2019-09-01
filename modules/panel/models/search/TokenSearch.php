<?php

namespace app\modules\panel\models\search;

use app\modules\panel\models\TokenCanceled;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\panel\models\TokenActive;
use yii\db\Query;

/**
 * TokenSearch represents the model behind the search form of `app\modules\panel\models\TokenActive`.
 */
class TokenSearch extends TokenActive
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['value', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @param Query $query
     * @return ActiveDataProvider
     */
    private function getActiveDataProvider(Query $query, $params)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 100],
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
        $query->andFilterWhere(['like', 'value', $this->value]);

        return $dataProvider;
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function searchActive($params)
    {
        return $this->getActiveDataProvider(TokenActive::find(), $params);
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function searchCanceled($params)
    {
        return $this->getActiveDataProvider(TokenCanceled::find(), $params);
    }
}
