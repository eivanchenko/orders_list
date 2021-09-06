<?php

namespace orders\models\search;

use orders\models\Services;
use yii\base\Model;

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
