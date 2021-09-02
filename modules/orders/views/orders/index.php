<?php

use app\modules\orders\widgets\OrdersGridView;


/**
 * @var  $this yii\web\View
 * @var  $searchModel app\modules\orders\models\search\OrdersSearch 
 * @var  $dataProvider  yii\data\ActiveDataProvider */
?>

<?= $this->render('_search', ['model' => $searchModel]) ?>

<div class="container-fluid">
    <?= OrdersGridView::widget(['dataProvider' => $dataProvider]) ?>

</div>