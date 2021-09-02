<?php

namespace app\modules\orders\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use app\modules\orders\models\Orders;

/**
 * Class OrdersSearch
 * @package app\modules\orders\models
 */
class OrdersSearch extends Orders
{
    public $fullName;
    public $status;
    public $serviceType;
    public $serviceID;
    public $searchType;
    public $searchWord;


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
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params): ActiveDataProvider
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
            'attributes' => [
                'id',
                'fullName' => [
                    'asc' => ['first_name' => SORT_ASC, 'last_name' => SORT_ASC],
                    'desc' => ['first_name' => SORT_DESC, 'last_name' => SORT_DESC],
                    'label' => 'Full Name',
                    'default' => SORT_ASC
                ],
            ],
            'defaultOrder' => ['id' => SORT_DESC],
        ]);
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        if (Yii::$app->request->getQueryParam('status') == 'all') {
            $this->status = '';
        }
        if (Yii::$app->request->getQueryParam('mode') == 'all') {
            $this->mode = '';
        }
        if (Yii::$app->request->getQueryParam('serviceType') == 'all') {
            $this->serviceType = '';
        }
        $query->andFilterWhere(['orders.mode' => $this->mode, 'services.id' => $this->serviceType, 'orders.status' => $this->status]);

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
        return $dataProvider;
    }


    /**
     * @return array
     */
    public static function getServicesTypesCount(): array
    {
        $mode = Yii::$app->request->getQueryParam('mode');
        $status = Yii::$app->request->getQueryParam('status');
        $serviceType = Yii::$app->request->getQueryParam('serviceType');
        $searchWord =  Yii::$app->request->getQueryParam('searchWord');
        $searchType = Yii::$app->request->getQueryParam('searchType');

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
}
