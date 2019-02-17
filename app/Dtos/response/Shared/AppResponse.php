<?php

namespace App\Dtos\Response\Shared;
abstract class AppResponse
{
    private $success;
    private $fullMessages;

    private $pageMeta;

    public function getSuccess() {
        return $this->success;
    }

    public function setSuccess(Boolean $success) {
        $this->success = $success;
    }

    public function getFullMessages() {
        return $this->fullMessages;
    }

    public function setFullMessages($fullMessages) {
        $this->fullMessages = $fullMessages;
    }


    function __con(boolean $success) {
        $this->success = $success;
        $fullMessages = new ArrayList();
    }

    public function isSuccess() {
        return $this->success;
    }


    protected function addFullMessage(String $message) {
        if ($this->fullMessages == null)
            $this->fullMessages = new ArrayList;

        $this->fullMessages->add(message);
    }


}
