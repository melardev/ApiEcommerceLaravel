<?php

namespace App\Dtos\Response;

abstract class AbstractPagedDto
{
    private $pageMeta;

    public function __construct(PageMeta $pageMeta) {
        $this->pageMeta = $pageMeta;
    }

    public function getPageMeta() {
        return $this->pageMeta;
    }
}
