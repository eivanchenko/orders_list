<?php

namespace app\modules\orders\models;

use yii\db\ActiveRecord;

class Services extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'services';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id',], 'integer'],
            ['name', 'string', 'max' => 350],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return ServicesQuery
     */
    public static function find()
    {
        return new ServicesQuery(get_called_class());
    }
}
