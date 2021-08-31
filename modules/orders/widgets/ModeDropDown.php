<?php

namespace app\modules\orders\widgets;

use Yii;
use yii\base\Widget;
use yii\bootstrap\Dropdown;
use yii\helpers\Url;
use app\modules\orders\models\Orders;

/**
 * Class ModeDropDown
 * @package app\modules\orders\widgets
 */
class ModeDropDown extends Widget
{

    public $dropDown;
    public $dropDownLabel;

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        parent::init();
        $this->dropDownLabel = Yii::t('app', 'label.mode');
        $this->dropDown = Dropdown::widget([
            'items' =>
            [
                [
                    'label' => Yii::t('app', 'label.all'), 'url' => Url::current(['mode' => 'all']),
                    'options' => ['class' => Orders::getActiveClass('mode', 'all')]
                ],
                [
                    'label' => Yii::t('app', 'mode.manual'), 'url' => Url::current(['mode' => '0']),
                    'options' => ['class' => Orders::getActiveClass('mode', 0)]
                ],
                [
                    'label' => Yii::t('app', 'mode.auto'), 'url' => Url::current(['mode' => '1']),
                    'options' => ['class' => Orders::getActiveClass('mode', 1)]
                ]
            ],

            'submenuOptions' => [
                'aria-labelledby' => 'dropdownMenu1'
            ]
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function run()
    {
        return $this->render('modeDDView', ['dropDown' => $this->dropDown, 'dropDownLabel' => $this->dropDownLabel]);
    }
}
