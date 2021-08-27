<?php

namespace app\modules\orders\models;

class UsersSearch extends Users
{
    public $full_name;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'first_name', 'last_name'], 'safe'],
            [['full_name'], 'safe']
        ];
    }
}
