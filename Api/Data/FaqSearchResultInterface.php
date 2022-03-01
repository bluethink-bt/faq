<?php

namespace Bluethink\Faq\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;
use Bluethink\Faq\Api\Data\FaqInterface;
use Magento\Framework\Api\ExtensibleDataInterface;

interface FaqSearchResultInterface extends SearchResultsInterface
{
    /**
     * GetItems list method.
     *
     * @return FaqInterface[]
     */
    public function getItems();

    /**
     * SetItems list method.
     *
     * @param array $items
     * @return FaqSearchResultInterface
     */
    public function setItems(array $items);
}
