<?php

namespace app\modules\orders\models;

use yii\base\Model;
use app\modules\orders\models\Services;

/**
 * Class ServicesSearch
 * @package app\modules\orders\models
 */
class ServicesSearch extends Services
{

    public $service_count;

    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'count'], 'integer'],
            [['name'], 'string'],
            [['id', 'name', 'count', 'service_count'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        return Model::scenarios();
    }
}
