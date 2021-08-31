<?php

namespace app\modules\orders\models;

use Yii;
use GlobalsConst;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * @property integer $id
 * @property integer $userID
 * @property integer $quantity
 * @property integer $created_at
 * @property integer $serviceID
 * @property integer $status
 * @property integer $mode
 * @property string  $link
 * @property string  $fullName
 */

/**
 * Class Orders
 * @package app\modules\orders\models
 */
class Orders extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'orders';
    }


    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'userID', 'quantity', 'serviceID', 'mode'], 'integer'],
            ['link', 'string'],
            [['fullName', 'status', 'serviceType', 'serviceID'], 'safe']

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function formName(): string
    {
        return '';
    }

    /**
     * @return UsersQuery
     */
    public function getUsers(): UsersQuery
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

    /**
     * @return ServicesQuery
     */
    public function getServices(): ServicesQuery
    {
        return $this->hasOne(Services::class, ['id' => 'service_id']);
    }

    /**
     * @return mixed
     */
    public function getServiceType()
    {
        return $this->services->name;
    }

    /**
     * @return mixed
     */
    public function getServiceID()
    {
        return $this->services->id;
    }

    /**
     * @return mixed|null
     */
    public function getUserID()
    {
        return $this->user_id;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->users->first_name . ' ' . $this->users->last_name;
    }

    /**
     * @return array
     */
    public static function getServicesTypesCount(): array
    {
        $mode = Orders::getQueryParams('mode');
        $status = Orders::getQueryParams('status');
        $serviceType = Orders::getQueryParams('serviceType');
        $searchWord =  Orders::getQueryParams('searchWord');
        $searchType = Orders::getQueryParams('searchType');

        $subQuery  = (new Query())->select(['service_id AS id', 'count(*) AS count'])->from(['orders', 'users'])->andWhere('orders.user_id = users.id')->groupBy('service_id');
        if (is_numeric($mode)) {
            $subQuery->andWhere(['orders.mode' => $mode]);
        }
        if (is_numeric($status)) {
            $subQuery->andWhere(['orders.status' => $status]);
        }
        if (is_numeric($searchType)) {
            switch ($searchType) {
                case 1:
                    $subQuery->andWhere(['=', 'orders.id', $searchWord]);
                    break;
                case 2:
                    $subQuery->andWhere(['like', 'orders.link', $searchWord]);
                    break;
                case 3:
                    $subQuery->andWhere(
                        [
                            'like',
                            'CONCAT(users.first_name, " ", users.last_name)',
                            $searchWord
                        ]
                    );
                    break;
            }
        }
        $mainQuery = (new Query())->select(['subQuery.id', 'subQuery.count', 'services.name'])->from(['subQuery' => $subQuery])->join('LEFT JOIN', 'services', 'subQuery.id = services.id')->orderBy(['subQuery.count' => SORT_DESC]);
        if (is_numeric($serviceType)) {
            $mainQuery->andWhere(['services.id' => $serviceType]);
        }

        $doneQuery = (new Query())->select(['services.id', 'services.name', 'main.count'])->from(['services'])->join('LEFT JOIN', ['main' => $mainQuery], 'main.id = services.id')->orderBy(['main.count' => SORT_DESC])->all();
        $totalCount = array_reduce(
            $doneQuery,
            function ($total, $item) {
                return $total += $item['count'];
            }
        );
        $doneQuery = ArrayHelper::merge(
            [
                ['id' => '', 'name' => '', 'count' => $totalCount ?: '0'],
            ],

            $doneQuery
        );
        return empty($doneQuery) ? [] : $doneQuery;
    }


    /**
     * @return array
     */
    public static function getStatusType(): array
    {
        return [
            ['id' => '0', 'type' => Yii::t('app', 'status.type.pending')],
            ['id' => '1', 'type' => Yii::t('app', 'status.type.inProgress')],
            ['id' => '2', 'type' => Yii::t('app', 'status.type.completed')],
            ['id' => '3', 'type' => Yii::t('app', 'status.type.canceled')],
            ['id' => '4', 'type' => Yii::t('app', 'status.type.error')],
        ];
    }

    /**
     * @return array[]
     */
    public static function getSearchTypes(): array
    {
        return [
            ['id' => GlobalsConst::SEARCH_ORDER_ID, 'type' =>  Yii::t('app', 'search.type.orderID')],

            ['id' => GlobalsConst::SEARCH_LINK, 'type' => Yii::t('app',  'search.type.link')],

            ['id' => GlobalsConst::SEARCH_USER, 'type' => Yii::t('app',  'search.type.username')],
        ];
    }

    /**
     * @return array
     */
    public static function getModeType(): array
    {
        return [
            ['id' => '0', 'type' => Yii::t('app', 'mode.manual')],
            ['id' => '1', 'type' => Yii::t('app', 'mode.auto')]
        ];
    }

    /**
     * @param string|null $parameters
     * @return string|null
     */
    public static function getQueryParams(?string $parameters): ?string
    {
        if (Yii::$app->request->queryParams && array_key_exists($parameters, Yii::$app->request->queryParams)) {
            return (string)Yii::$app->request->queryParams[$parameters];
        } else {
            return null;
        }
    }

    /**
     * @param string $type
     * @param string $parameter
     * @return string|null  along with the opening tag li
     */
    public static function getActiveClass(string $type, string $parameter): ?string
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

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'fullName' => Yii::t('app', 'label.user'),
            'link' => Yii::t('app', 'label.link'),
            'quantity' => Yii::t('app', 'label.quantity'),
            'serviceID' => Yii::t('app', 'label.service'),
            'serviceType' => Yii::t('app', 'label.serviceType'),
            'status' => Yii::t('app', 'label.status'),
            'mode' => Yii::t('app', 'label.mode'),
            'created_at' => Yii::t('app', 'label.created'),
        ];
    }

    /**
     * @return OrdersQuery
     */
    public static function find(): OrdersQuery
    {
        return new OrdersQuery(get_called_class());
    }
}
