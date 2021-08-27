<?php

namespace app\modules\orders\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\modules\orders\models\OrdersSearch;

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

    public function actionError()
    {
        return $this->redirect(Yii::$app->homeUrl);
    }
}
