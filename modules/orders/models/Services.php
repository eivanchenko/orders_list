<?php

namespace app\modules\orders\models;

use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string  $name
 */

/**
 * Class Services
 * @package app\modules\orders\models
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

    /**
     * @return ServicesQuery
     */
    public static function find(): ServicesQuery
    {
        return new ServicesQuery(get_called_class());
    }
}
