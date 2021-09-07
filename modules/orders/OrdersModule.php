<?php

namespace orders;

use yii\base\Module;

/**
 * Class OrdersModule
 * @package orders
 */
class OrdersModule extends Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'orders\controllers';

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        parent::init();

        $this->layout = 'main';
    }
}
