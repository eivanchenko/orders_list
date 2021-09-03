<?php

namespace orders\widgets;

use orders\components\OrdersHelpers;
use orders\models\search\OrdersSearch;
use Yii;
use yii\base\Widget;
use yii\bootstrap\Dropdown;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * Class ServiceDropDown
 * @package orders\widgets
 */
class ServiceDropDown extends Widget
{

    public $dropDown;
    public $dropDownLabel;

    /**
     * {@inheritDoc}
     * @throws \Exception
     */
    public function init()
    {
        parent::init();
        $this->dropDownLabel = Yii::t('app', 'label.service');
        $this->dropDown = Dropdown::widget([
            'encodeLabels' => false,
            'items' =>
            ArrayHelper::map(OrdersSearch::getServicesTypesCount(), 'id',  function ($model) {
                if ($model['name'] == 'all') {
                    return [
                        'label' => Yii::t('app', 'label.all') . ' (' . $model['count'] .  ')',
                        'url' => Url::current(['serviceType' => 'all']),
                        'options' => ['class' => OrdersHelpers::getActiveClass('serviceType', 'all')]
                    ];
                }
                return [
                    'label' => '<span class="label-id">' . $model['id'] . '</span> ' . Yii::t('app', $model['name']) . ' (' . ($model['count'] ?: "0")  . ')',
                    'url' => Url::current(['serviceType' => $model['id']]),
                    'options' => ['class' => OrdersHelpers::getActiveClass('serviceType',  $model['id'])]
                ];
            }),
            'submenuOptions' => [
                'aria-labelledby' => 'dropdownMenu1'
            ]
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function run(): string
    {
        return $this->render('serviceDDView', ['dropDown' => $this->dropDown, 'dropDownLabel' => $this->dropDownLabel]);
    }
}
