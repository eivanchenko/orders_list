<?php

namespace app\modules\orders\widgets\views;

/** @var $dropDownLabel string */
/** @var $dropDown app\modules\orders\widgets\ModeDropDown */
?>
<div class="dropdown">
    <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        <?= $dropDownLabel ?>
        <span class="caret"></span>
    </button><?= $dropDown ?>
</div>