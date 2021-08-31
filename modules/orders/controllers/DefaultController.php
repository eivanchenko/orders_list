<?php

namespace app\modules\orders\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Url;
use app\modules\orders\models\OrdersSearch;

/**
 * Class DefaultController
 * @package app\modules\orders\controllers
 */
class DefaultController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OrdersSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return Response
     */
    public function actionError()
    {
        return $this->redirect(Url::to(['index']));
    }
}
