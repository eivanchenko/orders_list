<?php

namespace orders\models\query;

use yii\db\ActiveQuery;

/**
 * Class ServicesQuery
 * @see orders\models\Services
 * @package orders\models
 */
class ServicesQuery extends ActiveQuery
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
