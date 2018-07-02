<?php

namespace RC\Offices\Api\Data;

/**
 * Office Search Result Interface
 */
interface OfficeSearchResultInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * @return \RC\Offices\Api\Data\OfficeInterface[]
     */
    public function getItems();

    /**
     * @param \RC\Offices\Api\Data\OfficeInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}

