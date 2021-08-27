<?php

use yii\grid\GridView;
use app\modules\orders\widgets\ServiceDropDown;
use app\modules\orders\widgets\ModeDropDown;

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
                    return '<span class="label-id"> ' .  $model->service_id . '</span>  ' .  Yii::t('app', $model->service_type);
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
    ]); ?>


</div>