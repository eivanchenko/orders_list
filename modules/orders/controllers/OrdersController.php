<?php

namespace orders\controllers;

use orders\models\search\OrdersSearch;
use Yii;
use yii\web\Controller;
use yii\web\Response;

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
     * @return Response
     */
    public function actionError(): Response
    {
        return $this->redirect(['orders/index']);
    }

}
