<?php

namespace app\modules\orders\widgets\views;

use yii\helpers\Html;

/**
 * @var $model yii\base\Model
 * @var $paramsForm array
 * @var $paramsField array
 * @var $activeForm yii\widgets\ActiveForm
 * @var $submitButton string
 * @var $dropDown  string */

?>
<li class="pull-right custom-search">
    <?php $form = $activeForm::begin($paramsForm) ?>
    <div class="input-group">

        <?= $form->field($model, $paramsField['attribute'])->textInput()->input($paramsField['type'], ['placeholder' => $paramsField['placeholder']])->label($paramsField['label']); ?>
        <?= Html::beginTag('span', ['class' => 'input-group-btn search-select-wrap']) ?>
        <?= $dropDown  ?>
        <?= $submitButton ?>
        <?= Html::endTag('span') ?>
    </div>
    <?php $activeForm::end() ?>
</li>