<?php

namespace app\modules\orders\models\query;

use yii\db\ActiveQuery;

/**
 * Class OrdersQuery
 * @see app\modules\orders\models\Orders
 * @package app\modules\orders\models\orders
 */
class OrdersQuery extends ActiveQuery
{

    /**
     * @param null $db
     * @return array|\yii\db\ActiveRecord[]
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @param null $db
     * @return array|\yii\db\ActiveRecord|null
     */
    public function one($db = null)
    {

        return parent::one($db);
    }
}
