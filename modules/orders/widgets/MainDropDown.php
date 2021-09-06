<?php

namespace orders\widgets;

use orders\components\OrdersHelpers;
use Yii;
use yii\bootstrap\Dropdown;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * Class MainDropDown
 * @package orders\widgets
 */
class MainDropDown extends \yii\base\Widget
{
    public $typeDD;
    public $dropDown;
    public $dropDownLabel;
    public $data;
    public $labelOfAll;

    /**
     * {@inheritDoc}
     * @throws \Exception
     */
    public function init()
    {
        parent::init();
        $this->labelOfAll = Yii::t('app', 'label.all');
        $this->dropDownLabel = Yii::t('app', $this->dropDownLabel);

        if ($this->typeDD === 'mode') {
            $this->data = ArrayHelper::merge(
                [
                    ['id' => 'all', 'name' => 'all'],
                ],

                $this->data
            );
        }
        $this->dropDown = Dropdown::widget([
            'encodeLabels' => false,
            'items' => ArrayHelper::map($this->data, 'id', function ($model) {
                if ($model['name'] == 'all') {
                    return [
                        'label' => $this->labelOfAll .=
                            ($this->typeDD === 'serviceType') ?
                                ' (' . $model['count'] . ')' : '',

                        'url' => Url::current([$this->typeDD => 'all']),
                        'options' => [
                            'class' =>
//                                ($testExpression || Yii::$app->request->getQueryParam($this->typeDD) == null) ? 'active' : null;

                                OrdersHelpers::getActiveClass($this->typeDD, 'all')

                        ]
                    ];
                }
                return [
                    'label' => ($this->typeDD === 'serviceType') ?
                        '<span class="label-id">' . $model['id'] . '</span> ' .
                        Yii::t('app', $model['name']) . ' (' . ($model['count'] ?: "0") . ')' :
                        Yii::t('app', $model['name']),
                    'url' => Url::current([$this->typeDD => $model['id']]),
                    'options' => [
                        'class' => OrdersHelpers::getActiveClass($this->typeDD, $model['id'])
                    ]
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
        return $this->render(
            'mainDDView',
            [
                'dropDown' => $this->dropDown,
                'dropDownLabel' => $this->dropDownLabel
            ]
        );

    }
}
