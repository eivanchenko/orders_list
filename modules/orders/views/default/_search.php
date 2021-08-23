<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\modules\orders\models\Orders;


?>
<ul class="nav nav-tabs p-b">

    <li><?= Html::a(GlobalsConst::STATUS_ALL_ORDERS, ['/?OrdersSearch[status]='],) ?></li>
    <li><?= Html::a(GlobalsConst::STATUS_PENDING, ['/?OrdersSearch[status]=0'],) ?></li>
    <li><?= Html::a(GlobalsConst::STATUS_IN_PROGRESS, ['/?OrdersSearch[status]=1'],) ?></li>
    <li><?= Html::a(GlobalsConst::STATUS_COMPLETED, ['/?OrdersSearch[status]=2'],) ?></li>
    <li><?= Html::a(GlobalsConst::STATUS_CANCELED, ['/?OrdersSearch[status]=3'],) ?></li>
    <li><?= Html::a(GlobalsConst::STATUS_ERROR, ['/?OrdersSearch[status]=4'],) ?></li>
    <li class="pull-right custom-search">

        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
            'options' => [
                'class' => 'form-inline'
            ]
        ]); ?>
        <div class="input-group">


            <?= $form->field($model, 'search_word')->textInput()->input('text', ['placeholder' => 'Search orders'])->label(false); ?>
            <?= Html::beginTag('span', ['class' => 'input-group-btn search-select-wrap']) ?>
            <?= Html::activeDropDownList($model, 'search_type', ArrayHelper::map(Orders::getSearch_types(), 'id', 'type'), [
                'class' => 'form-control search-select',
            ]) ?>
            <?= Html::submitButton("<span class='glyphicon glyphicon-search' aria-hidden='true'></span>", ['class' => 'btn btn-default']) ?>
            <?= Html::endTag('span') ?>
        </div>
        <?php ActiveForm::end(); ?>
    </li>
</ul>