<?php

namespace app\models;

use yii\data\ActiveDataProvider;

class TaskSearch extends Task
{
    // public $categoryName;

    public function rules()
    {
        return [
            // Un validador de tipo string u otro ya hace que esos atributos sean safe automáticamente
            [['title', 'status'], 'safe'],
            [['priority', 'category_id'], 'integer'],
            [['categoryName'], 'safe']
        ];
    }

    public function search($params)
    {
        $query = Task::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->joinWith('category');

        // $query->andFilterWhere([
        //     'like',
        //     'categories.name',
        //     $this->categoryName
        // ]);

        $query->andFilterWhere([
            'status' => $this->status,
            'priority' => $this->priority,
            'category_id' => $this->category_id,
        ]);

        // Lo separamos porque sino pillaria que title = 'title'
        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}