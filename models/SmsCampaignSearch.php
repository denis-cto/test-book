<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class SmsCampaignSearch extends SmsCampaign
{
    public function rules(): array
    {
        return [
            [['id', 'book_id', 'author_id', 'total_recipients', 'sent_successfully', 'sent_failed'], 'integer'],
            [['message', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    public function scenarios(): array
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = SmsCampaign::find()->with(['book', 'author']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_DESC],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'book_id' => $this->book_id,
            'author_id' => $this->author_id,
            'total_recipients' => $this->total_recipients,
            'sent_successfully' => $this->sent_successfully,
            'sent_failed' => $this->sent_failed,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'message', $this->message]);

        return $dataProvider;
    }
}
