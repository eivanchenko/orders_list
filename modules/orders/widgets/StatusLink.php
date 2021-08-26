<?php

namespace app\modules\orders\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\modules\orders\models\Orders;


class StatusLink extends Widget
{

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        if (Orders::getQueryParams('search_type') &&  Orders::getQueryParams('status')) {
            echo Orders::getActiveClass('status', 'all') . '<a href="' . Url::current(['index', 'OrdersSearch[status]' => 'all', 'OrdersSearch[service_type]' => 'all', 'OrdersSearch[mode]' => 'all']) . '"> ' . Yii::t('app', 'status.type.all') . '</a></li>';
        } else {
            echo Orders::getActiveClass('status', 'all') . '<a href="' . Url::to(['index']) . '"> ' . Yii::t('app', 'status.type.all') . '</a></li>';
        }

        foreach (Orders::getStatusType() as $item) {
            if (Orders::getQueryParams('search_type')) {
                echo  Orders::getActiveClass('status', ArrayHelper::getValue($item, "id")) . '<a href="' . Url::current(['index', 'OrdersSearch[status]' => ArrayHelper::getValue($item, "id"), 'OrdersSearch[service_type]' => 'all', 'OrdersSearch[mode]' => 'all']) . '"> ' . ArrayHelper::getValue($item, "type") . '</a></li>';
            } else {
                echo  Orders::getActiveClass('status', ArrayHelper::getValue($item, "id")) . '<a href="' . Url::to(['index', 'OrdersSearch[status]' => ArrayHelper::getValue($item, "id")]) . '"> ' . ArrayHelper::getValue($item, "type") . '</a></li>';
            }
        };
    }
}
