<?php

namespace app\modules\orders;


class OrdersModule extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\orders\controllers';


    public function init()
    {
        parent::init();


        // $this->layout = 'main';
    }
}