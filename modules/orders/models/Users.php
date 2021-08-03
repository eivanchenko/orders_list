<?php

namespace app\modules\orders\models;

use yii\db\ActiveRecord;

class Users extends ActiveRecord
{
    public static function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        return [
            [['first_name', 'last_name'], 'string', 'max' => 350],
        ];
    }

    
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
        ];
    }

    public static function find()
    {
        return new UsersQuery(get_called_class());
    }
}
