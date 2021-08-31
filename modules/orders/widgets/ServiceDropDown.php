<?php

namespace app\modules\orders\widgets;

use Yii;
use yii\base\Widget;
use yii\bootstrap\Dropdown;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\modules\orders\models\Orders;

/**
 * Class ServiceDropDown
 * @package app\modules\orders\widgets
 */
class ServiceDropDown extends Widget
{
    /**
     * {@inheritDoc}
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function run()
    {
        return '<div class="dropdown">
        <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        ' . Yii::t('app', 'label.service') . '
          <span class="caret"></span>
        </button>' . Dropdown::widget([
            'encodeLabels' => false,
            'items' =>
            ArrayHelper::map(Orders::getServicesTypesCount(), 'id',  function ($model) {
                if ($model['name'] == '') {
                    return ['label' => Yii::t('app', 'label.all') . ' (' . $model['count'] .  ')', 'url' => Url::current(['serviceType' => 'all']), 'options' => ['class' => Orders::getActiveClass('serviceType', 'all')]];
                }
                return ['label' => '<span class="label-id">' . $model['id'] . '</span> ' . Yii::t('app', $model['name']) . ' (' . ($model['count'] ?: "0")  . ')', 'url' => Url::current(['serviceType' => $model['id']]), 'options' => ['class' => Orders::getActiveClass('serviceType',  $model['id'])]];
            }),
            'submenuOptions' => [
                'aria-labelledby' => 'dropdownMenu1'
            ]
        ]) . '</div></div>';
    }
}
