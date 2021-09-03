<?php

use orders\widgets\StatusLink;
use orders\widgets\SearchForm;

/** @var $model orders\models\Orders */

?>
<ul class="nav nav-tabs p-b">


    <?= StatusLink::widget() ?>
    <?= SearchForm::widget(['model' => $model]) ?>
</ul>