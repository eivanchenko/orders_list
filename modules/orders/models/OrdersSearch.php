<?php

namespace app\modules\orders\models;

use Yii;
use yii\base\Model;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use app\modules\orders\models\Orders;

class OrdersSearch extends Orders
{
    public $full_name;
    public $status;
    public $searchstring;
    public $service_type;
    public $service_id;



    public function rules()
    {
        return [
            [['id', 'user_id',], 'integer'],
            [['link', 'mode'], 'string'],
            [['full_name', 'status', 'service_type','service_id'], 'safe']
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



        // $unionQuery = (new Query())->select(['0, count(*)'])->from('orders');
        // $subQuery  = (new Query())->select('service_id as id, count(*) as count')->from('orders')->where(['user_id'=>$this->user_id])->groupBy('service_id')->union($unionQuery);
        // $MainQuery = new Query();
        // $MainQuery->select('orders.id, orders.count, services.name')->from(['orders' => $subQuery])->join('LEFT JOIN', 'services', 'orders.id = services.id')->orderBy(['orders.count' => SORT_DESC])->all();
        // $query->leftJoin(['serviceCount' => $MainQuery], 'serviceCount.id = orders.id');

        // $unionQuery = ($query)->select(['0, count(*)'])->from('orders');
        // $subQuery  = ($query)->select('service_id as id, count(*) as count')->from('orders')->groupBy('service_id')->union($unionQuery);
        // $query->select('orders.id, orders.count, services.name')->from($subQuery)->orderBy(['orders.count' => SORT_DESC])->all();
        // $query->leftJoin(['serviceCount' => $MainQuery], 'serviceCount.id = orders.id');
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
        if ($this->service_type == 0) {
            $this->service_type = '';
        }
        $query->andFilterWhere(['=', 'orders.id', $this->id]);
        $query->andFilterWhere(['like', 'orders.link', $this->link]);
        $query->andFilterWhere(['=', 'services.id', $this->service_type]);
        $query->andFilterWhere(['=', 'orders.status', $this->status]);
        $query->andFilterWhere(['=', 'orders.mode', $this->mode]);

        return $dataProvider;
    }
}
