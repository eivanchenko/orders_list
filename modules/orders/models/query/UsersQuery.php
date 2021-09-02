<?php

namespace app\modules\orders\models\query;

use yii\db\ActiveQuery;

/**
 * Class UsersQuery
 * @see app\modules\orders\models\Users
 * @package app\modules\orders\models\
 */
class UsersQuery extends ActiveQuery
{

    /**
     * {@inheritDoc}
     */
    public function all($db = null)
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
