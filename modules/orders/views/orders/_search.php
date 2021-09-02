<?php

use app\modules\orders\widgets\StatusLink;
use app\modules\orders\widgets\SearchForm;

/** @var $model app\modules\orders\models\Orders */

?>
<ul class="nav nav-tabs p-b">


    <?= StatusLink::widget() ?>
    <?= SearchForm::widget(['model' => $model]) ?>
</ul>