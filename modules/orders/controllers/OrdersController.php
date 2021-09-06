<?php

namespace orders\controllers;

use orders\models\search\OrdersSearch;
use Yii;
use yii\web\Controller;

/**
 * Class OrdersController
 * @package orders\controllers
 */
class OrdersController extends Controller
{

    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $this->view->title = $_ENV['COMPOSE_PROJECT_NAME'];
        $searchModel = new OrdersSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return array
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }
}
