<?php

namespace app\modules\orders\models;

use Yii;
use GlobalsConst;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\helpers\ArrayHelper;

class Orders extends ActiveRecord
{

    public static function tableName()
    {
        return 'orders';
    }

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

    public function getService_type()
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

    public  static  function getUserServiceCount($user_id = 0, $service_id = 0)
    {
        // $data = Yii::$app->db->createCommand('SELECT `orders`.`id`, `orders`.`count`, `services`.`name` FROM ((SELECT `service_id` AS `id`, count(*) AS `count` FROM `orders` WHERE `user_id` = ' . $user_id . '  GROUP BY `service_id`) UNION ( SELECT 0, count(*) FROM `orders` )) `orders` LEFT JOIN `services` ON orders.id = services.id ORDER BY `services`.`id`')->queryAll();
        $data = Yii::$app->db->createCommand('SELECT `orders`.`id`, `orders`.`count`, `services`.`name` FROM ((SELECT `service_id` AS `id`, count(*) AS `count` FROM `orders` WHERE `service_id` = ' . $service_id . '  AND `user_id` = ' . $user_id . '  GROUP BY `service_id`) UNION ( SELECT 0, count(*) FROM `orders` )) `orders` LEFT JOIN `services` ON orders.id = services.id ORDER BY `services`.`id`')->queryAll();
        // return $data[$service_id]['count'] . ' ' . $data[$service_id]['name'];
        return '<span class="label-id"> '.  $data[1]['count'] . '</span>  ' . $data[1]['name'];
    }

    public static function getServicesTypesCount()
    {
        $data = Yii::$app->db->createCommand(
            'SELECT `orders`.`id`, `orders`.`count`, `services`.`name` FROM ((SELECT `service_id` AS `id`, count(*) AS `count` FROM `orders` GROUP BY `service_id`) UNION ( SELECT 0, count(*) FROM `orders` )) `orders` LEFT JOIN `services` ON orders.id = services.id ORDER BY `services`.`id`'
        )->queryAll();
        if ($data[0]['name'] == '') {
            $data[0]['name'] = 'All';
        }
        return $data;
        // return $data[$service_id]['count'] . ' ' . $data[$service_id]['name'];
    }

    public function getFull_name()
    {
        return $this->users->first_name . ' ' . $this->users->last_name;
    }

    // public static function  getSrc_type()
    // {
    //     $unionQuery = (new Query())->select(['0, count(*)'])->from('orders');
    //     $subQuery  = (new Query())->select('service_id as id, count(*) as count')->from('orders')->groupBy('service_id')->union($unionQuery);
    //     $MainQuery = new Query();
    //     $MainQuery->select('orders.id, orders.count, services.name')->from(['orders' => $subQuery])->join('LEFT JOIN', 'services', 'orders.id = services.id')->orderBy(['orders.count' => SORT_DESC])->all();
    //     $dataProvider = new ActiveDataProvider([
    //         'query' => $MainQuery,
    //     ]);
    //     return $dataProvider;
    // }


    // public static  function getList($user_id = 0)
    // {
    //     $unionQuery = (new Query())->select(['0, count(*)'])->from('orders');
    //     $subQuery  = (new Query())->select('service_id as id, count(*) as count')->from('orders')->where(['user_id'=>$user_id])->groupBy('service_id')->union($unionQuery);
    //     return ArrayHelper::toArray(
    //         static::find()
    //             ->select('orders.id, orders.count, services.name')->from(['orders' => $subQuery])
    //             ->join('LEFT JOIN', 'services', 'orders.id = services.id')
    //             ->orderBy(['orders.count' => SORT_DESC])
    //             ->asArray()
    //             ->all(),
    //         [
    //             'app\modules\orders\models\Orders' =>
    //             [
    //                 'id',
    //                 'name',
    //                 'count'
    //             ]
    //         ]
    //     );
    // }


    public function getStatus()
    {
        switch ($this->status) {
            case  0:
                return GlobalsConst::STATUS_PENDING;
                break;
            case 1:
                return GlobalsConst::STATUS_IN_PROGRESS;
                break;
            case 2:
                return GlobalsConst::STATUS_COMPLETED;
                break;
            case 3:
                return GlobalsConst::STATUS_CANCELED;
                break;
            case 4:
                return GlobalsConst::STATUS_ERROR;
                break;
        }
    }
    // public static function getStatus()
    // {
    //     return [
    //         GlobalsConst::STATUS_PENDING,

    //         GlobalsConst::STATUS_IN_PROGRESS,

    //         GlobalsConst::STATUS_COMPLETED,

    //         GlobalsConst::STATUS_CANCELED,

    //         GlobalsConst::STATUS_ERROR
    //     ];
    // }

    public static function getSearch_types()
    {
        return [
            ['id' => GlobalsConst::SEARCH_ORDER_ID, 'type' => 'Order ID'],

            ['id' => GlobalsConst::SEARCH_LINK, 'type' => 'Link'],

            ['id' => GlobalsConst::SEARCH_USER, 'type' => 'Username'],
        ];
    }

    public function getMode()
    {
        switch ($this->mode) {
            case 0:
                return GlobalsConst::MODE_MANUAL;
                break;
            case 1:
                return GlobalsConst::MODE_AUTO;
                break;
        }
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_name' => 'User',
            'link' => 'Link',
            'quantity' => 'Quantity',
            'service_id' => 'Service',
            'service_type' => 'Service Type',
            'status' => 'Status',
            'mode' => 'Mode',
            'created_at' => 'Created',
        ];
    }
    public static function find(): OrdersQuery
    {
        return new OrdersQuery(get_called_class());
    }
}
