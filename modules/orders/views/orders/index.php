<?php

use orders\widgets\OrdersGridView;


/**
 * @var  $this yii\web\View
 * @var  $searchModel orders\models\search\OrdersSearch 
 * @var  $dataProvider  yii\data\ActiveDataProvider */
?>

<div class="container-fluid">
    <?= $this->render('_search', ['model' => $searchModel]) ?>
    <?= OrdersGridView::widget(['dataProvider' => $dataProvider]) ?>

</div>