<?php

namespace app\controllers;

use yii\web\Controller;
use yii\data\Pagination;
use app\models\Orders;

class OrderController extends Controller
{
    public function actionIndex()
    {
        $query = Orders::find();

        $pagination = new Pagination([
            'defaultPageSize' => 100,
            'totalCount' => $query->count(),    
            'pageSize' => 100
        ]);

        $orders = $query->select('*')
            ->orderBy('id')
            ->offset($pagination->offset)
            ->limit(100)
            ->all();

        return $this->render('index', [
            'orders' => $orders,
            'pagination' => $pagination,
        ]);
    }
}