<?php

namespace orders\models\search;

use yii\base\Model;
use orders\models\Services;

/**
 * Class ServicesSearch
 * @package orders\models
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
