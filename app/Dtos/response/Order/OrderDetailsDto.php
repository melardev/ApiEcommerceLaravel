<?php

namespace App\Dtos\Response\Order;

use App\Dtos\response\Category\Partials\BasicCategoryDto;
use App\Dtos\Response\Comment\CommentDetailsDto;
use App\Dtos\response\Order\Partials\OrderSummaryDto;
use App\Dtos\response\Tag\Partial\BasicTagDto;

class OrderDetailsDto
{

    public static function build($order)
    {
        return [
            'success' => true,
            'order' => OrderSummaryDto::build($order, false)
        ];
    }


}
