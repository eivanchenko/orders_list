<?php

namespace orders\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use orders\models\Orders;

/**
 * Class OrdersSearch
 * @package orders\models
 */
class OrdersSearch extends Orders
{
    public $fullName;
    public $status;
    public $serviceType;
    public $serviceID;
    public $searchType;
    public $searchWord;
    public $mode;


    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['userID',], 'integer'],
            [['mode'], 'string'],
            [['status', 'serviceType', 'serviceID', 'searchType', 'searchWord'], 'trim']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios(): array
    {
        return Model::scenarios();
    }

    /**
     * @param array $params
     * @param boolean $rawRequest used when a raw query is needed
     * @return \orders\models\query\OrdersQuery|ActiveDataProvider
     */
    public function search(array $params, bool $rawRequest = false)
    {
        $query = Orders::find();
        $query->joinWith(['users', 'services']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);

        $dataProvider->setSort([
            'defaultOrder' => ['id' => SORT_DESC],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        $query->andFilterWhere(['orders.mode' => is_numeric($this->mode) ? $this->mode : '', 'services.id' => is_numeric($this->serviceType) ? $this->serviceType : '', 'orders.status' => is_numeric($this->status) ? $this->status : '']);

        if ($this->searchWord) {

            switch ($this->searchType) {
                case 1:
                    $query->andWhere(['=', 'orders.id', $this->searchWord]);
                    break;
                case 2:
                    $query->andWhere(['like', 'orders.link', $this->searchWord]);
                    break;
                case 3:
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

        return $rawRequest ? $query : $dataProvider;
    }

    /**
     * @return array
     */
    public static function getServicesTypesCount(): array
    {
        $queryParams = Yii::$app->request->queryParams ?: ['mode' => 'all'];
        $ordersSearch =  new OrdersSearch();
        $mainQuery = $ordersSearch->search($queryParams, true);
        $subQuery  = (new Query())->select(['service_id AS id', 'count(*) AS count'])->from(['subQuery' => $mainQuery])->groupBy('service_id')->orderBy(['count' => SORT_DESC]);
        $doneQuery = (new Query())->select(['services.id', 'services.name', 'main.count'])->from(['services'])->join('LEFT JOIN', ['main' => $subQuery], 'main.id = services.id')->orderBy(['main.count' => SORT_DESC])->all();
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
        return  empty($doneQuery) ? [] : $doneQuery;
    }
}
