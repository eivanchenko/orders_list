<?php

namespace orders\models;

use orders\models\query\ServicesQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table 'services'
 * @package orders\models
 * @property integer $id
 * @property string $name
 */
class Services extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'services';
    }

    /**
     * @return ServicesQuery
     */
    public static function find(): ServicesQuery
    {
        return new ServicesQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id',], 'integer'],
            ['name', 'string', 'max' => 350],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }
}
