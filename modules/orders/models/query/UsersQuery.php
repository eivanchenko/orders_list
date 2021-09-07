<?php

namespace orders\models\query;

use yii\db\ActiveQuery;

/**
 * Class UsersQuery
 * @see orders\models\Users
 * @package orders\models\
 */
class UsersQuery extends ActiveQuery
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
