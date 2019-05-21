<?php
namespace Ktpl\AdminGrid\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface AdminGridSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get pages list.
     *
     * @return \Ktpl\AdminGrid\Api\Data\AdminGridInterface[]
     */
    public function getItems();

    /**
     * Set pages list.
     *
     * @param \Ktpl\AdminGrid\Api\Data\AdminGridInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
