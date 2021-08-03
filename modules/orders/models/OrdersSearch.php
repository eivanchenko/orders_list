<?php

namespace app\modules\orders\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\orders\models\Orders;

class OrdersSearch extends Orders
{

    public $full_name;
    public $status;
    public $searchstring;
    public $service_type;
    public function rules()
    {
        return [
            [['id', 'user_id',], 'integer'],
            [['link', 'mode'], 'string'],
            [['full_name', 'status', 'service_type'], 'safe']
        ];
    }


    public function scenarios()
    {
        return Model::scenarios();
    }

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

        $query->andWhere(
            'CONCAT_WS(" ", users.first_name, users.last_name) LIKE  "%' . $this->full_name . '%" ' .
                ' OR users.first_name LIKE "%' . $this->full_name . '%" ' .
                'OR users.last_name LIKE "%' . $this->full_name . '%"'
        );
        $query->andFilterWhere(['=', 'orders.id', $this->id]);
        $query->andFilterWhere(['like', 'orders.link', $this->link]);
        $query->andFilterWhere(['=', 'services.id', $this->service_type]);
        $query->andFilterWhere(['=', 'orders.mode', $this->mode]);

        return $dataProvider;
    }
}
