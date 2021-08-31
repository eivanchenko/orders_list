<?php

namespace app\modules\orders\models;

use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string  $first_name
 * @property string  $last_name
 */


/**
 * Class Users
 * @package app\modules\orders\models
 */
class Users extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name'], 'string', 'max' => 350],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
        ];
    }

    /**
     * @return UsersQuery
     */
    public static function find()
    {
        return new UsersQuery(get_called_class());
    }
}
