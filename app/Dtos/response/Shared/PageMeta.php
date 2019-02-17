<?php

namespace App\Dtos\Response\Shared;

class PageMeta
{
    private $hasNextPage;
    private $hasPrevPage;

    private $currentPageNumber;
    private $nextPageNumber;
    private $prevPageNumber;

    private $totalItemsCount;
    private $requestedPageSize;

    private $currentItemsCount;
    private $pageCount; // number of pages

    private $offset;

    private $nextPageUrl;
    private $prevPageUrl;

    public static function build($paginator, String $basePath)
    {
        $requested_page_size = $paginator->perPage();
        $currentPageNumber = $paginator->currentPage();
        $has_next_page = $paginator->lastPage() > $paginator->currentPage();
        $has_prev_page = $paginator->previousPageUrl() != null;

        if ($currentPageNumber < $paginator->lastPage()) {
            $nextPageUrl = sprintf("%s?page_size=%d&page=%d",
                $basePath, $requested_page_size,
                $currentPageNumber + 1);
            $nextPageNumber = $currentPageNumber + 1;
            $has_next_page = true;
        } else {
            $nextPageUrl = sprintf("%s?page_size=%d&page=%d",
                $basePath, $requested_page_size,
                $paginator->lastPage());

            $nextPageNumber = $paginator->lastPage();
            $has_next_page = false;
        }

        if ($has_prev_page) {
            $prevPageUrl = sprintf("%s?page_size=%d&page=%d",
                $basePath, $requested_page_size, min(1, $currentPageNumber - 1));
            $prevPageNumber = $currentPageNumber - 1;

        } else {
            $prevPageUrl = sprintf("%s?page_size=%d&page=%d",
                $basePath, $requested_page_size, 1);
            $prevPageNumber = 1;
        }
        return [
            'has_next_page' => $has_next_page,
            'has_prev_page' => $has_prev_page,
            'next_page_number' => $nextPageNumber,
            'prev_page_number' => $prevPageNumber,
            'next_page_url' => $nextPageUrl,
            'prev_page_url' => $prevPageUrl,
            'offset' => ($paginator->perPage() * ($paginator->currentPage() - 1)),
            'requested_page_size' => $paginator->perPage(),
            'total_items_count' => $paginator->total(),
            'current_items_count' => $paginator->perPage(),
            'page_count' => $paginator->lastPage(),
            'current_page_number' => $paginator->currentPage(),
        ];

    }

    public function isHasNextPage()
    {
        return $this->hasNextPage;
    }

    public function setHasNextPage($hasNext)
    {
        $this->hasNextPage = $hasNext;
    }

    public function isHasPrevPage()
    {
        return $this->hasPrevPage;
    }

    public function setHasPrevPage($hasPrevPage)
    {
        $this->$hasPrevPage = $hasPrevPage;
    }

    public function getCurrentPageNumber()
    {
        return $this->currentPageNumber;
    }

    public function setCurrentPageNumber(int $currentPageNumber)
    {
        $this->currentPageNumber = $currentPageNumber;
    }

    public function getNextPageNumber()
    {
        return $this->nextPageNumber;
    }

    public function setNextPageNumber(int $nextPageNumber)
    {
        $this->nextPageNumber = $nextPageNumber;
    }

    public function getPrevPageNumber()
    {
        return $this->prevPageNumber;
    }

    public function setPrevPageNumber(int $prevPageNumber)
    {
        $this->prevPageNumber = $prevPageNumber;
    }

    public function getTotalItemsCount()
    {
        return $this->totalItemsCount;
    }

    public function setTotalItemsCount(long $totalItemsCount)
    {
        $this->totalItemsCount = $totalItemsCount;
    }

    public function getRequestedPageSize()
    {
        return $this->requestedPageSize;
    }

    public function setRequestedPageSize(int $requestedPageSize)
    {
        $this->requestedPageSize = $requestedPageSize;
    }

    public function getCurrentItemsCount()
    {
        return $this->currentItemsCount;
    }

    public function setCurrentItemsCount(int $currentItemsCount)
    {
        $this->currentItemsCount = $currentItemsCount;
    }

    public function getPageCount()
    {
        return $this->pageCount;
    }

    public function setPageCount(int $pageCount)
    {
        $this->pageCount = $pageCount;
    }

    public function getOffset()
    {
        return $this->offset;
    }

    public function setOffset($offset)
    {
        $this->offset = $offset;
    }

    public function getNextPageUrl()
    {
        return $this->nextPageUrl;
    }

    public function setNextPageUrl(String $nextPageUrl)
    {
        $this->nextPageUrl = $nextPageUrl;
    }

    public function getPrevPageUrl()
    {
        return $this->prevPageUrl;
    }

    public function setPrevPageUrl(String $prevPageUrl)
    {
        $this->prevPageUrl = $prevPageUrl;
    }

}
