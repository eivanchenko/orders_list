<?php

namespace app\modules\orders\models;

use Yii;
use GlobalsConst;
use yii\db\ActiveRecord;
use yii\db\Query;

class Orders extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'quantity', 'service_id', 'mode'], 'integer'],
            ['link', 'string'],
            [['full_name', 'searchstring', 'status', 'service_type', 'service_id'], 'safe']

        ];
    }


    public function getUsers(): UsersQuery
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

    public function getServices(): ServicesQuery
    {
        return $this->hasOne(Services::class, ['id' => 'service_id']);
    }

    public function getService_Type()
    {
        return $this->services->name;
    }
    public function getService_id()
    {
        return $this->services->id;
    }

    public function getUser_id()
    {
        return $this->user_id;
    }

    public function getFull_Name()
    {
        return $this->users->first_name . ' ' . $this->users->last_name;
    }

    public static function getServicesTypesCount()
    {
        $unionQuery = (new Query())->select(['ROUND(0)', 'count(*)'])->from(['orders' => Orders::tableName()]);
        $subQuery  = (new Query())->select(['service_id AS id', 'count(*) AS count'])->from(['orders' => Orders::tableName()])->groupBy('service_id')->union($unionQuery);
        $query = (new Query())->select(['orders.id', 'orders.count', 'services.name'])->from(['orders' => $subQuery])->join('LEFT JOIN', 'services', 'orders.id = services.id')->orderBy(['orders.count' => SORT_DESC])->cache(180)->all();
        return $query;
    }

    public static function getStatusType()
    {
        return [
            ['id' => '0', 'type' => Yii::t('app', 'status.type.pending')],
            ['id' => '1', 'type' => Yii::t('app', 'status.type.inProgress')],
            ['id' => '2', 'type' => Yii::t('app', 'status.type.completed')],
            ['id' => '3', 'type' => Yii::t('app', 'status.type.canceled')],
            ['id' => '4', 'type' => Yii::t('app', 'status.type.error')],
        ];
    }

    public static function getSearch_types()
    {
        return [
            ['id' => GlobalsConst::SEARCH_ORDER_ID, 'type' =>  Yii::t('app', 'search.type.orderID')],

            ['id' => GlobalsConst::SEARCH_LINK, 'type' => Yii::t('app',  'search.type.link')],

            ['id' => GlobalsConst::SEARCH_USER, 'type' => Yii::t('app',  'search.type.username')],
        ];
    }

    public static function getModeType()
    {
        return [
            ['id' => '0', 'type' => Yii::t('app', 'mode.manual')],
            ['id' => '1', 'type' => Yii::t('app', 'mode.auto')]
        ];
    }

    public static function getQueryParams(string $parameters)
    {
        if (array_key_exists('OrdersSearch', Yii::$app->request->queryParams) && array_key_exists($parameters, Yii::$app->request->queryParams['OrdersSearch'])) {
            return Yii::$app->request->queryParams['OrdersSearch'][$parameters];
        } else {
            return null;
        }
    }

    public static function getActiveClass(string $type, string $parameter)
    {
        $liActive = '<li class="active">';
        $liNotActive = '<li>';
        $testExpression = Orders::getQueryParams($type) == $parameter;

        if ($type == 'status' && $parameter == 'all') {
            return ($testExpression  ||  Orders::getQueryParams($type) == null) ? $liActive : $liNotActive;
        } elseif ($type == 'status') {
            return $testExpression ? $liActive : $liNotActive;
        } else {
            if ($parameter == 'all') {
                return ($testExpression ||  Orders::getQueryParams($type) == null) ? 'active' : null;
            } else {
                return $testExpression ? 'active' : null;
            }
        }
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_name' => Yii::t('app', 'label.user'),
            'link' => Yii::t('app', 'label.link'),
            'quantity' => Yii::t('app', 'label.quantity'),
            'service_id' => Yii::t('app', 'label.service'),
            'service_type' => Yii::t('app', 'label.serviceType'),
            'status' => Yii::t('app', 'label.status'),
            'mode' => Yii::t('app', 'label.mode'),
            'created_at' => Yii::t('app', 'label.created'),
        ];
    }
    public static function find(): OrdersQuery
    {
        return new OrdersQuery(get_called_class());
    }
}
