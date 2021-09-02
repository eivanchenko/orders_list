<?php

namespace app\modules\orders\models\query;

use yii\db\ActiveQuery;

/**
 * Class ServicesQuery
 * @see app\modules\orders\models\Services
 * @package app\modules\orders\models
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
