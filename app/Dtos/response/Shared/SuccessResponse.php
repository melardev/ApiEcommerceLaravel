<?php

namespace App\Dtos\Response\Shared;

class SuccessResponse extends AppResponse
{
    public function __construct() {
        parent::_construct(true);
    }

    public function SuccessResponse(String $message) {
        $this->addFullMessage($message);
    }

    public static function build() {
        return ['success' => true];
    }

}
