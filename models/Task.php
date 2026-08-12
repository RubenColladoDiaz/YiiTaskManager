<?php

namespace app\models;

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
class Task extends \yii\db\ActiveRecord
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
            [['priority'], 'integer'],
            [['category_id'], 'integer'],
            [['due_date', 'created_at', 'updated_at'], 'safe'],
            [['title', 'status'], 'string', 'max' => 255],
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
