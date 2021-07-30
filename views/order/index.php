<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>
<h1>Orders</h1>
<ul>
<?php foreach ($orders as $order): ?>
    <li>
        <?= Html::encode("{$order->id} ({$order->status})") ?>:
        <?= $order->link ?>
    </li>
<?php endforeach; ?>
</ul>

<?= LinkPager::widget(['pagination' => $pagination]) ?>