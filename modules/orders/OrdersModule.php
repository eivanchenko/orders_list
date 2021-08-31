<?php

namespace app\modules\orders;

/**
 * Class OrdersModule
 * @package app\modules\orders
 */
class OrdersModule extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\orders\controllers';

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        parent::init();

        $this->layout = 'main';
    }
}
