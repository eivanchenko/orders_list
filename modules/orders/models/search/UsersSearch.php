<?php

namespace orders\models\search;

use orders\models\Users;

/**
 * Class UsersSearch
 * @package orders\models
 */
class UsersSearch extends Users
{
    public $fullName;


    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'first_name', 'last_name'], 'safe'],
            [['fullName'], 'safe']
        ];
    }
}
