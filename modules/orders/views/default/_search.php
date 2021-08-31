<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\modules\orders\models\Orders;
use app\modules\orders\widgets\StatusLink;

/** @var $model app\modules\orders\models\Orders */
?>
<ul class="nav nav-tabs p-b">


    <?= StatusLink::widget() ?>


    <li class="pull-right custom-search">

        <?php $form = ActiveForm::begin([
            'action' => Url::current(['index', 'serviceType' => 'all', 'mode' => 'all']),
            'method' => 'get',
            'options' => [
                'class' => 'form-inline'
            ]
        ]); ?>
        <div class="input-group">


            <?= $form->field($model, 'searchWord')->textInput()->input('text', ['placeholder' => Yii::t('app', 'search.placeholder')])->label(false); ?>
            <?= Html::beginTag('span', ['class' => 'input-group-btn search-select-wrap']) ?>
            <?= Html::activeDropDownList($model, 'searchType', ArrayHelper::map(Orders::getSearchTypes(), 'id', 'type'), [
                'class' => 'form-control search-select',
            ]) ?>
            <?= Html::submitButton("<span class='glyphicon glyphicon-search' aria-hidden='true'></span>", ['class' => 'btn btn-default']) ?>
            <?= Html::endTag('span') ?>
        </div>
        <?php ActiveForm::end(); ?>
    </li>
</ul>