<?php

namespace App\Dtos\Response\Product;

use App\Dtos\Response\Product\Partials\ProductSummaryDto;
use App\Dtos\Response\Shared\PageMeta;
use App\Dtos\Response\Shared\SuccessResponse;

class ProductListDto
{

    public static function build($products, $base_path = '/products')
    {
        $pageMeta = PageMeta::build($products, $base_path);
        $productDtos = [];
        foreach ($products->items() as $key => $product) {
            $productDtos[] = ProductSummaryDto::build($product);
        }

        return array_merge(SuccessResponse::build(), [
            'page_meta' => $pageMeta,
            'products' => $productDtos
        ]);
    }


}
