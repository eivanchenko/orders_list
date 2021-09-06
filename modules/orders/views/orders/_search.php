<?php

use orders\widgets\SearchForm;
use orders\widgets\StatusLink;

/** @var $model orders\models\Orders */

?>
<ul class="nav nav-tabs p-b">


    <?= StatusLink::widget() ?>
    <?= SearchForm::widget(['model' => $model]) ?>
</ul>