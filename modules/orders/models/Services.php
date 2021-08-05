<?php

namespace app\modules\orders\models;

use yii\db\ActiveRecord;

class Services extends ActiveRecord
{
    public static function tableName()
    {
        return 'services';
    }

    public function rules()
    {
        return [
            [['id',], 'integer'],
            ['name', 'string', 'max' => 350],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    public static function find()
    {
        return new ServicesQuery(get_called_class());
    }
}
