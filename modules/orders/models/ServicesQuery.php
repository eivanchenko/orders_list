<?php

namespace app\modules\orders\models;

use yii\db\ActiveQuery;

/**
 * Class ServicesQuery
 * @see app\modules\orders\models\Services
 * @package app\modules\orders\models
 */
class ServicesQuery extends ActiveQuery
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
