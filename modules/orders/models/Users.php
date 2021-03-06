<?php

namespace orders\models;

use orders\models\query\UsersQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table 'orders'
 * @package orders\models
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 */
class Users extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'users';
    }

    /**
     * @return UsersQuery
     */
    public static function find(): UsersQuery
    {
        return new UsersQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['first_name', 'last_name'], 'string', 'max' => 350],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
        ];
    }
}
