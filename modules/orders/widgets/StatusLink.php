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

    /**
     * @return string|void
     * @throws \Exception
     */
    public function run()
    {
        if (is_numeric(Orders::getQueryParams('search_type'))) {
            echo Orders::getActiveClass('status', 'all') . '<a href="' . Url::current(['index', 'status' => 'all', 'service_type' => 'all', 'mode' => 'all']) . '"> ' . Yii::t('app', 'status.type.all') . '</a></li>';
        } else {
            echo Orders::getActiveClass('status', 'all') . '<a href="' . Url::to(['index']) . '"> ' . Yii::t('app', 'status.type.all') . '</a></li>';
        }

        foreach (Orders::getStatusType() as $item) {
            if (is_numeric(Orders::getQueryParams('search_type'))) {
                echo  Orders::getActiveClass('status', ArrayHelper::getValue($item, "id")) . '<a href="' . Url::current(['index', 'status' => ArrayHelper::getValue($item, "id"), 'service_type' => 'all', 'mode' => 'all']) . '"> ' . ArrayHelper::getValue($item, "type") . '</a></li>';
            } else {
                echo  Orders::getActiveClass('status', ArrayHelper::getValue($item, "id")) . '<a href="' . Url::to(['index', 'status' => ArrayHelper::getValue($item, "id")]) . '"> ' . ArrayHelper::getValue($item, "type") . '</a></li>';
            }
        };
    }
}
