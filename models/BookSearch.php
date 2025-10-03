<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class BookSearch extends Book
{
    public function rules(): array
    {
        return $this->getValidationRules();
    }

    public function getValidationRules(): array
    {
        return [
            [['id', 'year'], 'integer'],
            [['title', 'description', 'isbn'], 'safe'],
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
        $query = Book::find()->with('authors');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'year' => $this->year,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'isbn', $this->isbn]);

        return $dataProvider;
    }
}
