<?php

namespace orders\models\query;

use yii\db\ActiveQuery;

/**
 * Class OrdersQuery
 * @see orders\models\Orders
 * @package orders\models\orders
 */
class OrdersQuery extends ActiveQuery
{

    /**
     * {@inheritDoc}
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * {@inheritDoc}
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
