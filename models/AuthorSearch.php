<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class AuthorSearch extends Author
{
    public function rules(): array
    {
        return $this->getValidationRules();
    }

    public function getValidationRules(): array
    {
        return [
            [['id'], 'integer'],
            [['first_name', 'last_name', 'middle_name'], 'safe'],
        ];
    }

    public function scenarios(): array
    {
        return $this->getScenarios();
    }

    public function getScenarios(): array
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Author::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'middle_name', $this->middle_name]);

        return $dataProvider;
    }
}
