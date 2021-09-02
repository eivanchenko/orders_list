<?php

namespace app\modules\orders\models;

use Yii;
use yii\db\ActiveRecord;
use app\modules\orders\models\query\OrdersQuery;



/**
 * This is the model class for table 'orders'
 * @package app\modules\orders\models
 * @property integer $id
 * @property mixed $user_id
 * @property integer $quantity
 * @property integer $created_at
 * @property mixed $serviceID
 * @property integer $status
 * @property integer $mode
 * @property string  $link
 * @property string  $fullName
 *
 * @property Users $users
 * @property Services $services
 */
class Orders extends ActiveRecord
{
    const SEARCH_ORDER_ID = 1;
    const SEARCH_LINK = 2;
    const SEARCH_USERNAME = 3;
    const MODE_TYPE_MANUAL = 0;
    const MODE_TYPE_AUTO = 1;
    const STATUS_TYPE_PENDING = 0;
    const STATUS_TYPE_PROGRESS = 1;
    const STATUS_TYPE_COMPLETED = 2;
    const STATUS_TYPE_CANCELED = 3;
    const STATUS_TYPE_ERROR = 4;

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
     * @return \yii\db\ActiveQuery
     */
    public function getUsers(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServices(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Services::class, ['id' => 'service_id']);
    }

    /**
     * @return string
     */
    public function getServiceType(): string
    {
        return $this->services->name;
    }

    /**
     * @return integer
     */
    public function getServiceID(): int
    {
        return $this->services->id;
    }

    /**
     * @return mixed
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
    public static function getStatusType(): array
    {
        return [
            ['id' => self::STATUS_TYPE_PENDING, 'type' => Yii::t('app', 'status.type.pending')],
            ['id' => self::STATUS_TYPE_PROGRESS, 'type' => Yii::t('app', 'status.type.inProgress')],
            ['id' => self::STATUS_TYPE_COMPLETED, 'type' => Yii::t('app', 'status.type.completed')],
            ['id' => self::STATUS_TYPE_CANCELED, 'type' => Yii::t('app', 'status.type.canceled')],
            ['id' => self::STATUS_TYPE_ERROR, 'type' => Yii::t('app', 'status.type.error')],
        ];
    }

    /**
     * @return array[]
     */
    public static function getSearchTypes(): array
    {
        return [
            ['id' => self::SEARCH_ORDER_ID, 'type' =>  Yii::t('app', 'search.type.orderID')],
            ['id' => self::SEARCH_LINK, 'type' => Yii::t('app',  'search.type.link')],
            ['id' => self::SEARCH_USERNAME, 'type' => Yii::t('app',  'search.type.username')],
        ];
    }

    /**
     * @return array
     */
    public static function getModeType(): array
    {
        return [
            ['id' => self::MODE_TYPE_MANUAL, 'type' => Yii::t('app', 'mode.manual')],
            ['id' => self::MODE_TYPE_AUTO, 'type' => Yii::t('app', 'mode.auto')]
        ];
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
