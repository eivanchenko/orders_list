<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use yii\i18n\Formatter;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use app\modules\orders\models;
use yii\db\Query;
use app\modules\orders\models\Orders;
use app\modules\orders\models\Services;

$service_list = Orders::getServicesTypesCount();

?>
<?= $this->render('_search', ['model' => $searchModel]) ?>

<div class="container-fluid">
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => '{begin} to {end} of {totalCount}',
        'layout' => "{items}\n<div class='row'><div class='col-sm-8'>{pager}</div><div class='col-sm-4 pagination-counters'>{summary}</div></div>",
        'columns' => [
            'id',
            'full_name:html',
            'link', 'quantity', [
                'attribute' => 'service_type', 'format' => 'html',
                'headerOptions' => ['class' => 'dropdown-th'],
                // 'value' => function ($model) {
                //     $service_list = $model::getList($model->user_id);
                //     return  $service_list[$model->service_id]['count'].'  '. $service_list[$model->service_id]['name'];
                //     // return $model->service_id;
                // },
                'value' => function ($model) {
                    return Orders::getUserServiceCount($model->user_id, $model->service_id);
                },
                'label' => 'Service',
                'filter' => Html::activeDropDownList($searchModel, 'service_type', ArrayHelper::map(Orders::getServicesTypesCount(), 'id',  function ($model) {
                    // return $elem['name'];
                    return $model['count'] . ' ' . $model['name'];
                }), [
                    'prompt' => 'All',
                    'class' => 'btn btn-th btn-default dropdown-toggle',
                ]),
                // 'filterInputOptions' => ['class' => 'dropdown-th', 'id' => null]
                // 'label' => 'Service',  'filter' => Html::activeDropDownList($searchModel, 'service_type', ArrayHelper::map(Services::find()->asArray()->all(), 'id', 'name'), ['class' => 'btn btn-th btn-default dropdown-toggle', 'prompt' => 'All']),
            ],
            ['attribute' => 'status', 'format' => 'text', 'label' => 'Status',  'value' => function ($model) {
                return $model->getStatus();
            }], ['attribute' => 'mode', 'headerOptions' => ['class' => 'dropdown-th'], 'format' => 'html', 'label' => 'Mode', 'filterInputOptions' => ['class' => 'btn btn-th btn-default dropdown-toggle',  'prompt' => 'All'], 'filter' => ['0' => 'Manual', '1' => 'Auto'], 'value' => function ($model) {
                return $model->getMode();
            }],           [
                'attribute' => 'created_at',
                'format' => ['date', 'php:Y-m-d h:i:s'],
                'label' => 'Created'
            ],
        ],
        'tableOptions' => ['class' => 'table order-table'],
    ]); ?>


</div>