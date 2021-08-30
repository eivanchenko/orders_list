<?php

namespace app\modules\orders\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\orders\models\Orders;

class OrdersSearch extends Orders
{
    public $full_name;
    public $status;
    public $service_type;
    public $service_id;
    public $search_type;
    public $search_word;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id',], 'integer'],
            [['mode'], 'string'],
            [['status', 'service_type', 'service_id', 'search_type', 'search_word'], 'trim']
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
                'full_name' => [
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
        if (Orders::getQueryParams('service_type') == 'all') {
            $this->service_type = '';
        }
        $query->andFilterWhere(['orders.mode' => $this->mode, 'services.id' => $this->service_type, 'orders.status' => $this->status]);

        if ($this->search_word) {

        switch ($this->search_type) {
            case 1:
                $query->andWhere(['=', 'orders.id', $this->search_word]);
                break;
            case 2:
                $query->andWhere(['like', 'orders.link', $this->search_word]);
                break;
            case 3:
                $query->andWhere(
                    [
                        'like',
                        'CONCAT(users.first_name, " ", users.last_name)',
                        $this->search_word
                    ]
                );
                break;
        }}
        return $dataProvider;
    }
}
