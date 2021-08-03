<?php

namespace app\modules\orders\models;

use yii\db\ActiveQuery;

class OrdersQuery extends ActiveQuery
{


    public function all($db = null)
    {
        return parent::all($db);
    }

    public function one($db = null)
    {

        return parent::one($db);
    }
}
