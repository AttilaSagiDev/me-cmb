<?php
/**
 * Copyright © 2016 Magevolve Ltd. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Me\Cmb\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Me\Cmb\Api\Data\CmbInterface;
use Magento\Framework\Exception\LocalizedException;
use Me\Cmb\Api\Data\CmbSearchResultsInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Me Cmb CRUD interface.
 *
 * @api
 */
interface CmbRepositoryInterface
{
    /**
     * Save Cmb item
     *
     * @param CmbInterface $cmb
     * @return CmbInterface
     * @throws LocalizedException
     */
    public function save(Data\CmbInterface $cmb);

    /**
     * Retrieve Cmb item
     *
     * @param int $cmbId
     * @return CmbInterface
     * @throws LocalizedException
     */
    public function getById($cmbId);

    /**
     * Retrieve Cmb item matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return CmbSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete Cmb item
     *
     * @param CmbInterface $cmb
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(Data\CmbInterface $cmb);

    /**
     * Delete Cmb item by ID.
     *
     * @param int $cmbId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById($cmbId);
}
