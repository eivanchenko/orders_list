<?php

namespace orders;

/**
 * Class OrdersModule
 * @package orders
 */
class OrdersModule extends \yii\base\Module
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
