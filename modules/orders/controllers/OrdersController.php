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
        $model = new OrdersSearch();
        $query = $model->getReadyData(Yii::$app->request->get());
        return $this->render('index', [
            'searchModel' => $model,
            'dataProvider' => $query,
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
