<?php

namespace App\Dtos\Response\Order;


use App\Dtos\response\Order\Partials\OrderListDataSectionDto;
use App\Dtos\Response\Shared\PageMeta;
use App\Dtos\Response\Shared\SuccessResponse;

class OrderListDto
{

    public static function build($products, $base_path = '/orders', $includeOrderUser = false)
    {
        $productListDataSection = OrderListDataSectionDto::build(PageMeta::build($products, $base_path), $products->items(), $includeOrderUser);
        return array_merge(SuccessResponse::build(), [
            'data' => $productListDataSection
        ]);
    }


}
