<?php

namespace app\modules\orders\models;

use GlobalsConst;
use yii\db\ActiveRecord;



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
            [['full_name', 'searchstring', 'status'], 'safe']

        ];
    }


    public function getUsers(): UsersQuery
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    public function getServices(): ServicesQuery
    {
        return $this->hasOne(Services::className(), ['id' => 'service_id']);
    }

    public function getservice_type()
    {
        return $this->services->name;
    }
    public function getfull_name()
    {
        return $this->users->first_name . ' ' . $this->users->last_name;
    }

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
