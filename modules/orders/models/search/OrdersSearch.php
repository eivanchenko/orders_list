<?php

namespace orders\models\search;

use orders\models\Orders;
use orders\models\query\OrdersQuery;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * Class OrdersSearch
 * @package orders\models
 * @var $model Orders
 */
class OrdersSearch extends Orders
{
    const PAGE_SIZE = 100;
    const SERVICE_TYPE_ALL = 'all';
    const PARAMETER_ALL = 'all';

    public $fullName;
    public $status;
    public $serviceType;
    public $serviceID;
    public $searchType;
    public $searchWord;
    public $mode;

    /**
     * @return array
     */
    public function getServicesTypesCount(): array
    {
        $queryParams = Yii::$app->request->queryParams ?: ['mode' => self::MODE_TYPE_ALL];
        $mainQuery = $this->getDataFiltering($queryParams);
        $subQuery = (new Query())->
        select(['service_id AS id', 'count(*) AS count'])->
        from(['subQuery' => $mainQuery])->
        groupBy('service_id')->
        orderBy(['count' => SORT_DESC]);

        $doneQuery = (new Query())->
        select(['services.id', 'services.name', 'main.count'])->
        from(['services'])->join('LEFT JOIN', ['main' => $subQuery],
            'main.id = services.id')->
        orderBy(['main.count' => SORT_DESC])->all();
        $totalCount = array_reduce(
            $doneQuery,
            function ($total, $item) {
                return $total += $item['count'];
            }
        );
        $doneQuery = ArrayHelper::merge(
            [
                ['id' => '', 'name' => self::SERVICE_TYPE_ALL, 'count' => $totalCount ?: '0'],
            ],

            $doneQuery
        );
        return empty($doneQuery) ? [] : $doneQuery;
    }

    /**
     * @param $params
     * @return OrdersQuery
     */
    public function getDataFiltering($params): OrdersQuery
    {
        $this->setParams($params);
        return $this->ordersFilter();
    }

    /**
     * @param $params
     */
    public function setParams($params)
    {
        $this->mode = $params['mode'] ?? null;
        $this->status = $params['status'] ?? null;
        $this->serviceType = $params['serviceType'] ?? null;
        $this->searchWord = $params['searchWord'] ?? null;
        $this->searchType = $params['searchType'] ?? null;
    }

    /**
     * @return OrdersQuery
     */
    public function ordersFilter(): OrdersQuery
    {
        $query = $this->newSearch();
        if (!$this->validate()) {
            return $query;
        }

        if (isset($this->status)) {
            $query->andFilterWhere(['orders.status' => $this->status]);
        }
        if (isset($this->mode)) {
            $query->andFilterWhere(['orders.mode' => $this->mode]);
        }
        if (isset($this->serviceType)) {
            $query->andFilterWhere(['services.id' => $this->serviceType]);
        }

        if ($this->searchWord) {

            switch ($this->searchType) {
                case self::SEARCH_ORDER_ID:
                    $query->andWhere(['=', 'orders.id', $this->searchWord]);
                    break;
                case self::SEARCH_LINK:
                    $query->andWhere(['like', 'orders.link', $this->searchWord]);
                    break;
                case self::SEARCH_USERNAME:
                    $query->andWhere(
                        [
                            'like',
                            'CONCAT(users.first_name, " ", users.last_name)',
                            $this->searchWord
                        ]
                    );
                    break;
            }
        }
        return $query;
    }


    /**
     * @return OrdersQuery
     */
    public function newSearch(): OrdersQuery
    {
        $query = Orders::find();
        $query->joinWith(['users', 'services']);
        return $query;
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function getReadyData($params): ActiveDataProvider
    {
        $data = $this->getDataFiltering($params);
        $dataProvider = new ActiveDataProvider([
            'query' => $data,
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
            ],
        ]);
        $dataProvider->setSort([
            'defaultOrder' => ['id' => SORT_DESC],
        ]);
        return $dataProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [
                'status',
                'in',
                'range' => ArrayHelper::merge(
                    array_keys(self::getStatusType()),
                    [self::STATUS_TYPE_ALL]
                ),
            ],
            [
                'mode',
                'in',
                'range' => ArrayHelper::merge(
                    array_keys(self::getModeType()),
                    [self::MODE_TYPE_ALL]
                ),

            ],

            [['serviceType', 'mode', 'status'],
                'filter',
                'filter' => function ($value) {
                    return $value === self::PARAMETER_ALL ? '' : $value;
                }
            ],
            [
                'searchType',
                'in',
                'range' => [
                    self::SEARCH_ORDER_ID,
                    self::SEARCH_LINK,
                    self::SEARCH_USERNAME],
            ],
            [
                'searchWord',
                'string',
                'min' => 1,
                'max' => 350
            ],
            [
                [
                    'id',
                    'serviceType',
                    'serviceID',
                    'userID',
                    'link',
                    'quantity',
                    'created_at'
                ],
                'safe',
            ],
            [['serviceID', 'searchType', 'searchWord'], 'trim']
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function scenarios(): array
    {
        return Model::scenarios();
    }
}