<?php

namespace App\Dtos\Response\Address\Partials;

class AddressDetailsDto
{

    public static function build($address, $includeUser = false)
    {
        $data = [
            'id' => $address->id,
            'city' => $address->city,
            'address' => $address->address,
            'country' => $address->country,
            'zip_code' => $address->zip_code,
        ];

        if ($includeUser)
            $data['user'] = $address->user;

        return $data;
    }


}
