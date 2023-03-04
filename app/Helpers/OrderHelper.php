<?php

namespace App\Helpers;


class OrderHelper
{
    /**
     * @return string $orderNumber
     */
    public static function orderNumber()
    {
        return 'ORDER/' . time() . '/' . str_pad(date('Ymd'), 14, 0, STR_PAD_LEFT);
    }
}
