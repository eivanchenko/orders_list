<?php

namespace app\modules\orders\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\modules\orders\models\Orders;

/**
 * Class SearchForm
 * @package app\modules\orders\widgets
 */
class SearchForm extends Widget
{
    public $dropDown;
    public $submitButton;
    public $model;
    public $activeForm;
    public $paramsForm;
    public $paramsField;

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        /** @var Orders $model */

        parent::init();
        $this->activeForm = ActiveForm::class;
        $this->paramsForm = [
            'action' => Url::current(['index', 'serviceType' => 'all', 'mode' => 'all', 'searchWord' => null, 'searchType' => null]),
            'method' => 'get',
            'options' => [
                'class' => 'form-inline'
            ]
        ];
        $this->paramsField = ['type' => 'text', 'attribute' => 'searchWord', 'placeholder' => Yii::t('app', 'search.placeholder'), 'label' => false];
        $this->dropDown = Html::activeDropDownList($this->model, 'searchType', ArrayHelper::map(Orders::getSearchTypes(), 'id', 'type'), [
            'class' => 'form-control search-select',
        ]);
        $this->submitButton = Html::submitButton("<span class='glyphicon glyphicon-search' aria-hidden='true'></span>", ['class' => 'btn btn-default']);
    }

    /**
     * {@inheritDoc}
     */
    public function run(): string
    {
        return $this->render('searchFormView', ['activeForm' => $this->activeForm, 'paramsForm' => $this->paramsForm, 'paramsField' => $this->paramsField, 'dropDown' => $this->dropDown, 'submitButton' => $this->submitButton, 'model' => $this->model]);
    }
}
