<?php

namespace app\modules\orders\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\QueryInterface;
use app\modules\orders\models\Orders;


class UsersSearch extends Users
{
    public $full_name;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'first_name', 'last_name'], 'safe'],
            [['full_name'], 'safe']
        ];
    }
}
