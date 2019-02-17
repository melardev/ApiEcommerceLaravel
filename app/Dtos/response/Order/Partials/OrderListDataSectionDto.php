<?php


namespace App\Dtos\response\Order\Partials;


class OrderListDataSectionDto
{
    public static function build($pageMeta, $orders, $includeOrderUser = false)
    {
        $orderSummaryDtos = [];
        foreach ($orders as $key => $order) {
            $orderSummaryDtos[] = OrderSummaryDto::build($order, $includeOrderUser);
        }
        return [
            'page_meta' => $pageMeta,
            'orders' => $orderSummaryDtos
        ];
    }
}