<?php

use Yii;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use app\assets\AppAsset;


/** @var $this \yii\web\View  */
/** @var $content string  */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>
    <?php
    NavBar::begin([
        'brandUrl' => Url::to(['index']),
        'innerContainerOptions' => ['class' => 'container-fluid'],
        'options' => [
            'id' => 'bs-navbar',
            'class' => 'navbar navbar-fixed-top navbar-default',
        ],
    ]);
    echo Nav::widget([
        'options' => [
            'class' => 'nav navbar-nav',
        ],
        'items' => [
            [
                'label' => 'Orders', 'url' => Url::to(['index']),
                'active' => true
            ]
        ],
    ]);
    NavBar::end();
    ?>

        <?= $content ?>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>