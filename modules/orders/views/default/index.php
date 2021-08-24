<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use yii\i18n\Formatter;
use yii\bootstrap\Dropdown;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use app\modules\orders\models;
use yii\db\Query;
use yii\helpers\Url;
use app\modules\orders\models\Orders;
use app\modules\orders\models\Services;

$service_list = Orders::getServicesTypesCount();
?>
<?= $this->render('_search', ['model' => $searchModel]) ?>

<div class="container-fluid">
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '{begin} to {end} of {totalCount}',
        'layout' => "{items}\n<div class='row'><div class='col-sm-8'>{pager}</div><div class='col-sm-4 pagination-counters'>{summary}</div></div>",
        'columns' => [
            'id',
            'full_name:html',
            'link', 'quantity', [
                'attribute' => 'service_type', 'format' => 'html',
                'headerOptions' => ['class' => 'dropdown-th'],
                'value' => function ($model) {
                    return Orders::getUserServiceCount($model->user_id, $model->service_id);
                },
                'header' => '<div class="dropdown">
                <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                  Service
                  <span class="caret"></span>
                </button>' . Dropdown::widget([
                    'encodeLabels' => false,
                    'items' => ArrayHelper::map(Orders::getServicesTypesCount(), 'id',  function ($model) {
                        if ($model['name'] == '') {
                            return ['label' => 'All' . ' (' . $model['count'] .  ')', 'url' => Url::current(['OrdersSearch[service_type]' => ''])];
                        }
                        return ['label' => '<span class="label-id">' . $model['count'] . '</span> ' . $model['name'], 'url' => Url::current(['OrdersSearch[service_type]' => $model['id']])];
                    }),
                    'submenuOptions' => [
                        'aria-labelledby' => 'dropdownMenu1'
                    ]
                ]) . '</div></div>',
            ],
            ['attribute' => 'status', 'format' => 'text', 'filter' => false, 'label' => 'Status',  'value' => function ($model) {
                return $model->getStatus();
            }], [
                'attribute' => 'mode', 'headerOptions' => ['class' => 'dropdown-th'], 'format' => 'html',
                'header' => '<div class="dropdown">
                <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                  Mode
                  <span class="caret"></span>
                </button>' . Dropdown::widget([
                    'items' => [['label' => 'All', 'url' => Url::current(['OrdersSearch[mode]' => ''])], ['label' => 'Manual', 'url' => Url::current(['OrdersSearch[mode]' => '0'])], ['label' => 'Auto', 'url' => Url::current(['OrdersSearch[mode]' => '1'])]],
                    'submenuOptions' => [
                        'aria-labelledby' => 'dropdownMenu1'
                    ]
                ]) . '</div></div>',
                'value' => function ($model) {
                    return $model->getMode();
                }
            ],           [
                'attribute' => 'created_at',
                'format' => ['date', 'php:Y-m-d h:i:s'],
                'label' => 'Created'
            ],
        ],
        'tableOptions' => ['class' => 'table order-table'],
    ]); ?>


</div>