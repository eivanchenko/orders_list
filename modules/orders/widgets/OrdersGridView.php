<?php

namespace app\modules\orders\widgets;

use Yii;
use yii\base\Widget;
use yii\grid\GridView;

/**
 * Class OrdersGridView
 * @package app\modules\orders\widgets
 */
class OrdersGridView  extends Widget
{
    public $dataProvider;
    public $ordersGrid;

    /**
     * {@inheritDoc}
     * @throws \Exception
     */
    public  function init()
    {
        parent::init();
        $this->ordersGrid = GridView::widget([
            'dataProvider' => $this->dataProvider,
            'summary' => '{begin} to {end} of {totalCount}',
            'layout' => "{items}\n<div class='row'><div class='col-sm-8'>{pager}</div><div class='col-sm-4 pagination-counters'>{summary}</div></div>",
            'columns' => [
                'id',
                'fullName:html',
                'link', 'quantity', [
                    'attribute' => 'serviceType', 'format' => 'html',
                    'headerOptions' => ['class' => 'dropdown-th'],
                    'value' => function ($model) {
                        return '<span class="label-id"> ' .  $model->serviceID . '</span>  ' .  Yii::t('app', $model->serviceType);
                    },
                    'header' =>  ServiceDropDown::widget(),
                ],
                ['attribute' => 'status', 'format' => 'text', 'filter' => false, 'label' =>  Yii::t('app', 'label.status'),  'value' => function ($model) {
                    return $model->getStatusType()[$model->status]['type'];
                }], [
                    'attribute' => 'mode', 'headerOptions' => ['class' => 'dropdown-th'], 'format' => 'html',
                    'header' => ModeDropDown::widget(),
                    'value' => function ($model) {
                        return $model->getModeType()[$model->mode]['type'];
                    }
                ],           [
                    'attribute' => 'created_at',
                    'format' => ['date', 'php:Y-m-d h:i:s'],
                    'label' => Yii::t('app', 'label.created')
                ],
            ],
            'tableOptions' => ['class' => 'table order-table'],
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function run(): string
    {
        return $this->ordersGrid;
    }
}
