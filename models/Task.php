<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string $status
 * @property int $priority
 * @property string|null $due_date
 * @property string $created_at
 * @property string $updated_at
 */
class Task extends ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'due_date'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 'pending'],
            [['priority'], 'default', 'value' => 0],
            [['title'], 'required'],
            [['description'], 'string'],
            [['priority'], 'integer', 'min' => 0],
            [['category_id'], 'integer'],
            [['due_date', 'created_at', 'updated_at'], 'safe'],
            [['title', 'status'], 'string', 'max' => 255],
            [['status'], 'in', 'range' => ['pending', 'in_progress', 'completed']],
            [['category_id'], 'exist', 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [
                ['due_date'],
                'required',
                'when' => function ($model) {
                    return $model->status !== 'completed' && empty($model->due_date);
                },
                'whenClient' => "function (attribute, value) {
                    return $('#task-status').val() !== 'completed';
                }"
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'status' => 'Status',
            'priority' => 'Priority',
            'category_id' => 'Category',
            'due_date' => 'Due Date',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    // Gracias a esto podemos hacer $task->category->name
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }
}
