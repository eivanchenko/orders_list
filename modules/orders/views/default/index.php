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

use function PHPSTORM_META\map;

$service_list = Orders::getServicesTypesCount();
$coun = Orders::getUserServiceCount(1, 5);
// $countZero = $service_list[1]['name'] . '---' . $service_list[1]['count'];
//  foreach($service_list as $i) {
//     print_r($i);
?>
<h1>OrdersModule</h1>
<?= $this->render('_search', ['model' => $searchModel]) ?>

<div class="container-fluid">
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => '{begin} to {end} of {totalCount}',
        'layout' => "{summary}\n{items}\n{pager}",
        'columns' => [
            'id',
            'full_name:html',
            'link', 'quantity', [
                'attribute' => 'service_type', 'format' => 'html',
                // 'value' => function ($model) {
                //     $service_list = $model::getList($model->user_id);
                //     return  $service_list[$model->service_id]['count'].'  '. $service_list[$model->service_id]['name'];
                //     // return $model->service_id;
                // },
                'value' => function ($model) {
                    return Orders::getUserServiceCount($model->user_id, $model->service_id);
                },
                'label' => 'Service',  'filter' => Html::activeDropDownList($searchModel, 'service_type', ArrayHelper::getColumn(Orders::getServicesTypesCount(), function ($elem) {
                    // return $elem['name'];
                    return $elem['count'] . ' ' . $elem['name'];
                }), [
                    'text' => 'Test text',
                    'class' => 'btn btn-th btn-default dropdown-toggle',
                    'options' => [
                        'value1' => 'NONE TEST',
                    ]
                ]),
                // 'label' => 'Service',  'filter' => Html::activeDropDownList($searchModel, 'service_type', ArrayHelper::map(Services::find()->asArray()->all(), 'id', 'name'), ['class' => 'btn btn-th btn-default dropdown-toggle', 'prompt' => 'All']),
            ],
            ['attribute' => 'status', 'format' => 'text', 'label' => 'Status',  'value' => function ($model) {
                return $model->getStatus();
            }], ['attribute' => 'mode', 'format' => 'html', 'label' => 'Mode', 'filterInputOptions' => ['class' => 'btn btn-th btn-default dropdown-toggle',  'prompt' => 'All'], 'filter' => ['0' => 'Manual', '1' => 'Auto'], 'value' => function ($model) {
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