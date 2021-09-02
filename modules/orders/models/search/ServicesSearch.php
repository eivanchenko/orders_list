<?php

namespace app\modules\orders\models\search;

use yii\base\Model;
use app\modules\orders\models\Services;

/**
 * Class ServicesSearch
 * @package app\modules\orders\models
 */
class ServicesSearch extends Services
{
    public $service_count;


    /**
     * {@inheritdoc}
     */
    public function scenarios(): array
    {
        return Model::scenarios();
    }
}
