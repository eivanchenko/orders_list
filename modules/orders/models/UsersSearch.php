<?php

namespace app\modules\orders\models;

/**
 * Class UsersSearch
 * @package app\modules\orders\models
 */
class UsersSearch extends Users
{
    public $fullName;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'first_name', 'last_name'], 'safe'],
            [['fullName'], 'safe']
        ];
    }
}
