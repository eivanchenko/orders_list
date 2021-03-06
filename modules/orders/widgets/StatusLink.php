<?php

namespace orders\widgets;

use Exception;
use orders\components\OrdersHelpers;
use orders\models\Orders;
use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Class StatusLink
 * @package orders\widgets
 */
class StatusLink extends Widget
{
    /**
     * {@inheritDoc}
     */
    public function init()
    {
        parent::init();
    }

    /**
     * {@inheritDoc}
     * @return string|null
     * @throws Exception
     */
    public function run(): ?string
    {
        $statusLinks = [];
        $statusTypeAll = Yii::t('app', 'status.type.all');

        if (is_numeric(Yii::$app->request->getQueryParam('searchType'))) {
            array_push(
                $statusLinks,
                OrdersHelpers::getActiveClass('status', 'all') .
                Html::a($statusTypeAll, Url::current([
                    'index',
                    'status' => 'all',
                    'serviceType' => 'all',
                    'mode' => 'all'
                ])) .
                Html::endTag('li')
            );
        } else {
            array_push(
                $statusLinks,
                OrdersHelpers::getActiveClass('status', 'all') .
                Html::a($statusTypeAll, Url::to(['index'])) .
                Html::endTag('li')
            );
        }

        foreach (Orders::getStatusType() as $item) {
            if (is_numeric(Yii::$app->request->getQueryParam('searchType'))) {
                array_push(
                    $statusLinks,
                    OrdersHelpers::getActiveClass('status', ArrayHelper::getValue($item, "id")) .
                    Html::a(
                        ArrayHelper::getValue($item, "type"),
                        Url::current([
                            'index',
                            'status' => ArrayHelper::getValue($item, "id"),
                            'serviceType' => 'all',
                            'mode' => 'all'
                        ])
                    ) .
                    Html::endTag('li')
                );
            } else {
                array_push(
                    $statusLinks,
                    OrdersHelpers::getActiveClass('status', ArrayHelper::getValue($item, "id")) .
                    Html::a(
                        ArrayHelper::getValue($item, "type"),
                        Url::to([
                            'index',
                            'status' => ArrayHelper::getValue($item, "id")
                        ])
                    ) .
                    Html::endTag('li')
                );
            }
        }
        return $statusLinks ? implode('', $statusLinks) : null;
    }
}
