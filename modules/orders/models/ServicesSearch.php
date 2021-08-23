<?php

namespace app\modules\orders\models;

use Yii;
use yii\base\Model;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use app\modules\orders\models\Services;

class ServicesSearch extends Services
{

    public $service_count;


    public function rules()
    {
        return [
            [['id', 'count'], 'integer'],
            [['name'], 'string'],
            [['id', 'name', 'count', 'service_count'], 'safe']
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }
}
