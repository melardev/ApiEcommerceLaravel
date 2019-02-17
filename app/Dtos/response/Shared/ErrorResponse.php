<?php

namespace App\Dtos\Response\Shared;

class ErrorResponse extends AppResponse
{
    protected $errors;

    public function __construct($errors)
    {
        super(false);
        $this->errors = errors;
        if ($this->getFullMessages() == null)
            $this->setFullMessages(new ArrayList <> (null));

        // $errors->forEach(($key, $value)->getFullMessages() . add(value . toString());
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function setErrors($errors)
    {
        $this->errors = errors;
    }


}
