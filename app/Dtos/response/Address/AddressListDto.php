<?php

namespace App\Dtos\response\Address;


use App\Dtos\Response\Address\Partials\AddressDetailsDto;
use App\Dtos\Response\Shared\PageMeta;

class AddressListDto
{

    public static function build($addresses, $basePath, $includeUser = false)
    {
        $addresseDtos = array();
        foreach ($addresses as $address)
            $addresseDtos[] = AddressDetailsDto::build($address, $includeUser);
        return ['success' => true, 'page_meta' => PageMeta::build($addresses, $basePath), 'addresses' => $addresseDtos];
    }
}