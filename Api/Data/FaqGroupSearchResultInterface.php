<?php

namespace Bluethink\Faq\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;
use Bluethink\Faq\Api\Data\FaqGroupInterface;

interface FaqGroupSearchResultInterface extends SearchResultsInterface
{
    /**
     * GetItems list method.
     *
     * @return FaqGroupInterface[]
     */
    public function getItems();

    /**
     * SetItems list method.
     *
     * @param array $items
     * @return FaqGroupSearchResultInterface
     */
    public function setItems(array $items);
}
