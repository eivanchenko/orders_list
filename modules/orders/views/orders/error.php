<?php

use yii\helpers\Html;

/**
 * @var  $this yii\web\View
 * @var  $message string
 * @var  $name string
 */

$this->title = $name;

?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        The above error occurred while the Web server was processing your request.
    </p>
    <p>
        <a href="http://localhost:8080/orders">Return to Home Page</a>
    </p>

</div>