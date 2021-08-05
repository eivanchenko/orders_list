<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<ul class="nav nav-tabs p-b">

    <li><?= Html::a(GlobalsConst::STATUS_ALL_ORDERS, ['/orders/default?OrdersSearch[status]='],) ?></li>
    <li><?= Html::a(GlobalsConst::STATUS_PENDING, ['/orders/default?OrdersSearch[status]=0'],) ?></li>
    <li><?= Html::a(GlobalsConst::STATUS_IN_PROGRESS, ['/orders/default?OrdersSearch[status]=1'],) ?></li>
    <li><?= Html::a(GlobalsConst::STATUS_COMPLETED, ['/orders/default?OrdersSearch[status]=2'],) ?></li>
    <li><?= Html::a(GlobalsConst::STATUS_CANCELED, ['/orders/default?OrdersSearch[status]=3'],) ?></li>
    <li><?= Html::a(GlobalsConst::STATUS_ERROR, ['/orders/default?OrdersSearch[status]=4'],) ?></li>
    <li class="pull-right custom-search">
        <div class="input-group">
            <?php $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
            ]); ?>

            <?= $form->field($model, 'full_name')->textInput()->input('text', ['placeholder' => 'Search Orders'])->label(false); ?>
            <?= Html::submitButton('Find', ['class' => 'btn btn-default']) ?>



        </div>
        <?php ActiveForm::end(); ?>
    </li>
</ul>