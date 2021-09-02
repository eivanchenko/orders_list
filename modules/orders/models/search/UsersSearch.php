<?php

namespace app\modules\orders\models\search;

use app\modules\orders\models\Users;

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
    public function rules(): array
    {
        return [
            [['id', 'first_name', 'last_name'], 'safe'],
            [['fullName'], 'safe']
        ];
    }
}
