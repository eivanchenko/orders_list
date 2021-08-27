<?php

namespace app\modules\orders\controllers;

use Yii;
use yii\web\Controller;
use app\modules\orders\models\Orders;
use yii\base\Model;
use app\modules\orders\models\OrdersSearch;
use app\modules\orders\models\Services;

class DefaultController extends Controller
{

    public function actionIndex()
    {
        $searchModel = new OrdersSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
