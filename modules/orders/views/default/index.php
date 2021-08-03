<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use yii\i18n\Formatter;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use app\modules\orders\models;
use app\modules\orders\models\Orders;
use app\modules\orders\models\Services;

?>
<h1>OrdersModule</h1>



<div class="container-fluid">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => '{begin} to {end} of {totalCount}',
        'layout' => "{summary}\n{items}\n{pager}",
        'columns' => [
            'id',
            'full_name:html',
            'link', 'quantity', [
                'attribute' => 'service_type', 'format' => 'html', 'label' => 'Service',  'filter' => Html::activeDropDownList($searchModel, 'service_type', ArrayHelper::map(Services::find()->asArray()->all(), 'id', 'name'), ['class' => 'btn btn-th btn-default dropdown-toggle', 'prompt' => 'All']),
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
        ]
    ]); ?>

</div>