<?php


namespace App\Dtos\response\Order\Partials;


use App\Dtos\Response\User\Partials\UserOnlyUsernameDto;
use App\Models\Order;

class OrderSummaryDto
{
    public static function build($order, $includeUser = false)
    {
        $ooo = 2;
        $data = [
            'id' => $order->id,
            'tracking_number' => $order->tracking_number,
            'order_status' => Order::status_choices[$order->order_status | 0],
            'order_items_count' => $order->orderItems()->count(),
            'total' => $order->totalPrice()
        ];

        if ($includeUser)
            $data['user'] = UserOnlyUsernameDto::build($order->user);

        return $data;
    }
}