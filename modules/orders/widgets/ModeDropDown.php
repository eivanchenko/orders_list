<?php

namespace app\modules\orders\widgets;

use Yii;
use yii\base\Widget;
use yii\bootstrap\Dropdown;
use yii\helpers\Url;
use app\modules\orders\models\Orders;


class ModeDropDown extends Widget
{

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return '<div class="dropdown">
        <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        ' . Yii::t('app',  'label.mode') . '
          <span class="caret"></span>
        </button>' . Dropdown::widget([
            'items' =>
            [['label' => Yii::t('app', 'label.all'), 'url' => Url::current(['OrdersSearch[mode]' => '']), 'options' => ['class' => Orders::getActiveClass('mode', 'all')]], ['label' => Yii::t('app', 'mode.manual'), 'url' => Url::current(['OrdersSearch[mode]' => '0']), 'options' => ['class' => Orders::getActiveClass('mode', 0)]], ['label' => Yii::t('app', 'mode.auto'), 'url' => Url::current(['OrdersSearch[mode]' => '1']), 'options' => ['class' => Orders::getActiveClass('mode', 1)]]],
            'submenuOptions' => [
                'aria-labelledby' => 'dropdownMenu1'
            ]
        ]) . '</div></div>';
    }
}
