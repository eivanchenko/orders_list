<?php

namespace app\modules\orders\widgets;

use Yii;
use yii\base\Widget;
use yii\bootstrap\Dropdown;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\modules\orders\models\Orders;


class ServiceDropDown extends Widget
{

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return '<div class="dropdown">
        <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        ' . Yii::t('app', 'label.service') . '
          <span class="caret"></span>
        </button>' . Dropdown::widget([
            'encodeLabels' => false,
            'items' => ArrayHelper::map(Orders::getServicesTypesCount(), 'id',  function ($model) {
                if ($model['name'] == '') {
                    return ['label' => Yii::t('app', 'label.all') . ' (' . $model['count'] .  ')', 'url' => Url::current(['OrdersSearch[service_type]' => '']), 'options' => ['class' => Orders::getActiveClass('service_type', 'all')]];
                }
                return ['label' => '<span class="label-id">' . $model['id'] . '</span> ' . Yii::t('app', $model['name']) . ' (' . $model['count'] . ')', 'url' => Url::current(['OrdersSearch[service_type]' => $model['id']]), 'options' => ['class' => Orders::getActiveClass('service_type',  $model['id'])]];
            }),
            'submenuOptions' => [
                'aria-labelledby' => 'dropdownMenu1'
            ]
        ]) . '</div></div>';
    }
}
