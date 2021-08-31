<?php

namespace app\modules\orders\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
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
    public function rules()
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
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
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
        if (Orders::getQueryParams('status') == 'all') {
            $this->status = '';
        }
        if (Orders::getQueryParams('mode') == 'all') {
            $this->mode = '';
        }
        if (Orders::getQueryParams('serviceType') == 'all') {
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
        }}
        return $dataProvider;
    }
}
