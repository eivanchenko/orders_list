<?php

namespace orders\widgets;

use Exception;
use orders\models\Orders;
use Yii;
use yii\base\Widget;
use yii\grid\GridView;

/**
 * Class OrdersGridView
 * @package orders\widgets
 */
class OrdersGridView extends Widget
{
    public $dataProvider;
    public $ordersGrid;
    public $model;

    /**
     * {@inheritDoc}
     * @throws Exception
     */
    public function init()
    {
        parent::init();
        $this->ordersGrid = GridView::widget([
            'dataProvider' => $this->dataProvider,
            'summary' => '{begin} to {end} of {totalCount}',
            'layout' => "{items}\n<div class='row'><div class='col-sm-8'>
            <nav>{pager}</nav></div><div class='col-sm-4 pagination-counters'>{summary}</div></div>",
            'columns' => [
                'id',
                'fullName:html',
                [
                    'attribute' => 'link',
                    'contentOptions' => ['class' => 'link']
                ], 'quantity', [
                    'attribute' => 'serviceType',
                    'format' => 'html',
                    'headerOptions' => ['class' => 'dropdown-th'],
                    'header' => MainDropDown::widget([
                        'typeDD' => 'serviceType',
                        'data' => $this->model->getServicesTypesCount(),
                        'dropDownLabel' => 'label.service']),
                    'value' => function ($model) {
                        return '<span class="label-id"> ' . $model->serviceID .
                            '</span>  ' . Yii::t('app', $model->serviceType);
                    },
                    'contentOptions' => ['class' => 'service']
                ],
                [
                    'attribute' => 'status',
                    'format' => 'text',
                    'filter' => false,
                    'label' => Yii::t('app', 'label.status'),
                    'value' => function ($model) {
                        return $model->getStatusType()[$model->status]['type'];
                    }
                ], [
                    'attribute' => 'mode',
                    'headerOptions' => ['class' => 'dropdown-th'],
                    'format' => 'html',
                    'header' => MainDropDown::widget([
                        'typeDD' => 'mode',
                        'data' => Orders::getModeType(),
                        'dropDownLabel' => 'label.mode']),
                    'value' => function ($model) {
                        return $model->getModeType()[$model->mode]['name'];
                    }
                ], [
                    'attribute' => 'created_at',
                    'format' => 'html',
                    'value' => function ($model) {
                        return '<span class="nowrap">' .
                            date('Y-m-d', $model->created_at) .
                            '</span><span class="nowrap">' . date('H:i:s', $model->created_at) .
                            '</span>';
                    },
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
