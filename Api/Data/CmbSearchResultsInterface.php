<?php
/**
 * Copyright © 2016 Magevolve Ltd. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Me\Cmb\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for Me Cmb search results
 *
 * @api
 */
interface CmbSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get cmb list.
     *
     * @return \Me\Cmb\Api\Data\CmbInterface[]
     */
    public function getItems();

    /**
     * Set cmb list.
     *
     * @param \Me\Cmb\Api\Data\CmbInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
