<?php

namespace orders\components;

use Yii;

/**
 * Class OrdersHelpers
 */
class OrdersHelpers
{

    /**
     * @param string $type
     * @param string $parameter
     * @return string|null  along with the opening tag li
     */
    public static function getActiveClass(string $type, string $parameter): ?string
    {
        $liActive = '<li class="active">';
        $liNotActive = '<li>';
        $testExpression = Yii::$app->request->getQueryParam($type) == $parameter;

        if ($type == 'status' && $parameter == 'all') {
            return ($testExpression || Yii::$app->request->getQueryParam($type) == null) ? $liActive : $liNotActive;
        } elseif ($type == 'status') {
            return $testExpression ? $liActive : $liNotActive;
        } else {
            if ($parameter == 'all') {
                return ($testExpression || Yii::$app->request->getQueryParam($type) == null) ? 'active' : null;
            } else {
                return $testExpression ? 'active' : null;
            }
        }
    }
}
